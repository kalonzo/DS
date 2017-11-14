<?php

namespace App\Datatables;

use App\Feeders\DatatableFeeder;
use App\Feeders\DatatableFilter;
use App\Feeders\DatatableRowAction;
use App\Models\EstablishmentMedia;
use App\Models\PaymentMethod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

/**
 * Description of DtPaymentMethodAdmin
 *
 * @author Nico
 */
class DtPaymentMethodAdmin extends DatatableFeeder {
    
    const DT_ID = 'dt_payment_method_admin';

    public function buildActions() {
        $this->enableAction(DatatableRowAction::ACTION_EDIT);

        $this->customizeAction(DatatableRowAction::ACTION_EDIT)->setOnclick('getOnClickModal("Edition méthode de paiement", '
                . '"/admin/edit/' . PaymentMethod::TABLENAME . '/{{id}}");');
    }

    public function buildColumns() {
        $columns = array('name' => 'Nom', 'status' => 'Etat', 'image' => "Logo", 'updated_at' => 'Modifié le');
        return $columns;
    }

    public function buildFilters() {
        $filters = array();
        
        // Free search
        $freeSearch = new DatatableFilter();
        $freeSearch->setInputType(DatatableFilter::INPUT_TEXT);
        $freeSearch->setName('method_label');
        $freeSearch->setPlaceholder("Recherche...");
        $freeSearch->setTable(PaymentMethod::TABLENAME);
        $freeSearch->setField('name');
        $freeSearch->setOperator(DatatableFilter::OPERATOR_LIKE_CONTAINS);
        $freeSearch->setValue(Request::get('filter.method_label'));
        $filters[] = $freeSearch;
        
        return $filters;
    }


    public function getQueryIndex() {
        return PaymentMethod::TABLENAME . '.id';
    }
    
    public function buildQuery() {
        $businessQuery = DB::table(PaymentMethod::TABLENAME)
                ->select([PaymentMethod::TABLENAME.'.*', EstablishmentMedia::TABLENAME.'.local_path'])
                ->leftJoin(EstablishmentMedia::TABLENAME, EstablishmentMedia::TABLENAME.'.id', '=', PaymentMethod::TABLENAME.'.id_logo')
                ->orderBy(PaymentMethod::TABLENAME . '.name', 'asc');
        
        return $businessQuery;
    }

    public function buildResults(Collection $queryResults) {
        $results = array();
        
        foreach ($queryResults as $queryResult) {
            $id = $queryResult->id;
            $results[$id]['id'] = $queryResult->id;
            $results[$id]['name'] = $queryResult->name;
            $results[$id]['image'] = !empty($queryResult->local_path) ? "<img style='height: 20px;' src='".asset($queryResult->local_path)."'/>" : "";
            $results[$id]['status'] = PaymentMethod::getLabelFromStatus($queryResult->status);
            $results[$id]['updated_at'] = $queryResult->updated_at;
        }
        
        return $results;
    }

}
