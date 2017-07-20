<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utilities;

/**
 * Description of StringTools
 *
 * @author Nico
 */
class StringTools {
    public static function displayCleanDistance($distanceMeters){
        $cleanDistance = 0;
        if($distanceMeters < 1000){
            $cleanDistance = round($distanceMeters /10) * 10;
            $cleanDistance .= ' m';
        } else {
            $cleanDistance = round($distanceMeters /100) / 10;
            $cleanDistance .= ' km';
        }
        $cleanDistance = str_replace('.', ',', $cleanDistance);
        return $cleanDistance;
    }
}
