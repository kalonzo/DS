<?php

namespace App\Datatables;

use App\Feeders\DatatableFeeder;
use App\Feeders\DatatableFilter;
use App\Feeders\DatatableRowAction;
use App\Models\User;
use App\Utilities\UuidTools;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

/**
 * Description of DtUserProAdmin
 *
 * @author Nico
 */
class DtUserProAdmin extends DatatableFeeder {
    
    const DT_ID = 'dt_user_pro_admin';
    
    public function buildActions() {

    }

    public function buildColumns() {
        $columns = array('lastname' => 'Nom', 'firstname' => 'Prénom', 'establishment' => 'Etablissement', 'status' => "Statut", 'updated_at' => "Modifié le");
        return $columns;
    }

    public function buildFilters() {
        $filters = array();
        
        // Free search
        $freeSearch = new DatatableFilter();
        $freeSearch->setInputType(DatatableFilter::INPUT_TEXT);
        $freeSearch->setName('designation');
        $freeSearch->setPlaceholder("Recherche...");
        $freeSearch->setIsRaw(true);
        $freeSearch->setField('CONCAT('.User::TABLENAME . '.lastname, " ", '.User::TABLENAME . '.firstname)');
        $freeSearch->setOperator(DatatableFilter::OPERATOR_LIKE_CONTAINS);
        $freeSearch->setValue(Request::get('filter.designation'));
        $filters[] = $freeSearch;

        // Status search
        $statusSearch = new DatatableFilter();
        $statusSearch->setInputType(DatatableFilter::INPUT_SELECT);
        $statusSearch->setLabel('Statut');
        $statusSearch->setName('status');
        $statusSearch->setPlaceholder("Tous");
        $statusSearch->setTable(User::TABLENAME);
        $statusSearch->setField('status');
        $statusSearch->setEnableEmpty(false);
        $statusSearch->setOperator(DatatableFilter::OPERATOR_EQUAL);
        $statusSearch->setValue(Request::get('filter.status'));
        $statusSearch->setOptions(User::getLabelByStatus());
        $filters[] = $statusSearch;
        
        return $filters;
    }


    public function getQueryIndex() {
        return User::TABLENAME . '.id';
    }
    
    public function buildQuery() {
        $userQuery = DB::table(User::TABLENAME)
                ->select([
                    User::TABLENAME . '.*',
                    \App\Models\Establishment::TABLENAME . '.name AS ets_name',
                    DB::raw(\App\Utilities\DbQueryTools::genRawSqlForGettingUuid('id', \App\Models\Establishment::TABLENAME, 'uuid_ets')),
                    DB::raw('CONCAT('.User::TABLENAME . '.lastname, " ", '.User::TABLENAME . '.firstname) AS designation')
                ])
                ->leftJoin(\App\Models\Establishment::TABLENAME, \App\Models\Establishment::TABLENAME.'.id_user_owner', '=', User::TABLENAME . '.id')
                ->where('type', '=', User::TYPE_USER_PRO)
        ;
        $userQuery->orderBy('designation', 'asc');
        return $userQuery;
    }

    public function buildResults(Collection $queryResults) {
        $results = array();
        
        foreach ($queryResults as $queryResult) {
            $uuid = UuidTools::getUuid($queryResult->id);

            $results[$uuid]['id'] = $uuid;
            $results[$uuid]['lastname'] = $queryResult->lastname;
            $results[$uuid]['firstname'] = $queryResult->firstname;
            $results[$uuid]['type'] = User::getLabelFromType($queryResult->type);
            $results[$uuid]['status'] = User::getLabelFromStatus($queryResult->status);
            $results[$uuid]['updated_at'] = $queryResult->updated_at;
            if(!empty($queryResult->ets_name)){
                $results[$uuid]['establishment'] = $queryResult->ets_name;
            } else if(!empty($queryResult->uuid_ets)){
                $results[$uuid]['establishment'] = "<a href='/edit/establishment/".$queryResult->uuid_ets."'>"
                                                    . "<span class='glyphicon glyphicon-plus' aria-hidden='true'></span>"
                                                ."</a>";
            } else {
                $results[$uuid]['establishment'] = '';
            }
        }
        
        return $results;
    }

}
