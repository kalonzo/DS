<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

class AdminController extends Controller {

    public function index() {
        $etsDatatableFeeder = DatatableController::buildDatatable(DatatableController::ESTABLISHMENT_DATATABLE);
        
        $bookingDatatableFeeder = DatatableController::buildDatatable(DatatableController::BOOKING_DATATABLE);

        $view = View::make('admin.home')->with($etsDatatableFeeder->getId(), $etsDatatableFeeder->getViewParamsArray())
                ->with($bookingDatatableFeeder->getId(), $bookingDatatableFeeder->getViewParamsArray());
        return $view;
    }


}
