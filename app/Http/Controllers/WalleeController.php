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
        //taxes

        $lineItem = new \Wallee\Sdk\Model\LineItemCreate();
        
        $lineItem->setSku('CH_RESTO_PRO');
        $lineItem->setName('abonement_110');
        $lineItem->setQuantity(1);
       // $lineItem->setTaxes($tax);
        $lineItem->setAmountIncludingTax(283.5);
        $lineItem->setUniqueId(UuidTools::getUuid(UuidTools::generateUuid()));
        $lineItem->setType(\Wallee\Sdk\Model\LineItemType::FEE);
        
         $transactionPending = new \Wallee\Sdk\Model\TransactionPending();
         $transactionPending->setCurrency('CHF');
         $transactionPending->setLineItems(array($lineItem));
         $transactionPending->setId(15);
         $transactionPending->setVersion(1);
         $transactionPending->validate();
        
        // Create API service instance
        $service = new \Wallee\Sdk\Service\TransactionService($client);
      $transaction =   $service->confirm(454, $transactionPending);
      var_dump($transaction->getId()); 
       $url =  $service->buildJavaScriptUrl(454, $transaction->getId());
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
