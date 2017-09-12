<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

class AdminController extends Controller {

    public function index() {
        $etsDatatableFeeder = DatatableController::buildDatatable(DatatableController::ESTABLISHMENT_DATATABLE);
        
        $bookingDatatableFeeder = DatatableController::buildDatatable(DatatableController::BOOKING_DATATABLE);
        
        $businessCategoriesDatatableFeeder = DatatableController::buildDatatable(DatatableController::BUSINESS_CATEGORIES_DATATABLE);
        
        $promotionsDatatableFeeder = DatatableController::buildDatatable(DatatableController::PROMOTION_DATATABLE);
        
        $eventDatatableFeeder = DatatableController::buildDatatable(DatatableController::EVENT_DATATABLE);

        $view = View::make('admin.home')
                ->with($etsDatatableFeeder->getId(), $etsDatatableFeeder->getViewParamsArray())
                ->with($bookingDatatableFeeder->getId(), $bookingDatatableFeeder->getViewParamsArray())
                ->with($businessCategoriesDatatableFeeder->getId(), $businessCategoriesDatatableFeeder->getViewParamsArray())
                ->with($promotionsDatatableFeeder->getId(), $promotionsDatatableFeeder->getViewParamsArray())
                ->with($eventDatatableFeeder->getId(), $eventDatatableFeeder->getViewParamsArray())
                ;
        return $view;
    }


}
