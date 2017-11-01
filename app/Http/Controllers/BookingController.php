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
                $bookings = $bookingsQuery->get();
                foreach ($bookings as $booking) {
                    $bookingData = array();
                    $bookingData['id'] = $booking->getUuid();
                    $bookingData['title'] = ($booking->getNbAdults() + $booking->getNbChildren());
                    $color = '';
                    switch($booking->getStatus()){
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
    
    public function confirm(Request $request, Booking $booking){
        $success = false;
        $feedback = null;
        try{
            if(!$booking->isOver()){
                if($booking->getStatus() === Booking::STATUS_PENDING){
                    $customer = $booking->user()->first();
                    $establishment = $booking->establishment()->first();
                    if(checkModel($customer) && checkModel($establishment)){
                        $feedback = "La réservation a bien été confirmée. Le client et ses éventuels invités vont être immédiatement avertis par email.";
                        $booking->setStatus(Booking::STATUS_CONFIRMED)->save();
                        $token = null;
                        if($customer->getStatus() !== User::STATUS_ACTIVE){
                            \App\RegistrationToken::deleteCode($customer->getId());
                            $token = \App\RegistrationToken::makeToken($customer->getEmail());
                        }
                        $customer->notify(new \App\Notifications\BookingConfirmedUser($customer, $booking, $establishment, $token));
                        if(!empty($booking->getGuests())){
                            if($booking->getGuestsEmailCc()){
                                $customer->notify(new \App\Notifications\BookingConfirmedGuest($customer, $booking, $establishment));
                            }
                            foreach($booking->getGuestsEmailArray() as $guestEmail){
                                (new User())->forceFill([
                                    'name' => $guestEmail,
                                    'email' => $guestEmail,
                                ])->notify(new \App\Notifications\BookingConfirmedGuest($customer, $booking, $establishment));
                            }
                        }
                        $success = true;
                    } else {
                        $feedback = "Une erreur est survnenue, merci de contacter directement le client.";
                    }
                } else {
                    $feedback = "La réservation a déjà été traitée.";
                }
            } else {
                $feedback = "La réservation est périmée.";
            }
        } catch(Exception $e){
            $feedback = "Une erreur est survenue. Merci de contacter un administrateur.";
        }
        
        \Illuminate\Support\Facades\Request::session()->flash($success ? 'status' : 'error', $feedback);
        
        $redirectPath = '/';
        if(Auth::check()){
            $redirectPath = '/admin';
        }
        return redirect($redirectPath);
    }
    
    public function deny(Request $request, Booking $booking){
        $success = false;
        $feedback = null;
        try{
            if(!$booking->isOver()){
                if($booking->getStatus() === Booking::STATUS_PENDING){
                    $customer = $booking->user()->first();
                    $establishment = $booking->establishment()->first();
                    if(checkModel($customer) && checkModel($establishment)){
                        $feedback = "La réservation a été refusée. Le client va être immédiatement averti par email.";
                        $booking->setStatus(Booking::STATUS_DENIED)->save();
                        $token = null;
                        if($customer->getStatus() !== User::STATUS_ACTIVE){
                            \App\RegistrationToken::deleteCode($customer->getId());
                            $token = \App\RegistrationToken::makeToken($customer->getEmail());
                        }
                        $customer->notify(new \App\Notifications\BookingDeniedUser($customer, $booking, $establishment, $token));
                        $success = true;
                    } else {
                        $feedback = "Une erreur est survnenue, merci de contacter directement le client.";
                    }
                } else {
                    $feedback = "La réservation a déjà été traitée.";
                }
            } else {
                $feedback = "La réservation est périmée.";
            }
        } catch(Exception $e){
            $feedback = "Une erreur est survenue. Merci de contacter un administrateur.";
        }
        
        \Illuminate\Support\Facades\Request::session()->flash($success ? 'status' : 'error', $feedback);
        
        $redirectPath = '/';
        if(Auth::check()){
            $redirectPath = '/admin';
        }
        return redirect($redirectPath);
    }
    
    public function cancel(Request $request, Booking $booking){
        $success = false;
        $feedback = null;
        try{
            if(!$booking->isOver()){
                if($booking->getStatus() !== Booking::STATUS_CANCELED){
                    $owner = $booking->getEstablishmentOwner();
                    $customer = $booking->user()->first();
                    if(checkModel($owner) && checkModel($customer)){
                        $feedback = "Votre réservation a été annulée.";
                        $booking->setStatus(Booking::STATUS_CANCELED)->save();
                        $owner->notify(new \App\Notifications\BookingCancelPro($customer, $booking));
                        $success = true;
                    } else {
                        $feedback = "Une erreur est survnenue, merci de contacter directement l'établissement.";
                    }
                } else {
                    $feedback = "La réservation a déjà été annulée.";
                }
            } else {
                $feedback = "La réservation est périmée.";
            }
        } catch(Exception $e){
            $feedback = "Une erreur est survenue. Merci de contacter un administrateur.";
        }
        
        \Illuminate\Support\Facades\Request::session()->flash($success ? 'status' : 'error', $feedback);
        
        $redirectPath = '/';
        if(Auth::check()){
            $redirectPath = '/admin';
        }
        return redirect($redirectPath);
    }
}
