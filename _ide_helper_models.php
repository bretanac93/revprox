<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\ReverseProxy
 *
 * @property int $id
 * @property string $name
 * @property string $server_ip
 * @property string $proxy_dns
 * @property bool $has_ssl
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\ReverseProxy whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ReverseProxy whereHasSsl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ReverseProxy whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ReverseProxy whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ReverseProxy whereProxyDns($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ReverseProxy whereServerIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ReverseProxy whereUpdatedAt($value)
 */
	class ReverseProxy extends \Eloquent {}
}

