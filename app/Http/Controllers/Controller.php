<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\Process\Process;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $proxy_dns string Proxy DNS
     * @param $server_ip string Server IP
     * @param $has_ssl boolean Determine whether the created proxy
     * should be secure or not
     */
    public function generate_nginx_file($proxy_dns, $server_ip, $has_ssl) {
        $script = $has_ssl ? "gen_ssl_file.sh" : "gen_http_file.sh";

        $p = new Process("sh $script $proxy_dns $server_ip");
        $p->run();

        if (!$p->isSuccessful()) {
            throw new \RuntimeException($p->getErrorOutput());
        }
    }
}
