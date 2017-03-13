<?php
/**
 * Created by PhpStorm.
 * User: bretanac93
 * Date: 3/13/17
 * Time: 2:39 PM
 */

namespace App\Utils;

trait ExtraMethods {
    public function contains($param, $str) {
        foreach ($this->toCharArray($str) as $char) {
            if ($char == $param)
                return true;
        }
        return false;
    }

    public function toCharArray($str) {
        $res = [];
        for ($i = 0; $i < strlen($str); $i++) {
            array_push($res, $str[$i]);
        }
        return $res;
    }
}