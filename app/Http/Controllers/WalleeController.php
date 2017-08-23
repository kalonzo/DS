<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Requests\StoreEstablishment;
use App\Models\CallNumber;
use App\Models\Country;
use App\Models\PaymentMethod;
use App\Models\BusinessType;
use App\Models\Establishment;
use App\Utilities\DbQueryTools;
use App\Utilities\StorageHelper;
use App\Utilities\UuidTools;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use View;

class WalleeController extends Controller {
    
    const API_CLIENT_KEY = 'SSh8KJebkHmR7zhQJ58jCONIX5kk64uITe8CRgccdHs=';
    const API_CLIENT_USER_ID = 592;
    const MAIN_SPACE_ID = 454;

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function startCheckout() {
        $jsonResponse = array('success' => 0);
        $response = response();
        $cookies = array();
        
        try{
            // Setup API client
            $client = new \Wallee\Sdk\ApiClient(self::API_CLIENT_USER_ID, self::API_CLIENT_KEY);

            // Create API service instance
            $service = new \Wallee\Sdk\Service\TransactionService($client);

            $transaction = null;
            $idTransaction = SessionController::getInstance()->getIdTransactionProUser();
            if(!empty($idTransaction)){
                $transaction = $service->read(self::MAIN_SPACE_ID, $idTransaction);
            }
            if(empty($transaction) || !$transaction->isValid() || empty($transaction->getId()) || $transaction->getState() != \Wallee\Sdk\Model\TransactionState::PENDING){
                $lineItem = new \Wallee\Sdk\Model\LineItemCreate();
                $lineItem->setSku('CH_RESTO_PRO');
                $lineItem->setName('abonement_110');
                $lineItem->setQuantity(1);
                $lineItem->setAmountIncludingTax(100.5);
                $lineItem->setUniqueId(UuidTools::getUuid(UuidTools::generateUuid()));
                $lineItem->setType(\Wallee\Sdk\Model\LineItemType::FEE);

                $transactionPending = new \Wallee\Sdk\Model\TransactionPending();
                $transactionPending->setCurrency('CHF');
                $transactionPending->setCustomerEmailAddress('kalonzo@bluewin.ch');
                $transactionPending->setLineItems(array($lineItem));
                $transactionPending->setFailedUrl(url('/complete_order').'?error=1');
                $transactionPending->setSuccessUrl(url('/complete_order').'?success=1');

                $transaction = $service->create(self::MAIN_SPACE_ID, $transactionPending);
            }

    //        $paymentMethodConfiguration = $service->fetchPossiblePaymentMethods(454, $transaction->getId());
            if(!empty($transaction) && $transaction->isValid() && !empty($transaction->getId())){
                $url = $service->buildJavaScriptUrl(self::MAIN_SPACE_ID, $transaction->getId());
                if(!empty($url)){
                    SessionController::getInstance()->setIdTransactionProUser($transaction->getId());
                    $jsonResponse['url'] = $url;
                    $jsonResponse['success'] = 1;
                }
            }
        } catch(Exception $e){
            $jsonResponse['error'] = $e->getMessage();
        }

        $responsePrepared = $response->json($jsonResponse);
        foreach($cookies as $cookie){
            $responsePrepared->withCookie($cookie);
        }
        return $responsePrepared;
    }
    
    /**
     * 
     * @return \Illuminate\Http\Response
     */
    public function createOrder(){
        $jsonResponse = array('success' => 0);
        $response = response();
        $cookies = array();
        $idTransaction = SessionController::getInstance()->getIdTransactionProUser();
        
        if(!empty($idTransaction)){
            $client = new \Wallee\Sdk\ApiClient(self::API_CLIENT_USER_ID, self::API_CLIENT_KEY);
            $service = new \Wallee\Sdk\Service\TransactionService($client);
            
            $transaction = $service->read(self::MAIN_SPACE_ID, $idTransaction);
            if(!$transaction->isValid()){
                $transaction = $service->confirm(self::MAIN_SPACE_ID, $transaction);
                if($transaction->getState() == \Wallee\Sdk\Model\TransactionState::CONFIRMED){
                    $jsonResponse['success'] = 1;
                }
            }
        }
        
        $responsePrepared = $response->json($jsonResponse);
        foreach($cookies as $cookie){
            $responsePrepared->withCookie($cookie);
        }
        return $responsePrepared;
    }
    
    public function completeOrder(Request $request){
        print_r($request->all());
        die();
    }

}
