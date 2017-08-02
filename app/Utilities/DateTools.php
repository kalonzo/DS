<?php

namespace App\Utilities;

/**
 * Description of DateTools
 *
 * @author Nico
 */
class DateTools {
    public static function getDaysArray(){
        $days = array();
        $days[1] = 'Lundi';
        $days[2] = 'Mardi';
        $days[3] = 'Mercredi';
        $days[4] = 'Jeudi';
        $days[5] = 'Vendredi';
        $days[6] = 'Samedi';
        $days[7] = 'Dimanche';
        return $days;
    }
}
