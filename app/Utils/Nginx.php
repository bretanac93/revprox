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

    /**
     * Check if the server is running by a root user.
     * @return bool $result
     */
    private function isRootProcess() {

        return $this->exec('whoami') === "root\n";
    }

    /**
     * Method for process execution abstraction
     * @param $command string The command to execute i.e. 'ls -al'
     * @return string The Output of the command
     */
    private function exec($command) {
        $p = new Process("$command");
        $p->run();
        return $p->getOutput();
    }

    /**
     * Remove the temp files created in the project.
     */
    private function flushTemp() {
        $this->exec('rm -rf temp/');
    }


    /**
     * Generates temp log file to check if the test command contains any error.
     */
    private function generateTestsFile() {
        $output = $this->exec('nginx -t');
        $this->exec("mkdir test && echo $output > temp/file.test");
    }

    private function testFileContent() {
        return $this->exec('cat temp/file.test');
    }

    /**
     * Check if the test file contains any error
     * @return bool
     */
    private function containsErrors() {
        $output = $this->exec("cat temp/file.test| grep emerg");
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
        $this->exec('service nginx restart');
    }

    /**
     * Generates nginx configuration file corresponding to the following parameters.
     * @param $proxy_dns string Proxy DNS
     * @param $server_ip string Server IP
     * @param $has_ssl boolean Determine whether the created proxy
     * should be secure or not
     * @return array The first position will contains if the operation was completed or not
     * and the second one will be the reason, if the pos0 == true then pos1 = null.
     */
    public function genNginxFile($proxy_dns, $server_ip, $has_ssl) {

        if (!$this->isRootProcess()) {
            throw new \BadMethodCallException('El proceso no está siendo ejecutado con permisos de administración.');
        }

        $script = $has_ssl ? "gen_ssl_file.sh" : "gen_http_file.sh";

        $p = new Process("sh $script $proxy_dns $server_ip");
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
        $this->exec("rm -f /etc/nginx/sites-available/$proxy_dns");
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
        return $this->exec("cat /etc/nginx/sites-available/$proxy_dns");
    }

    /**
     * Makes a symlink of a file on sites_enabled to activate the site
     * @param $proxy_dns The filename
     */
    public function upSite($proxy_dns) {
        $this->exec("ln -fs /etc/nginx/sites-available/$proxy_dns /etc/nginx/sites-enabled/$proxy_dns");
    }

    /**
     * Removes the symlink of the file on sites_enabled to deactivate the site
     * @param $proxy_dns The filename
     */
    public function downSite($proxy_dns) {
        $this->exec("rm -f /etc/nginx/sites-enabled/$proxy_dns");
    }

    /**
     * Activates maintenance mode of a website given the dns
     * @param $proxy_dns The filename
     */
    public function onMaintenance($proxy_dns) {
        $this->exec("cp -f maintenance_templates/503.html /etc/nginx/maintenance/503_$proxy_dns.html");
    }

    /**
     * Deactivates maintenance mode of a website given the dns
     * @param $proxy_dns The filename
     */
    public function offMaintenance($proxy_dns) {
        $this->exec("rm -f /etc/nginx/maintenance/503_$proxy_dns.html");
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
             * elements is `listen`, but this rule is not mandatory, can exists the possibility
             * that the value of this key be 443 without ssl or 80, in this case we got to check this as well.
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
}