<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Establishment;
use App\Models\EstablishmentBusinessCategory;
use App\Utilities\UuidTools;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function index(){
        $establishments = array();
        $typeEts = SessionController::getInstance()->getUserTypeEts();

        $establishmentsQuery = DB::table(Establishment::TABLENAME)
                ->select(DB::raw(Establishment::TABLENAME . '.*, ' . Address::TABLENAME . '.* '))
                ->join(Address::TABLENAME, Address::TABLENAME . '.id', '=', Establishment::TABLENAME . '.id_address')
                ;
        if(!empty($typeEts)){
            $establishmentsQuery->where(Establishment::TABLENAME . '.id_business_type', '=', $typeEts);
        }
        $establishmentsQuery->orderBy(Establishment::TABLENAME . '.updated_at', 'desc');
        
        $nbElementPerPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage(); 
        $sliceStart = ($currentPage - 1) * $nbElementPerPage;
        $nbTotalResults = $establishmentsQuery->count(Establishment::TABLENAME . '.id');
            
        $establishmentsQuery->offset($sliceStart)->limit($nbElementPerPage);
        $establishmentsData = $establishmentsQuery->get();
        foreach ($establishmentsData as $establishmentData) {
            $uuid = UuidTools::getUuid($establishmentData->id);

            $establishments[$uuid]['id'] = $uuid;
            $establishments[$uuid]['name'] = $establishmentData->name;
            $establishments[$uuid]['type'] = $establishmentData->id_business_type;
            $establishments[$uuid]['img'] = "/img/images_ds/imagen-DS-" . rand(1, 20) . ".jpg";
            $establishments[$uuid]['city'] = $establishmentData->city;
            $establishments[$uuid]['country'] = $establishmentData->country;
            $establishments[$uuid]['updated_at'] = $establishmentData->updated_at;
        }

        // Paginate results
        $resultsPagination = new LengthAwarePaginator($establishments, $nbTotalResults, $nbElementPerPage, $currentPage);
        $resultsPagination->setPath(Request::url());
        
        $view = View::make('admin.home')->with('establishments', $resultsPagination);
        return $view;
    }
}
