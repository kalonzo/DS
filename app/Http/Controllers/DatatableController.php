<?php

namespace App\Http\Controllers;

use App\Feeders\DatatableFeeder;
use App\Feeders\DatatableRowAction;
use App\Models\Address;
use App\Models\Booking;
use App\Models\BusinessType;
use App\Models\Country;
use App\Models\Establishment;
use App\Utilities\UuidTools;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

/**
 * Description of DatatableController
 *
 * @author Nico
 */
class DatatableController {
    
    const ESTABLISHMENT_DATATABLE = 'establishment_datatable';
    const BOOKING_DATATABLE = 'booking_datatable';
    
    /**
     * 
     * @param type $id
     * @return DatatableFeeder
     */
    public static function buildDatatable($id) {
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        $dtFeeder = null;
        switch ($id) {
            case self::ESTABLISHMENT_DATATABLE:
                $establishments = array();

                $establishmentsQuery = DB::table(Establishment::TABLENAME)
                        ->select(DB::raw(Establishment::TABLENAME . '.*, ' . Address::TABLENAME . '.*, '.Establishment::TABLENAME . '.id AS id_establishment'))
                        ->join(Address::TABLENAME, Address::TABLENAME . '.id', '=', Establishment::TABLENAME . '.id_address')
                ;
                if (!empty($typeEts)) {
                    $establishmentsQuery->where(Establishment::TABLENAME . '.id_business_type', '=', $typeEts);
                }
                $establishmentsQuery->orderBy(Establishment::TABLENAME . '.updated_at', 'desc');

                $nbElementPerPage = 10;
                $currentPage = Request::get('page', 1);
                $sliceStart = ($currentPage - 1) * $nbElementPerPage;
                $nbTotalResults = $establishmentsQuery->count(Establishment::TABLENAME . '.id');

                $establishmentsQuery->offset($sliceStart)->limit($nbElementPerPage);
                $establishmentsData = $establishmentsQuery->get();
                foreach ($establishmentsData as $establishmentData) {
                    $uuid = UuidTools::getUuid($establishmentData->id_establishment);

                    $establishments[$uuid]['id'] = $uuid;
                    $establishments[$uuid]['name'] = $establishmentData->name;
                    $establishments[$uuid]['type'] = BusinessType::getLabelFromType($establishmentData->id_business_type);
                    $establishments[$uuid]['img'] = "/img/images_ds/imagen-DS-" . rand(1, 20) . ".jpg";
                    $establishments[$uuid]['city'] = $establishmentData->city;
                    $establishments[$uuid]['country'] = Country::getCountryLabel($establishmentData->id_country);
                    $establishments[$uuid]['updated_at'] = $establishmentData->updated_at;
                }
                // Paginate results
                $resultsPagination = new LengthAwarePaginator($establishments, $nbTotalResults, $nbElementPerPage, $currentPage);
                $resultsPagination->setPath(Request::url());

                $dtFeeder = new DatatableFeeder($id);
                $dtFeeder->setPaginator($resultsPagination);
                $dtFeeder->setColumns(array('name' => 'Nom', 'type' => 'Type', 'city' => 'Ville', 'updated_at' => 'Modifié le'));
                $dtFeeder->enableAction(DatatableRowAction::ACTION_EDIT);
                $dtFeeder->customizeAction(DatatableRowAction::ACTION_EDIT)->setHref('/establishment/{{id}}');
                break;
            case self::BOOKING_DATATABLE:
                $bookings = array();

                $bookingsQuery = DB::table(Booking::TABLENAME)->select();


                $bookingsQuery->orderBy(Booking::TABLENAME . '.updated_at', 'desc');

                $nbElementPerPage = 10;
                $currentPage = Request::get('page', 1);
                $sliceStart = ($currentPage - 1) * $nbElementPerPage;
                $nbTotalResults = $bookingsQuery->count(Booking::TABLENAME . '.id');

                $bookingsQuery->offset($sliceStart)->limit($nbElementPerPage);
                $bookingsData = $bookingsQuery->get();

                foreach ($bookingsData as $bookingData) {
                    $uuid = UuidTools::getUuid($bookingData->id);

                    $bookings[$uuid]['id'] = $uuid;
                    $bookings[$uuid]['nb_adults'] = $bookingData->nb_adults;
                    $bookings[$uuid]['datetime_reservation'] = $bookingData->datetime_reservation;
                    $bookings[$uuid]['comment'] = $bookingData->comment;
                    $bookings[$uuid]['phone_number'] = $bookingData->phone_number;
                    $bookings[$uuid]['email'] = $bookingData->email;
                    $bookings[$uuid]['contact'] = $bookingData->phone_number.' '.$bookingData->email;
                    $bookings[$uuid]['status'] = $bookingData->status;
                    $bookings[$uuid]['updated_at'] = $bookingData->updated_at;
                }
                // Paginate results
                $resultsPagination = new LengthAwarePaginator($bookings, $nbTotalResults, $nbElementPerPage, $currentPage);
                $resultsPagination->setPath(Request::url());

                $dtFeeder = new DatatableFeeder($id);
                $dtFeeder->setPaginator($resultsPagination);
                $dtFeeder->setColumns(array('nb_adults' => 'Personne', 'datetime_reservation' => 'Date / Heure', 'comment' => 'Commentaire','contact' => 'Contact','status' => 'Etat', 'updated_at' => 'Modifié le'));
                $dtFeeder->enableAction(DatatableRowAction::ACTION_EDIT);
                break;
        }
        return $dtFeeder;
    }
}