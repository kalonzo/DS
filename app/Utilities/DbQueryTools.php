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
    
    /**
     * Generate raw SQL to put in whereRaw() query builder function to make some restriction on a single UUID or an array of UUIDs
     * @param string $tableField
     * @param string|array $uuidRef
     * @param string $tableName
     * @return string
     */
    public static function genSqlForWhereRawUuidConstraint($tableField, $uuidRef, $tableName = '', $notIn = false){
        $rawSql = "1 = 0";
        if(!empty($uuidRef)){
            if(is_array($uuidRef)){
                $inValues = implode(',', $uuidRef);
                $inValuesStringified = "'".str_replace(',',  "','", $inValues)."'";
                $rawSql = ' HEX(';
                if(!empty($tableName)){
                    $rawSql .= $tableName.'.';
                }
                $rawSql .= $tableField.') ';
                if($notIn){
                    $rawSql .= ' NOT ';
                }
                $rawSql .= ' IN ('.$inValuesStringified.') ';
            } else {
                $rawSql = ' HEX(';
                if(!empty($tableName)){
                    $rawSql .= $tableName.'.';
                }
                $rawSql .= $tableField.')  = "'.$uuidRef.'" ';
            }
        }
        return $rawSql;
    }
    
    /**
     * 
     * @param type $tableField
     * @param type $tableName
     * @param type $alias
     * @return string
     */
    public static function genRawSqlForGettingUuid($tableField = 'id', $tableName = '', $alias = 'uuid'){
        $rawSql = ' LOWER(HEX(';
        if(!empty($tableName)){
            $rawSql .= $tableName.'.';
        }
        $rawSql .= $tableField.')) AS '.$alias;
        return $rawSql;
    }
    
    /**
     * 
     * @param \Illuminate\Database\Query\Builder $query
     * @param LatLng $refLatLng
     * @param type $distance
     * @param type $tableName
     * @param type $latFieldName
     * @param type $lngFieldName
     */
    public static function setGeolocLimits($query, LatLng $refLatLng, $distance, $tableName, $latFieldName = 'latitude', $lngFieldName = 'longitude'){
        $success = false;
        if(!empty($query)){
            // Search by proximity
            $squareCoordinates = GeolocTools::getSquareCoordinates($refLatLng, $distance*1000);

            $minLat = 0.0;
            $minLng = 0.0;
            $maxLat = 0.0;
            $maxLng = 0.0;
            foreach($squareCoordinates as $squareCoordinate){
                if($minLat == 0 || $squareCoordinate->getLat() < $minLat){
                    $minLat = $squareCoordinate->getLat();
                }
                if($minLng == 0 || $squareCoordinate->getLng() < $minLng){
                    $minLng = $squareCoordinate->getLng();
                }
                if($maxLat == 0 || $squareCoordinate->getLat() > $maxLat){
                    $maxLat = $squareCoordinate->getLat();
                }
                if($maxLng == 0 || $squareCoordinate->getLng() > $maxLng){
                    $maxLng = $squareCoordinate->getLng();
                }
            }
//            print_r($distance);
//            print_r(['$minLat'=>$minLat, '$minLng'=>$minLng, '$maxLat'=>$maxLat, '$maxLng'=>$maxLng]);
            if(!empty($minLat) && !empty($maxLat) && !empty($minLng) && !empty($maxLng)){
                $query->whereBetween($tableName.'.'.$latFieldName, array($minLat, $maxLat))
                    ->whereBetween($tableName.'.'.$lngFieldName, array($minLng, $maxLng));
                $success = true;
            } else {
                $query->whereRaw(' 1=0 ');
            }
        }
        return $success;
    }
}
