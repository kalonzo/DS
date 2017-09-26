<?php

namespace App\Datatables;

use App\Feeders\DatatableFeeder;
use App\Feeders\DatatableRowAction;
use App\Http\Controllers\SessionController;
use App\Models\Establishment;
use App\Models\Event;
use App\Utilities\UuidTools;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Description of DtEventAdmin
 *
 * @author Nico
 */
class DtEventAdmin extends DatatableFeeder {
    
    const DT_ID = 'dt_event_admin';

    public function buildActions() {
        $this->enableAction(DatatableRowAction::ACTION_EDIT);
        $this->customizeAction(DatatableRowAction::ACTION_EDIT)->setHref('/admin/events/{{id}}');
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
        return Event::TABLENAME . '.id';
    }
    
    public function buildQuery() {
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        
        $eventsQuery = DB::table(Event::TABLENAME)
                ->select([Event::TABLENAME . '.*',
                    Establishment::TABLENAME . '.name AS ets_name'])
                ->join(Establishment::TABLENAME, Event::TABLENAME . '.id_establishment', '=', Establishment::TABLENAME . '.id')
        ;
        $eventsQuery->whereRaw(Event::TABLENAME . '.end_date > NOW()');
        $eventsQuery->orderBy(Event::TABLENAME . '.start_date', 'ASC');
        
        return $eventsQuery;
    }

    public function buildResults(Collection $queryResults) {
        $results = array();
        
        foreach ($queryResults as $queryResult) {
            $uuid = UuidTools::getUuid($queryResult->id);

            $results[$uuid]['id'] = $uuid;
            $results[$uuid]['ets_name'] = $queryResult->ets_name;
            $results[$uuid]['name'] = $queryResult->name;
            $results[$uuid]['type'] = $queryResult->type_event;
            $results[$uuid]['start_date'] = $queryResult->start_date;
            $results[$uuid]['end_date'] = $queryResult->end_date;
        }
        
        return $results;
    }

}

