<?php

namespace App\Datatables;

use App\Feeders\DatatableFeeder;
use App\Feeders\DatatableFilter;
use App\Http\Controllers\SessionController;
use App\Models\Address;
use App\Models\BusinessType;
use App\Models\Country;
use App\Models\Establishment;
use App\Models\EstablishmentMedia;
use App\Models\User;
use App\Utilities\UuidTools;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

/**
 * Description of DtEstablishmentMediaModeration
 *
 * @author Nico
 */
class DtEstablishmentMediaModeration extends DatatableFeeder {
    
    const DT_ID = 'dt_establishment_media_moderation';

    public function buildActions() {
//        $this->enableAction(DatatableRowAction::ACTION_EDIT);
//        $this->customizeAction(DatatableRowAction::ACTION_EDIT)->setHref('/edit/establishment/{{id}}');
    }

    public function buildColumns() {
        $columns = array('name' => 'Nom', 'type' => 'Type', 'ets' => 'Etablissement', 'city' => 'Ville', 'country' => 'Pays', 'created_at' => 'Déposé le');
        return $columns;
    }

    public function buildFilters() {
        $filters = array();
        
        // Free search
        $freeSearch = new DatatableFilter();
        $freeSearch->setInputType(DatatableFilter::INPUT_TEXT);
        $freeSearch->setName('designation');
        $freeSearch->setPlaceholder("Recherche...");
        $freeSearch->setTable(Establishment::TABLENAME);
        $freeSearch->setField('name');
        $freeSearch->setOperator(DatatableFilter::OPERATOR_LIKE_CONTAINS);
        $freeSearch->setValue(Request::get('filter.designation'));
        $filters[] = $freeSearch;
        
        // Type search
        $typeSearch = new DatatableFilter();
        $typeSearch->setInputType(DatatableFilter::INPUT_SELECT);
        $typeSearch->setLabel('Type');
        $typeSearch->setName('business_type');
        $typeSearch->setPlaceholder("Tous");
        $typeSearch->setTable(Establishment::TABLENAME);
        $typeSearch->setField('id_business_type');
        $typeSearch->setEnableEmpty(false);
        $typeSearch->setOperator(DatatableFilter::OPERATOR_EQUAL);
        $typeSearch->setValue(Request::get('filter.business_type'));
        $typeSearch->setOptions(BusinessType::getLabelByType());
        $filters[] = $typeSearch;

        return $filters;
    }


    public function getQueryIndex() {
        return EstablishmentMedia::TABLENAME . '.id';
    }
    
    public function buildQuery() {
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        
        $establishmentsQuery = DB::table(EstablishmentMedia::TABLENAME)
                ->select([
                    EstablishmentMedia::TABLENAME . '.*', Address::TABLENAME . '.*', 
                    EstablishmentMedia::TABLENAME . '.id AS id_media',
                    Establishment::TABLENAME . '.id AS id_establishment',
                    Establishment::TABLENAME . '.name AS establishment_name',
//                    User::TABLENAME . '.id AS id_owner',
//                    DB::raw('CONCAT('.User::TABLENAME . '.lastname, " ", '.User::TABLENAME . '.firstname) AS owner')
                ])
                ->join(Establishment::TABLENAME, Establishment::TABLENAME . '.id', '=', EstablishmentMedia::TABLENAME.'.id_establishment')
                ->join(Address::TABLENAME, Address::TABLENAME . '.id', '=', Establishment::TABLENAME . '.id_address')
//                ->join(User::TABLENAME, User::TABLENAME . '.id', '=', Establishment::TABLENAME . '.id_user_owner')
                ->where(EstablishmentMedia::TABLENAME.'.status', '=', EstablishmentMedia::STATUS_PENDING)
                ;
        
        $establishmentsQuery->orderBy(EstablishmentMedia::TABLENAME . '.updated_at', 'asc');
        
        return $establishmentsQuery;
    }

    public function buildResults(Collection $queryResults) {
        $results = array();
        
        foreach ($queryResults as $queryResult) {
            $uuid = UuidTools::getUuid($queryResult->id_media);

            $results[$uuid]['id'] = $uuid;
            $results[$uuid]['name'] = $queryResult->filename;
            $results[$uuid]['type'] = EstablishmentMedia::getLabelFromTypeUse($queryResult->type_use);
            $results[$uuid]['ets'] = $queryResult->establishment_name;
            $results[$uuid]['city'] = $queryResult->city;
            $results[$uuid]['country'] = Country::getCountryLabel($queryResult->id_country);
            $results[$uuid]['created_at'] = $queryResult->updated_at;
        }
        
        return $results;
    }

}
