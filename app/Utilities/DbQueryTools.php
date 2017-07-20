<?php

namespace App\Utilities;

use App\Models\Utilities\LatLng;

/**
 * Description of DbQueryTools
 *
 * @author Nico
 */
class DbQueryTools {
    /**
     * 
     * @param LatLng $fromLatLng
     * @param type $tableName
     * @param type $latitudeFieldName
     * @param type $longitudeFieldName
     * @param type $returnValue
     * @return string
     */
    public static function genRawSqlForDistanceCalculation(LatLng $fromLatLng, $tableName, $latitudeFieldName = 'latitude', $longitudeFieldName = 'longitude',
                            $returnValue = 'rawDistance'){
        $rawSql = "";
        if ($fromLatLng->isValid()){
            $rlo1 = ' radians('.$fromLatLng->getLng().') ';
            $rla1 = ' radians('.$fromLatLng->getLat().') ';
            $rlo2 = ' radians('.$tableName.'.'.$longitudeFieldName.') ';
            $rla2 = ' radians('.$tableName.'.'.$latitudeFieldName.') ';
            $dlo = '('.$rlo2.' - '.$rlo1.') / 2 ';
            $dla = '('.$rla2.' - '.$rla1.') / 2 ';
            $a = '(sin('.$dla.') * sin('.$dla.')) + cos('.$rla1.') * cos('.$rla2.') * (sin('.$dlo.') * sin('.$dlo.'))';
            $d = '2 * atan2(sqrt('.$a.'), sqrt(1 - '.$a.')) ';
            $distance = GeolocTools::EARTH_RADIUS.' * '.$d;
            
            $rawSql = ' ('.$distance.') AS '.$returnValue.' ';
        }
        return $rawSql;
    }
    
    public static function genRawSqlForWhereInUuidList($tableName, $tableField, $uuidArray){
        $rawSql = "";
        if(!empty($uuidArray)){
            $inValues = implode(',', $uuidArray);
            $inValuesStringified = "'".str_replace(',',  "','", $inValues)."'";
            $rawSql = ' HEX('.$tableName.'.'.$tableField.') IN ('.$inValuesStringified.') ';
        }
        return $rawSql;
    }
}
