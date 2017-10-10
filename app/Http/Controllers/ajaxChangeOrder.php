<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\DB;


class ajaxChangeOrder extends Controller
{   
    //the request should be in format {Table: "table_name", 0: "uuid"...n:"uuid"}
    //will update the items in table position based upon uuid of items
    public function ajaxChangeOrder(Request $request) {
        
        //treat request
        //$updated = new Media; 
        $input = $request -> all();
        //return this to dump to the ajax for checking purposes 
        var_dump($input);
        //get the Table
        $table = $input['Table'];
        
        //remove table to only getkeys
        unset($input['Table']);
        
        switch ($table) {
            //estMedia Targets establishment_medias table
            case 'estMedia':
                for($i = 0; $i < count($input);$i++){
                    //sanitize and check inputs hex strings
                    $input[$i] = htmlspecialchars($input[$i]);
                    //remove backslashs
                    $input[$i] = str_replace('\\', '', $input[$i]);
                    var_dump($input[$i]);
                    
                    //SQL statement, position is set as clean statement, reason is '' needs to be on HEX
                    //so unhex function can work properly to convert to binary, throws off prep statement
                    if(strlen($input[$i]) == 32){
                        DB::statement("update establishment_medias set position =:position  where id = unhex('$input[$i]')", array('position' => $i));
                    }
                }
                
            break;
             
        }
        
    }
}
