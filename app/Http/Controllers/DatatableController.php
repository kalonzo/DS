<?php

namespace App\Http\Controllers;

use App\Feeders\DatatableFeeder;
use Illuminate\Support\Facades\Request;
use App\Models\Address;
use App\Models\BusinessType;
use App\Models\Establishment;
use App\Utilities\UuidTools;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Description of DatatableController
 *
 * @author Nico
 */
class DatatableController {
    
    const ESTABLISHMENT_DATATABLE = 'establishment_datatable';
    
    /**
     * 
     * @param type $id
     * @return DatatableFeeder
     */
    public static function buildDatatable($id) {
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        $dtFeeder = null;
        switch ($id) {
            case self::ESTABLISHMENT_DATATABLE:
                $establishments = array();

                $establishmentsQuery = DB::table(Establishment::TABLENAME)
                        ->select(DB::raw(Establishment::TABLENAME . '.*, ' . Address::TABLENAME . '.* '))
                        ->join(Address::TABLENAME, Address::TABLENAME . '.id', '=', Establishment::TABLENAME . '.id_address')
                ;
                if (!empty($typeEts)) {
                    $establishmentsQuery->where(Establishment::TABLENAME . '.id_business_type', '=', $typeEts);
                }
                $establishmentsQuery->orderBy(Establishment::TABLENAME . '.updated_at', 'desc');

                $nbElementPerPage = 10;
                $currentPage = Request::get('page', 1);
                $sliceStart = ($currentPage - 1) * $nbElementPerPage;
                $nbTotalResults = $establishmentsQuery->count(Establishment::TABLENAME . '.id');

                $establishmentsQuery->offset($sliceStart)->limit($nbElementPerPage);
                $establishmentsData = $establishmentsQuery->get();
                foreach ($establishmentsData as $establishmentData) {
                    $uuid = UuidTools::getUuid($establishmentData->id);

                    $establishments[$uuid]['id'] = $uuid;
                    $establishments[$uuid]['name'] = $establishmentData->name;
                    $establishments[$uuid]['type'] = BusinessType::getLabelFromType($establishmentData->id_business_type);
                    $establishments[$uuid]['img'] = "/img/images_ds/imagen-DS-" . rand(1, 20) . ".jpg";
                    $establishments[$uuid]['city'] = $establishmentData->city;
                    $establishments[$uuid]['country'] = $establishmentData->country;
                    $establishments[$uuid]['updated_at'] = $establishmentData->updated_at;
                }
                // Paginate results
                $resultsPagination = new LengthAwarePaginator($establishments, $nbTotalResults, $nbElementPerPage, $currentPage);
                $resultsPagination->setPath(Request::url());

                $dtFeeder = new DatatableFeeder($id);
                $dtFeeder->setPaginator($resultsPagination);
                $dtFeeder->setColumns(array('name' => 'Nom', 'type' => 'Type', 'city' => 'Ville', 'updated_at' => 'Modifié le'));
                $dtFeeder->enableAction(\App\Feeders\DatatableRowAction::ACTION_EDIT);
                $dtFeeder->customizeAction(\App\Feeders\DatatableRowAction::ACTION_EDIT)->setHref('/establishment/{{id}}');
                break;
        }
        return $dtFeeder;
    }
}
