<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NginxRoute extends Model
{
    protected $fillable = ['real_path', 'downloadable', 'filename'];

    public function reverse_proxies()
    {
    	return $this->hasMany(ReverseProxy::class, 'route_id', 'id');
    }
}
