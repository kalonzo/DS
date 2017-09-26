<?php
namespace App\Datatables;

use App\Feeders\DatatableFeeder;
use App\Feeders\DatatableRowAction;
use App\Http\Controllers\SessionController;
use App\Models\Booking;
use App\Models\User;
use App\Utilities\DbQueryTools;
use App\Utilities\UuidTools;
use DateInterval;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

/**
 * Description of DtBookingPro
 *
 * @author Nico
 */
class DtBookingPro extends DatatableFeeder {
    
    const DT_ID = 'dt_booking_pro';

    public function buildActions() {
        $this->enableAction(DatatableRowAction::ACTION_EDIT);
    }

    public function buildColumns() {
        $columns = array('nb_adults' => 'Personnes', 'datetime_reservation' => 'Date / Heure', 'comment' => 'Commentaire', 
                                            'contact' => 'Contact', 'status' => 'Etat', 'updated_at' => 'Modifié le');
        return $columns;
    }

    public function buildFilters() {
        $filters = array();
        
        return $filters;
    }


    public function getQueryIndex() {
        return Booking::TABLENAME . '.id';
    }
    
    public function buildQuery() {
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        $user = Auth::user();

        $start = new DateTime('today');
        if(!empty(Request::get('start'))){
            $start = new DateTime(Request::get('start'));
        }
        $startDate = $start->format('Y-m-d H:i:s');
        $end = date_add($start, new DateInterval('P1D'));
        if(!empty(Request::get('end'))){
            $end = new DateTime(Request::get('end'));
        }
        $endDate = $end->format('Y-m-d H:i:s');
        $bookingsQuery = Booking::select([Booking::TABLENAME.'.*'])
                        ->whereRaw('datetime_reservation BETWEEN "'.$startDate.'" AND "'.$endDate.'"')
                        ->orderBy(Booking::TABLENAME . '.datetime_reservation', 'asc');

        switch($user->getType()){
            case User::TYPE_USER_PRO:
                $establishmentsData = $user->establishmentsOwned()->select([DB::raw(DbQueryTools::genRawSqlForGettingUuid())])
                                        ->get();
                $establishmentUuids = $establishmentsData->pluck('uuid')->all();
                $bookingsQuery
                    ->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id_establishment', $establishmentUuids));
                break;
            case User::TYPE_USER:
                $bookingsQuery
                    ->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id_user', $user->getUuid()));
                break;
            case User::TYPE_USER_ADMIN_PRO:
                // Can see all
                break;
            default :
                $bookingsQuery->whereRaw('1 = 0');
                break;
        }
        
        return $bookingsQuery;
    }

    public function buildResults(Collection $queryResults) {
        $results = array();
        
        foreach ($queryResults as $queryResult) {
            $uuid = UuidTools::getUuid($queryResult->id);

            $results[$uuid]['id'] = $uuid;
            $results[$uuid]['nb_adults'] = $queryResult->nb_adults;
            $results[$uuid]['datetime_reservation'] = $queryResult->datetime_reservation;
            $results[$uuid]['comment'] = $queryResult->comment;
            $results[$uuid]['phone_number'] = $queryResult->phone_number;
            $results[$uuid]['email'] = $queryResult->email;
            $results[$uuid]['contact'] = $queryResult->phone_number . ' ' . $queryResult->email;
            $results[$uuid]['status'] = $queryResult->getStatusLabel();
            $results[$uuid]['updated_at'] = $queryResult->updated_at;
        }
        
        return $results;
    }
    
}
