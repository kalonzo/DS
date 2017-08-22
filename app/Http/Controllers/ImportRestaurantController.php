<?php

namespace App\Http\Controllers;

use App\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use View;

class ImportRestaurantController extends Controller {

    /**
     * 
     * @return View
     */
    public function index() {
        $view = View::make('establishment.import');
        return $view;
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function import(Request $request) {
        $file = \Illuminate\Support\Facades\Request::file('excel');
        if(!empty($file)){
            if ($file->isValid()) {
                $relPath = $file->store('/import_tmp');
                $absolutePath = Storage::path($relPath);
                
                Excel::load($absolutePath, function($reader) {
                    $sheets = $reader->all();
                    if(!empty($sheets)){
                        foreach($sheets as $sheet){
                            foreach($sheet as $numRow => $row){
                                if($numRow > 0){
                                    foreach($row as $col_slug => $cellContent){
                                        switch($col_slug){
                                            case 'nom_etab.':
                                                echo $cellContent;
                                                break;
                                        }
                                    }
                                    echo '<br/>';
                                }
                            }
                        }
                    }
                });
                
                Storage::delete($relPath);
            }
        }
        die();
    }

}
