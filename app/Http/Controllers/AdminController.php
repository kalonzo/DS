<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

class AdminController extends Controller {

    public function index() {
        $etsDatatableFeeder = DatatableController::buildDatatable(DatatableController::ESTABLISHMENT_DATATABLE);

        $view = View::make('admin.home')->with($etsDatatableFeeder->getId(), $etsDatatableFeeder->getViewParamsArray());
        return $view;
    }


}
