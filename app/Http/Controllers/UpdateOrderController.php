<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\DB;

class UpdateOrderController extends Controller
{
    //the request should be in format {Table: "table_name", 0: "uuid"...n:"uuid"}
    //will update the items in table position based upon uuid of items
    public function ChangeOrder(Request $request) {
        

        $input = $request -> all();
        //return this to dump to the ajax for checking purposes 
        
        //get the Table
        $table = $input['Table'];
        //sanitize table input
        $table = htmlspecialchars($table);
        //remove backslashs
        $table = str_replace('\\', '', $table);
        
        //remove table to only getkeys
        unset($input['Table']);
        var_dump($input);
        var_dump($table);
        
        switch ($table) {
            //Targets establishment_medias table
            case 'establishment_medias':
                for($i = 0; $i < count($input);$i++){
                    //sanitize and check inputs hex strings
                    $input[$i] = htmlspecialchars($input[$i]);
                    //remove backslashs
                    $input[$i] = str_replace('\\', '', $input[$i]);
                    var_dump($input[$i]);
                    
                    //SQL statement, position is set as clean statement, reason is '' needs to be on HEX
                    //so unhex function can work properly to convert to binary, throws off prep statement
                    if(strlen($input[$i]) == 32){
                        DB::statement("update $table set position =:position  where id = unhex('$input[$i]')", array('position' => $i));
                    }
                }
                
            break;
             
        }
        
    }
}
