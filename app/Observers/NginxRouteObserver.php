<?php

namespace App\Observers;

use App\NginxRoute;

class NginxRouteObserver
{
    use AuditLogger;

    public function creating(NginxRoute $n_route)
    {
        $who  = \Auth::user()->id;
        $data = [
            'user_id'     => $who,
            'description' => '',
            'operation'   => '',
        ];

        if (NginxRoute::where('filename', $n_route->filename)->first() === null) {
            $data['description'] = "Creación de {$n_route->filename}";
            $data['operation']   = 'A';
        } else {
            $data['description'] = "Actualización de {$n_route->filename}";
            $data['operation']   = 'U';
        }

        $this->log($data);
    }

    public function deleted(NginxRoute $n_route)
    {
        $who  = \Auth::user()->id;
        $data = [
            'user_id'     => $who,
            'description' => "Eliminación de {$n_route->filename}",
            'operation'   => 'D',
        ];
        $this->log($data);
    }

    public function updated(NginxRoute $n_route)
    {
    	$who  = \Auth::user()->id;
        $data = [
            'user_id'     => $who,
            'description' => "Actualización de {$n_route->filename}",
            'operation'   => 'U',
        ];
        $this->log($data);
    }
}
