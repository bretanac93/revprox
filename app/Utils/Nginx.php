<?php
/**
 * Created by PhpStorm.
 * User: bretanac93
 * Date: 2/11/17
 * Time: 10:13 AM
 */

namespace App\Utils;

use Symfony\Component\Process\Process;

class Nginx
{
    use ExtraMethods;

    /**
     * Check if the server is running by a root user.
     * @return bool $result
     */
    private function isRootProcess() {

        return $this->exec('whoami') === "www-data\n";
    }

    /**
     * Remove the temp files created in the project.
     */
    private function flushTemp() {
        $this->exec('sudo rm -rf temp/');
    }


    /**
     * Generates temp log file to check if the test command contains any error.
     */
    private function generateTestsFile() {
        $output = $this->exec('sudo nginx -t');
        $this->exec("sudo mkdir test && sudo echo $output > temp/file.test");
    }

    private function testFileContent() {
        return $this->exec('sudo cat temp/file.test');
    }

    /**
     * Check if the test file contains any error
     * @return bool
     */
    private function containsErrors() {
        $output = $this->exec("sudo cat temp/file.test| grep emerg");
        return strlen($output) != 0;
    }
    /**
     * Executes a `nginx -t` command to check if everything is good.
     */
    public function testConfiguration() {
        if (!$this->isRootProcess()) {
            throw new \BadMethodCallException('El proceso no está siendo ejecutado con permisos de administración.');
        }
        else {
            $this->generateTestsFile();
            if ($this->containsErrors())
                return $this->testFileContent();
            return null;
        }
    }

    /**
     * Restart the nginx process.
     */
    public function rebootNginxInstance() {
        $this->exec('sudo service nginx restart');
    }

    /**
     * Generates nginx configuration file corresponding to the following parameters.
     * @param $proxy_dns string Proxy DNS
     * @param $server_ip string Server IP
     * @param $available_routes Determine which routes are going to be allowed to access to the service
     * @param $has_ssl boolean Determine whether the created proxy
     * should be secure or not
     * @return array The first position will contains if the operation was completed or not
     * and the second one will be the reason, if the pos0 == true then pos1 = null.
     */
    public function genNginxFile($proxy_dns, $server_ip, $available_routes, $has_ssl) {

        if (!$this->isRootProcess()) {
            throw new \BadMethodCallException('El proceso no está siendo ejecutado con permisos de administración.');
        }

        // Make a backup in case the file exists.
        if (file_exists("/etc/nginx/sites-available/$proxy_dns")) {
            $this->exec("sudo mv /etc/nginx/sites-available/$proxy_dns /etc/nginx/sites-available/$proxy_dns.bak");
            $this->exec("sudo rm /etc/nginx/sites-enabled/$proxy_dns");
        }

        $script = $has_ssl ? "gen_ssl_file.sh" : "gen_http_file.sh";

        $this->exec("sudo cp nginx_routes/$available_routes.conf /etc/nginx/routes/$available_routes.conf");

        $p = new Process("sudo sh $script $proxy_dns $available_routes $server_ip");
        $p->run();

        if (!$p->isSuccessful()) {
            throw new \RuntimeException($p->getErrorOutput());
        }
        else {

            $res = $this->testConfiguration();
            if ($res == null) {
                $this->rebootNginxInstance();
                $this->flushTemp();
                return [true, null];
            }
            return [false, $res];
        }
    }

    /**
     * Remove a configuration file and test nginx
     * @param $proxy_dns string The Proxy url
     * @return array The first position will contains if the operation was completed or not
     * and the second one will be the reason, if the pos0 == true then pos1 = null.
     */
    public function removeFile($proxy_dns) {
        $this->exec("sudo rm -f /etc/nginx/sites-available/$proxy_dns && sudo rm -f /etc/nginx/sites-enabled/$proxy_dns /etc/nginx/sites-available/$proxy_dns.bak");
        $res = $this->testConfiguration();
        if ($res == null) {
            $this->rebootNginxInstance();
            $this->flushTemp();
            return [true, null];
        }
        return [false, $res];
    }

    /**
     * Get the content of a file given it's name
     * @param $proxy_dns The filename
     * @return string The content of the file
     */
    public function getFile($proxy_dns) {
        return $this->exec("sudo cat /etc/nginx/sites-available/$proxy_dns");
    }

