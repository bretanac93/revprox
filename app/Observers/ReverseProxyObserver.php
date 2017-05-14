<?php

namespace App\Observers;

use App\ReverseProxy;

class ReverseProxyObserver
{
	use AuditLogger;
	
    public function created(ReverseProxy $reverse_proxy)
    {
        $who  = \Auth::user()->id;
        $data = [
            'user_id'     => $who,
            'description' => "Creación de {$reverse_proxy->name}",
            'operation'   => 'A',
        ];
        $this->log($data);
    }

    public function updated(ReverseProxy $reverse_proxy)
    {
    	$who  = \Auth::user()->id;
        $data = [
            'user_id'     => $who,
            'description' => "Actualización de {$reverse_proxy->name}",
            'operation'   => 'U',
        ];
        $this->log($data);
    }

    public function deleted(ReverseProxy $reverse_proxy)
    {
    	$who  = \Auth::user()->id;
        $data = [
            'user_id'     => $who,
            'description' => "Eliminación de {$reverse_proxy->name}",
            'operation'   => 'D',
        ];
        $this->log($data);
    }
}
