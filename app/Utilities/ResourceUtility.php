<?php
namespace App\Utilities;

use Illuminate\Support\Facades\DB;

/**
 * Description of ResourceUtility
 *
 * @author TREND-DEPOT
 */
class ResourceUtility {
    public static function getAvailableValues($table, $column){
        $values = DB::table($table)->distinct($column)->select($column)
                ->orderBy($column, 'ASC')
                ->get();
        return $values
                ->map(function($item, $key) use ($column){
                    return $item->$column;
                })->toArray();
    }
    
    public static function getLabelIndexedByUuid($collection, $idAttributes, $labelAttributes){
        
    }
}