    /**
     * Makes a symlink of a file on sites_enabled to activate the site
     * @param $proxy_dns The filename
     */
    public function upSite($proxy_dns) {
        $this->exec("sudo ln -fs /etc/nginx/sites-available/$proxy_dns /etc/nginx/sites-enabled/$proxy_dns");
    }

    /**
     * Removes the symlink of the file on sites_enabled to deactivate the site
     * @param $proxy_dns The filename
     */
    public function downSite($proxy_dns) {
        $this->exec("sudo rm -f /etc/nginx/sites-enabled/$proxy_dns");
    }

    /**
     * Activates maintenance mode of a website given the dns
     * @param $proxy_dns The filename
     */
    public function onMaintenance($proxy_dns) {
        $this->exec("sudo cp -f maintenance_templates/503.html /etc/nginx/maintenance/503_$proxy_dns.html");
    }

    /**
     * Deactivates maintenance mode of a website given the dns
     * @param $proxy_dns The filename
     */
    public function offMaintenance($proxy_dns) {
        $this->exec("sudo rm -f /etc/nginx/maintenance/503_$proxy_dns.html");
    }

    /**
     * Process the file content, extracts info and generates
     * the new configuration file
     * @param $file_content The File content
     * @return array The first position will hold the extracted data,
     * and the second one the result of the file generation.
     */
    public function processFileData($file_content) {
        $string_col = explode("\r\n", $file_content);

        $col = collect($string_col);
        $to_forget = [];

        for ($i = 0; $i < count($string_col); $i++) {
            $item = $string_col[$i];
            if (!strpos($item, "listen") && !strpos($item, "server_name") && !strpos($item, "proxy_pass")) {
                array_push($to_forget, $i);
            }
        }
        $col->forget($to_forget);

        $col = $col->map(function ($item) {
            $item = trim($item);

            $col = collect(explode(" ", $item))->toArray();

            for ($i = 0; $i < count($col); $i++) {
                if ($this->contains(';', $col[$i]));
                $col[$i] = trim($col[$i], ';');
            }

            return $col;
        });

        $data = $this->transformPattern($col);
        $data['server_ip'] = $this->cleanIp($data['server_ip']);
        $gen_res = $this->genNginxFile($data["proxy_dns"], $data["server_ip"], "mes", $data["has_ssl"]);

        return [$data, $gen_res];
    }

    /**
     * Transforms given data to readable array.
     * @param $data array|Collection The extracted data from the modified file.
     * @return array The readable array.
     */
    public function transformPattern($data) {
        $translator = ['server_name' => 'proxy_dns', 'proxy_pass' => 'server_ip', 'listen' => 'has_ssl'];
        $pattern = [];

        foreach ($data as $item) {
            /* Check if the length of the current item is greater than 2.
             * This operation is because is a fact that the only item with more than 2
             * elements is `listen`, but this rule is not mandatory, it can exists the possibility
             * that the value of this key is 443 without ssl or 80, in this case we have to check this as well.
            */
            if (strcmp($item[0], 'listen') == 0) {
                $pattern[$translator[$item[0]]] = strcmp("443", $item[1]) == 0;
            }
            else {
                $pattern[$translator[$item[0]]] = $item[1];
            }
        }
        return $pattern;
    }

    /**
     * @param $name The filename to be used
     * @param $ip_blocks The IP Blocks in CSV format
     * @return bool Whether the file was created or not
     */
    public function createRouteFile($name, $ip_blocks) {
        // Split the ip_blocks, is a csv so it's easy to parse :)
        // We put the result array on a Eloquent Collection for concat every
        // ip address with `allow `, using this we build the nginx route file
        $blocks = collect(explode(',', $ip_blocks))->map(function ($item) {
            return "allow $item;";
        })->toArray();

        array_push($blocks, "deny all;");
//        dd($blocks);

        $str = "";

        foreach ($blocks as $item) {
            $str .= "$item\r\n";
        }
        $slug = str_slug($name);
        $res = file_put_contents("/etc/nginx/routes/$slug.conf", $str);

        return true ? $res > 0 : false;
    }

    public function removeRouteFile($slug) {
        $this->exec("sudo rm -rf /etc/nginx/routes/$slug.conf");
    }

    private function cleanIp($ip) {
        return trim($ip, "http://");
    }
}
