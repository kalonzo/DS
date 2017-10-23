<?php

namespace App\Datatables;

use App\Feeders\DatatableFeeder;
use App\Feeders\DatatableFilter;
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
class DtUserAdmin extends DatatableFeeder {
    
    const DT_ID = 'dt_user_admin';

    public function buildActions() {
//        $this->enableAction(DatatableRowAction::ACTION_EDIT);
//        $this->customizeAction(DatatableRowAction::ACTION_EDIT)->setHref('/edit/user/{{id}}');
    }

    public function buildColumns() {
        $columns = array('lastname' => 'Nom', 'firstname' => 'Prénom', 'type' => 'Type', 'status' => "Statut", 'updated_at' => "Modifié le");
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
        
        // Type search
        $typeSearch = new DatatableFilter();
        $typeSearch->setInputType(DatatableFilter::INPUT_SELECT);
        $typeSearch->setLabel('Type');
        $typeSearch->setName('type');
        $typeSearch->setPlaceholder("Tous");
        $typeSearch->setTable(User::TABLENAME);
        $typeSearch->setField('type');
        $typeSearch->setEnableEmpty(false);
        $typeSearch->setOperator(DatatableFilter::OPERATOR_EQUAL);
        $typeSearch->setValue(Request::get('filter.type', User::TYPE_USER_ADMIN_PRO));
        $typeSearch->setOptions(User::getLabelByType());
        $filters[] = $typeSearch;

        return $filters;
    }


    public function getQueryIndex() {
        return User::TABLENAME . '.id';
    }
    
    public function buildQuery() {
        $userQuery = DB::table(User::TABLENAME)
                ->select([
                    User::TABLENAME . '.*',
                    DB::raw('CONCAT('.User::TABLENAME . '.lastname, " ", '.User::TABLENAME . '.firstname) AS designation')
                ])
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
        }
        
        return $results;
    }

}
