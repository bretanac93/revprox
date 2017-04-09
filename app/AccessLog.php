<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    public $fillable = [
        'host',
        'user',
        'time',
        'request',
        'status',
        'sent_bytes',
        'referrer',
        'user_agent'
    ];
}
