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
    
    public static function getDayLabelFromIndex($index){
        $dayLabel = null;
        $days = self::getDaysArray();
        if(isset($days[$index])){
            $dayLabel = $days[$index];
        }
        return $dayLabel;
    }
    
    public static function getDaysFirstLetterArray($startIndex = 1){
        $days = self::getDaysArray();
        
        $res = array();
        $counter = 0;
        for($i = $startIndex; $i <= 7, $counter <= 7; $i++){
            $res[$counter] = substr($days[$i], 0, 1);
            $counter++;
            if($i === 7 && $counter < 7){
                $i = 0;
            }
        }
        
        return $res;
    }
    
    public static function getStringTimestpFromDate($date){
        return str_replace([' ', '-', ':'], '', $date);
//        $timestp = null;
//        $dateHourSplitted = explode(' ', $date);
//        $dateSplitted = explode('-', $dateHourSplitted[0]);
//        $hourSplitted = explode(':', $dateHourSplitted[1]);
//        if(count($dateSplitted) === 3 && count($hourSplitted) === 3){
//            $timestp = $dateSplitted[2].$dateSplitted[1].$dateSplitted[0];
//            $timestp .= $hourSplitted[0].$hourSplitted[1].$hourSplitted[2];
//        }
//        return $timestp;
    }
}
