<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    public $fillable = [
        'user_id',
        'description',
        'operation',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
