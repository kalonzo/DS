<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Models\Media;
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
        $input = $request -> all();
        $table = $input['table'];
        $position = $input['position'];
        
        switch ($table) {
            case 'establishment_medias':
                for($i = 0; $i < count($position); $i++){
                    if(checkModelId($position[$i])){
                        DB::table($table)->whereRaw("id = unhex('$position[$i]')")->update(['position' => $i]);
                    }
                }
                
            break;
             
        }
        
    }
}
