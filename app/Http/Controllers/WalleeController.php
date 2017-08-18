<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Requests\StoreEstablishment;
use App\Models\CallNumber;
use App\Models\Country;
use App\Models\PaymentMethod;
use App\Models\BusinessType;
use App\Models\Establishment;
use App\php;
use App\Utilities\DbQueryTools;
use App\Utilities\StorageHelper;
use App\Utilities\UuidTools;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use View;

class WalleeController extends Controller {

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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\php  $php
     * @return Response
     */
    public function show() {
        // Setup API client
        $client = new \Wallee\Sdk\ApiClient('592', 'SSh8KJebkHmR7zhQJ58jCONIX5kk64uITe8CRgccdHs=');
         $transaction = new \Wallee\Sdk\Model\TransactionCreate();
         $transaction->setCurrency('CHF');
        // $transaction->set('CHF');
        
        // Create API service instance
        $service = new \Wallee\Sdk\Service\TransactionService($client);
        
        // The filter which restricts the entities which are used to calculate the count.
        $filter = new \Wallee\Sdk\Model\EntityQueryFilter();

        try {
            $result = $apiService->count($filter);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling AccountService->count: ', $e->getMessage(), PHP_EOL;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreEstablishment  $request
     * @return Response
     */
    public function store() {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Establishment $establishment
     * @return Response
     */
    public function edit(Establishment $establishment) {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  Establishment  $establishment
     * @return Response
     */
    public function update() {
        
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

}
