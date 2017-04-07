<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NginxRoute extends Model
{
    protected $fillable = [
        'name',
        'ip_allow'
    ];
}
