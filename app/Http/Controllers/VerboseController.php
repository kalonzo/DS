<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Requests\StoreEstablishment;
use App\Models\Address;
use App\Models\BusinessCategory;
use App\Models\CallNumber;
use App\Models\Country;
use App\Models\Establishment;
use App\Models\EstablishmentBusinessCategory;
use App\Models\LocationIndex;
use App\Models\Model;
use App\Models\OpeningHour;
use App\Models\Restaurant;
use App\Models\User;
use App\php;
use App\Utilities\DateTools;
use App\Utilities\DbQueryTools;
use App\Utilities\StorageHelper;
use App\Utilities\UuidTools;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use View;

class VerboseController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        /**
        $this->buildFeedFormData();
        $this->buildCreateFormValues();
         * 
         */
        
        $view = View::make('establishment.verbose');

        return $view;
    }

    /**
     * Display the specified resource.
     *
     * @param  Establishment $establishment
     * @return Response
     */
    public function show() {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Establishment $establishment
     * @return Response
     */
    public function edit(Establishment $establishment) {

        return $view;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  Establishment  $establishment
     * @return Response
     */
    public function update(StoreEstablishment $request, Establishment $establishment) {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\php  $php
     * @return Response
     */
    public function destroy(php $php) {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreEstablishment  $request
     * @return Response
     */
    public function store(StoreEstablishment $request) {
        
        return redirect('/admin/establishment/verbose');
    }

    /**
     * 
     * @param Establishment $establishment
     */
    public function buildEditFormValues(Establishment $establishment) {
       
    }

    /**
     * 
     * @param StoreEstablishment $request
     */
    public function storeVerbose($request) {
        
    }

    /**
     * 
     * @param  Request $request
     * @param  Establishment  $establishment
     */
    public function updateBusinessCategory($request, $establishment) {
        $createdObjects = array();
        
    }
}
