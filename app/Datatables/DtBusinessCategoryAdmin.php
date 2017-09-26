<?php

namespace App\Datatables;

use App\Feeders\DatatableFeeder;
use App\Feeders\DatatableFilter;
use App\Feeders\DatatableRowAction;
use App\Http\Controllers\SessionController;
use App\Models\BusinessCategory;
use App\Utilities\UuidTools;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

/**
 * Description of DtBusinessCategoryAdmin
 *
 * @author Nico
 */
class DtBusinessCategoryAdmin extends DatatableFeeder {
    
    const DT_ID = 'dt_business_category_admin';

    public function buildActions() {
        $this->enableAction(DatatableRowAction::ACTION_EDIT);
        $this->enableAction(DatatableRowAction::ACTION_REMOVE);

        $this->customizeAction(DatatableRowAction::ACTION_EDIT)->setOnclick('getOnClickModal("Edition catégorie Business", '
                . '"/admin/' . BusinessCategory::TABLENAME . '/{{id}}");');
        $this->customizeAction(DatatableRowAction::ACTION_REMOVE)->setHref('/admin/delete/' . BusinessCategory::TABLENAME . '/{{id}}');
    }

    public function buildColumns() {
        $columns = array('name' => 'Nom de la catégorie', 'type' => 'type', 'status' => 'Etat', 'updated_at' => 'Modifié le');
        return $columns;
    }

    public function buildFilters() {
        $filters = array();
        
        // Free search
        $freeSearch = new DatatableFilter();
        $freeSearch->setInputType(DatatableFilter::INPUT_TEXT);
        $freeSearch->setName('category_label');
        $freeSearch->setPlaceholder("Recherche...");
        $freeSearch->setTable(BusinessCategory::TABLENAME);
        $freeSearch->setField('name');
        $freeSearch->setOperator(DatatableFilter::OPERATOR_LIKE_CONTAINS);
        $freeSearch->setValue(Request::get('filter.category_label'));
        $filters[] = $freeSearch;

        // Type search
        $typeSearch = new DatatableFilter();
        $typeSearch->setInputType(DatatableFilter::INPUT_SELECT);
        $typeSearch->setLabel('Type');
        $typeSearch->setName('type_category');
        $typeSearch->setPlaceholder("Tous");
        $typeSearch->setTable(BusinessCategory::TABLENAME);
        $typeSearch->setField('type');
        $typeSearch->setEnableEmpty(false);
        $typeSearch->setOperator(DatatableFilter::OPERATOR_EQUAL);
        $typeSearch->setValue(Request::get('filter.type_category'));
        $typeSearch->setOptions(BusinessCategory::getLabelByType());
        $filters[] = $typeSearch;
        
        return $filters;
    }


    public function getQueryIndex() {
        return BusinessCategory::TABLENAME . '.id';
    }
    
    public function buildQuery() {
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        
        $businessQuery = DB::table(BusinessCategory::TABLENAME);
        $businessQuery->orderBy(BusinessCategory::TABLENAME . '.updated_at', 'desc');
        
        return $businessQuery;
    }

    public function buildResults(Collection $queryResults) {
        $results = array();
        
        foreach ($queryResults as $queryResult) {
            $uuid = UuidTools::getUuid($queryResult->id);

            $results[$uuid]['id'] = $uuid;
            $results[$uuid]['name'] = $queryResult->name;
            $results[$uuid]['type'] = BusinessCategory::getLabelFromType($queryResult->type);
            $results[$uuid]['status'] = $queryResult->status;
            $results[$uuid]['updated_at'] = $queryResult->updated_at;
        }
        
        return $results;
    }

}
