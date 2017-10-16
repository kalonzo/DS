<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateOrderController extends Controller
{
    
/**
 * changeOrder
 * 
 * the request should be in format {Table: "table_name", 0: "uuid"...n:"uuid"}
 * will update the items in table position based upon uuid of items
 * 
 * @param request
 * 
 */
    public function changeOrder(Request $request) {
        $table = $request->get('table');
        $keyByPosition = $request->get('keyByPosition');
        
        switch ($table) {
            case \App\Models\EstablishmentMedia::TABLENAME:
                foreach($keyByPosition as $position => $key){
                    if(checkModelId($key)){
                        DB::table($table)->whereRaw("id = unhex('$key')")->update(['position' => $position]);
                    }
                }
            break;
        }
    }
}
