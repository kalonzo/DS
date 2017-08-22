<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Requests\StoreEstablishment;
use App\Models\Address;
use App\Models\BusinessCategory;
use App\Models\CallNumber;
use App\Models\Country;
use App\Models\Establishment;
use App\Models\EstablishmentBusinessCategory;
use App\Models\LocationIndex;
use App\Models\Model;
use App\Models\OpeningHour;
use App\Models\Restaurant;
use App\Models\User;
use App\php;
use App\Utilities\DateTools;
use App\Utilities\DbQueryTools;
use App\Utilities\StorageHelper;
use App\Utilities\UuidTools;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use View;

class ImportRestaurantController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        
    }

    /**
     * 
     * @return View
     */
    public function show() {
        $view = View::make('establishment.import');
        return $view;
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function storeFile(Request $request) {

        $xlsx = FileController::storeFile('csv', \App\Models\Media::TYPE_CSV, 'test', null);
        $path = substr($xlsx->getLocalPath(),1); 

       $excel =  \Maatwebsite\Excel\Facades\Excel::load($path);
        
        
        foreach ($excel as $row ){
            
            print_r($row);
        }
        \Illuminate\Support\Facades\Storage::delete($xlsx->getLocalPath());
    }

}
