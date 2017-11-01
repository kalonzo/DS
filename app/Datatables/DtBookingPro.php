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
    
    const HIDE_VALID = 'hide_valid';
    const HIDE_DENY = 'hide_deny';

    public function buildActions() {
        $this->enableAction(DatatableRowAction::ACTION_VALID);
        $this->customizeAction(DatatableRowAction::ACTION_VALID)->setOnclick(
                'confirmChoice('
                . '"Confirmez-vous la validation de cette réservation?", '
                . 'redirectToUrl(\'/admin/booking/confirm/{{id}}\'), '
                . 'void(0)'
                .');');
        $this->customizeAction(DatatableRowAction::ACTION_VALID)->setHiddenCond(self::HIDE_VALID);
        
        $this->enableAction(DatatableRowAction::ACTION_DENY);
        $this->customizeAction(DatatableRowAction::ACTION_DENY)->setOnclick(
                'confirmChoice('
                . '"Confirmez-vous le refus de cette réservation?", '
                . 'redirectToUrl(\'/admin/booking/deny/{{id}}\'), '
                . 'void(0)'
                .');');
        $this->customizeAction(DatatableRowAction::ACTION_DENY)->setHiddenCond(self::HIDE_DENY);
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
        $user = Auth::user();
        $selectedBookingId = Request::get('id_booking');
                        
        $bookingsQuery = Booking::select([Booking::TABLENAME.'.*'])
                        ->orderBy(Booking::TABLENAME . '.datetime_reservation', 'asc');
        
        if(checkModelId($selectedBookingId)){
            $bookingsQuery->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id', $selectedBookingId, Booking::TABLENAME));
        } else {
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
        
            $bookingsQuery->whereRaw('datetime_reservation BETWEEN "'.$startDate.'" AND "'.$endDate.'"');
        }
        
        switch($user->getType()){
            case User::TYPE_USER_PRO:
                $establishmentsData = $user->establishmentsOwned()->select([DB::raw(DbQueryTools::genRawSqlForGettingUuid())])
                                        ->get();
                $establishmentUuids = $establishmentsData->pluck('uuid')->all();
                $bookingsQuery
                    ->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id_establishment', $establishmentUuids));
                
                $bookingsQuery->whereIn('status', array(Booking::STATUS_PENDING, Booking::STATUS_CONFIRMED, Booking::STATUS_DENIED, Booking::STATUS_CANCELED));
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

            $phoneNumber = formatPhone($queryResult->prefix, $queryResult->phone_number, \App\Http\Controllers\GeolocationController::getLocaleCountry());
            $results[$uuid]['id'] = $uuid;
            $results[$uuid]['nb_adults'] = $queryResult->nb_adults;
            $results[$uuid]['datetime_reservation'] = $queryResult->datetime_reservation;
            $results[$uuid]['comment'] = $queryResult->comment;
            $results[$uuid]['phone_number'] = "<a href='tel:".$phoneNumber."'>".$phoneNumber."</a>";
            $results[$uuid]['email'] = "<a href='mailto:".$queryResult->email."'>".$queryResult->email."</a>";
            $results[$uuid]['contact'] = "<a href='tel:".$phoneNumber."'>".$phoneNumber."</a>"
                                        ." "
                                        ."<a href='mailto:".$queryResult->email."'>".$queryResult->email."</a>";
            
            $color = '';
            switch($queryResult->getStatus()){
                case Booking::STATUS_CREATED:
                    $color = 'yellow';
                    break;
                case Booking::STATUS_PENDING:
                    $color = 'orange';
                    break;
                case Booking::STATUS_CONFIRMED:
                    $color = 'green';
                    break;
                case Booking::STATUS_DENIED:
                    $color = 'red';
                    break;
                case Booking::STATUS_CANCELED:
                    $color = 'grey';
                    break;
            }
            $results[$uuid]['status'] = "<span style='color: ".$color.";'>".$queryResult->getStatusLabel()."</span>";
            $results[$uuid]['updated_at'] = $queryResult->updated_at;
            
            $hideValid = false;
            if($queryResult->isOver() || $queryResult->getStatus() !== Booking::STATUS_PENDING){
                $hideValid = true;
            }
            $results[$uuid][self::HIDE_VALID] = $hideValid;
            $results[$uuid][self::HIDE_DENY] = $hideValid;
        }
        
        return $results;
    }
    
}
