<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Utilities\DbQueryTools;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function checkModel;
use function response;

class BookingController extends Controller{
    public function calendarFeed(Request $request){
        $response = response();
        $jsonResponse = array();
            
        try{
            $user = Auth::user();
            
            $start = $request->get('start');
            $end = $request->get('end');
            
            if(!empty($start) && !empty($end) && checkModel($user)){
                $startDate = new DateTime($start);
                $startDateFormatted = $startDate->format('Y-m-d H:i:s');
                
                $endDate = new DateTime($end);
                $endDateFormatted = $endDate->format('Y-m-d H:i:s');
                $bookingsQuery = Booking::select([
                                    'id', 'status', 'datetime_reservation', 'nb_adults', 'nb_children'
                                ])
                                ->whereRaw('datetime_reservation BETWEEN "'.$startDateFormatted.'" AND "'.$endDateFormatted.'"')
                                ->orderBy(Booking::TABLENAME . '.updated_at', 'asc')
                                ;
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
                $bookings = $bookingsQuery->get();
                foreach ($bookings as $booking) {
                    $bookingData = array();
                    $bookingData['id'] = $booking->getUuid();
                    $bookingData['title'] = ($booking->getNbAdults() + $booking->getNbChildren());
                    $color = '';
                    switch($booking->getStatus()){
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
                    $bookingData['color'] = $color;
                    $dateStart = new DateTime($booking->getDatetimeReservation());
                    $bookingData['start'] = $dateStart->format('Y-m-d H:i');
                    $dateEnd = date_add($dateStart, new DateInterval('PT30M'));
                    $bookingData['end'] = $dateEnd->format('Y-m-d H:i');
                    $jsonResponse[] = $bookingData;
                }
            }
        } catch(Exception $e){
            $jsonResponse['error'] = $e->getMessage();
        }
        
        $responsePrepared = $response->json($jsonResponse);
        return $responsePrepared;
    }
}
