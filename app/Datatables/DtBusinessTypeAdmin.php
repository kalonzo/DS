<?php

namespace App\Datatables;

use App\Feeders\DatatableFeeder;
use App\Feeders\DatatableFilter;
use App\Feeders\DatatableRowAction;
use App\Models\BusinessType;
use App\Models\EstablishmentMedia;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

/**
 * Description of DtBusinessTypeAdmin
 *
 * @author Nico
 */
class DtBusinessTypeAdmin extends DatatableFeeder {
    
    const DT_ID = 'dt_business_type_admin';

    public function buildActions() {
        $this->enableAction(DatatableRowAction::ACTION_EDIT);
//        $this->enableAction(DatatableRowAction::ACTION_REMOVE);
//        $this->customizeAction(DatatableRowAction::ACTION_REMOVE)->setHref('/admin/delete/' . BusinessType::TABLENAME . '/{{id}}');

        $this->customizeAction(DatatableRowAction::ACTION_EDIT)->setOnclick('getOnClickModal("Edition type de business", '
                . '"/admin/edit/' . BusinessType::TABLENAME . '/{{id}}");');
    }

    public function buildColumns() {
        $columns = array('label' => 'Nom du business', 'status' => 'Etat', 'image' => "Image", 'updated_at' => 'Modifié le');
        return $columns;
    }

    public function buildFilters() {
        $filters = array();
        
        // Free search
        $freeSearch = new DatatableFilter();
        $freeSearch->setInputType(DatatableFilter::INPUT_TEXT);
        $freeSearch->setName('category_label');
        $freeSearch->setPlaceholder("Recherche...");
        $freeSearch->setTable(BusinessType::TABLENAME);
        $freeSearch->setField('label');
        $freeSearch->setOperator(DatatableFilter::OPERATOR_LIKE_CONTAINS);
        $freeSearch->setValue(Request::get('filter.category_label'));
        $filters[] = $freeSearch;
        
        return $filters;
    }


    public function getQueryIndex() {
        return BusinessType::TABLENAME . '.id';
    }
    
    public function buildQuery() {
        $businessQuery = DB::table(BusinessType::TABLENAME)
                ->select([BusinessType::TABLENAME.'.*', EstablishmentMedia::TABLENAME.'.local_path'])
                ->leftJoin(EstablishmentMedia::TABLENAME, EstablishmentMedia::TABLENAME.'.id', '=', BusinessType::TABLENAME.'.id_media')
                ->orderBy(BusinessType::TABLENAME . '.label', 'asc');
        
        return $businessQuery;
    }

    public function buildResults(Collection $queryResults) {
        $results = array();
        
        foreach ($queryResults as $queryResult) {
            $id = $queryResult->id;
            $results[$id]['id'] = $queryResult->id;
            $results[$id]['label'] = $queryResult->label;
            $results[$id]['image'] = !empty($queryResult->local_path) ? "<img style='background-color: black; height: 20px;' src='".asset($queryResult->local_path)."'/>" : "";
            $results[$id]['status'] = BusinessType::getLabelFromStatus($queryResult->status);
            $results[$id]['updated_at'] = $queryResult->updated_at;
        }
        
        return $results;
    }

}
