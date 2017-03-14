<?php
/**
 * Created by PhpStorm.
 * User: bretanac93
 * Date: 3/13/17
 * Time: 2:39 PM
 */

namespace App\Utils;

use Symfony\Component\Process\Process;

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

    /**
     * Method for process execution abstraction
     * @param $command string The command to execute i.e. 'ls -al'
     * @return string The Output of the command
     */
    public function exec($command) {
        $p = new Process("$command");
        $p->run();
        return $p->getOutput();
    }
}