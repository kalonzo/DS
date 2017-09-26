<?php

namespace App\Datatables;

use App\Feeders\DatatableFeeder;
use App\Http\Controllers\SessionController;
use App\Models\Establishment;
use App\Models\Promotion;
use App\Models\PromotionType;
use App\Utilities\UuidTools;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Description of DtPromotionAdmin
 *
 * @author Nico
 */
class DtPromotionAdmin extends DatatableFeeder {
    
    const DT_ID = 'dt_promotion_admin';

    public function buildActions() {
//                $this->enableAction(DatatableRowAction::ACTION_EDIT);
//                $this->customizeAction(DatatableRowAction::ACTION_EDIT)->setHref('/admin/promotion/{{id}}');
    }

    public function buildColumns() {
        $columns = array('ets_name' => 'Etablissement', 'name' => 'Label', 'type' => 'Type', 'start_date' => 'Début'
                    , 'end_date' => 'Fin');
        return $columns;
    }

    public function buildFilters() {
        $filters = array();
        
        return $filters;
    }


    public function getQueryIndex() {
        return Promotion::TABLENAME . '.id';
    }
    
    public function buildQuery() {
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        
        $promotionsQuery = DB::table(Promotion::TABLENAME)
                ->select([Promotion::TABLENAME . '.*',
                    Establishment::TABLENAME . '.name AS ets_name'])
                ->join(Establishment::TABLENAME, Promotion::TABLENAME . '.id_establishment', '=', Establishment::TABLENAME . '.id')
        ;
        $promotionsQuery->whereRaw(Promotion::TABLENAME . '.end_date > NOW()');
        $promotionsQuery->orderBy(Promotion::TABLENAME . '.start_date', 'ASC');
        
        return $promotionsQuery;
    }

    public function buildResults(Collection $queryResults) {
        $results = array();
        
        foreach ($queryResults as $queryResult) {
            $uuid = UuidTools::getUuid($queryResult->id);

            $results[$uuid]['id'] = $uuid;
            $results[$uuid]['ets_name'] = $queryResult->ets_name;
            $results[$uuid]['name'] = $queryResult->name;
            $results[$uuid]['type'] = PromotionType::getLabelFromType($queryResult->id_promotion_type);
            $results[$uuid]['start_date'] = $queryResult->start_date;
            $results[$uuid]['end_date'] = $queryResult->end_date;
        }
        
        return $results;
    }

}

