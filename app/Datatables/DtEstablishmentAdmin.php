<?php

namespace App\Datatables;

use App\Feeders\DatatableFeeder;
use App\Feeders\DatatableFilter;
use App\Feeders\DatatableRowAction;
use App\Http\Controllers\SessionController;
use App\Models\Address;
use App\Models\BusinessType;
use App\Models\Country;
use App\Models\Establishment;
use App\Models\User;
use App\Utilities\UuidTools;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

/**
 * Description of DtEstablishmentAdmin
 *
 * @author Nico
 */
class DtEstablishmentAdmin extends DatatableFeeder {
    
    const DT_ID = 'dt_establishment_admin';

    public function buildActions() {
        $this->enableAction(DatatableRowAction::ACTION_EDIT);
        $this->customizeAction(DatatableRowAction::ACTION_EDIT)->setHref('/establishment/{{id}}');
    }

    public function buildColumns() {
        $columns = array('name' => 'Nom', 'type' => 'Type', 'user' => 'Client', 'city' => 'Ville', 'updated_at' => 'Modifié le');
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
        
        return $filters;
    }


    public function getQueryIndex() {
        return Establishment::TABLENAME . '.id';
    }
    
    public function buildQuery() {
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        
        $establishmentsQuery = DB::table(Establishment::TABLENAME)
                ->select([
                    Establishment::TABLENAME . '.*', Address::TABLENAME . '.*', 
                    Establishment::TABLENAME . '.id AS id_establishment',
                    User::TABLENAME . '.id AS id_owner',
                    DB::raw('CONCAT('.User::TABLENAME . '.lastname, " ", '.User::TABLENAME . '.firstname) AS owner')
                ])
                ->join(Address::TABLENAME, Address::TABLENAME . '.id', '=', Establishment::TABLENAME . '.id_address')
                ->leftJoin(User::TABLENAME, User::TABLENAME . '.id', '=', Establishment::TABLENAME . '.id_user_owner')
        ;
        if (!empty($typeEts)) {
            $establishmentsQuery->where(Establishment::TABLENAME . '.id_business_type', '=', $typeEts);
        }
        $establishmentsQuery->orderBy(Establishment::TABLENAME . '.updated_at', 'desc');
        
        return $establishmentsQuery;
    }

    public function buildResults(Collection $queryResults) {
        $results = array();
        
        foreach ($queryResults as $queryResult) {
            $uuid = UuidTools::getUuid($queryResult->id_establishment);

            $results[$uuid]['id'] = $uuid;
            $results[$uuid]['name'] = $queryResult->name;
            $results[$uuid]['type'] = BusinessType::getLabelFromType($queryResult->id_business_type);
            if(!empty($queryResult->owner)){
                $results[$uuid]['user'] = $queryResult->owner;
            } else {
                $results[$uuid]['user'] = "<a href='/admin/user_pro/register?id_establishment=".$uuid."'>"
                                                    . "<span class='glyphicon glyphicon-plus' aria-hidden='true'></span>"
                                                ."</a>";
            }
            $results[$uuid]['city'] = $queryResult->city;
            $results[$uuid]['country'] = Country::getCountryLabel($queryResult->id_country);
            $results[$uuid]['updated_at'] = $queryResult->updated_at;
        }
        
        return $results;
    }

}
