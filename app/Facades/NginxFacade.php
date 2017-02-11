<?php
/**
 * Created by PhpStorm.
 * User: bretanac93
 * Date: 2/11/17
 * Time: 11:06 AM
 */

namespace App\Facades;


use App\Utils\Nginx;
use Illuminate\Support\Facades\Facade;

class NginxFacade extends Facade
{
    /**
     * @return array
     */
    protected static function getFacadeAccessor() {
        return Nginx::class;
    }
}