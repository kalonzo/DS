<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller{
    public function calendarFeed(Request $request){
        $response = response();
        $jsonResponse = array();
            
        try{
            $user = Auth::user();
            $start = $request->get('start');
            $end = $request->get('end');
            if(!empty($start) && !empty($end) && checkModel($user)){
                $bookings = Booking::select([
                                    'id', 'status', 'datetime_reservation', 'nb_adults', 'nb_children'
                                ])
//                                ->whereBetween('datetime_reservation', [$start, $end])
                                ->orderBy(Booking::TABLENAME . '.updated_at', 'asc')
                                ;
//                $jsonResponse['debug'] = $bookings->toSql();
                $bookings = $bookings->get();
                foreach ($bookings as $booking) {
                    $bookingData = array();
                    $bookingData['id'] = $booking->getUuid();
                    $bookingData['title'] = ($booking->getNbAdults() + $booking->getNbChildren());
//                    $bookingData['title'] .= "<span class='glyphicon glyphicon-user' aria-hidden='true'></span>";
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
                    $dateEnd = date_add($dateStart, new \DateInterval('PT30M'));
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
