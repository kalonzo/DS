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
     * @param \App\Models\Payment $payment
     * @param \App\Models\Cart $cart
     * @param \App\Models\User $user
     */
    public function startCheckout($payment, $cart, $user) {
        $jsonResponse = array('success' => 0);
        if(checkModel($payment) && checkModel($cart) && checkModel($user)){
            try{
                // Setup API client
                $client = new \Wallee\Sdk\ApiClient(self::API_CLIENT_USER_ID, self::API_CLIENT_KEY);

                // Create API service instance
                $service = new \Wallee\Sdk\Service\TransactionService($client);

                $transaction = null;
                $idTransaction = $payment->getIdTransaction();//SessionController::getInstance()->getIdTransactionProUser();
                if(!empty($idTransaction)){
                    $transaction = $service->read(self::MAIN_SPACE_ID, $idTransaction);
                }
                if(empty($transaction) || !$transaction->isValid() || empty($transaction->getId())){
                    $lineItems = array();

                    foreach($cart->cartLines() as $cartLine){
                        $lineItem = new \Wallee\Sdk\Model\LineItemCreate();
                        $lineItem->setSku(str_slug($cartLine->getDesignation()));
                        $lineItem->setName($cartLine->getDesignation());
                        $lineItem->setQuantity($cartLine->getQty());
                        $lineItem->setAmountIncludingTax($cartLine->getNetPriceTTC());
                        $lineItem->setUniqueId($cartLine->getUuid());
                        $lineItem->setType(\Wallee\Sdk\Model\LineItemType::PRODUCT);
                        $lineItems[] = $lineItem;
                    }

                    $transactionPending = new \Wallee\Sdk\Model\TransactionPending();
                    $transactionPending->setCurrency($cart->getCurrencyLabel());
                    $transactionPending->setCustomerEmailAddress($user->getEmail());
                    $transactionPending->setLineItems($lineItems);
                    $transactionPending->setFailedUrl(url('/complete_order').'?error=1');
                    $transactionPending->setSuccessUrl(url('/complete_order').'?success=1');

                    $transaction = $service->create(self::MAIN_SPACE_ID, $transactionPending);
                }

        //        $paymentMethodConfiguration = $service->fetchPossiblePaymentMethods(454, $transaction->getId());
                if(!empty($transaction) && $transaction->isValid() && !empty($transaction->getId())){
                    $payment->setIdTransaction($transaction->getId())->save();
                    $url = $service->buildJavaScriptUrl(self::MAIN_SPACE_ID, $transaction->getId());
                    if(!empty($url)){
                        SessionController::getInstance()->setIdTransactionProUser($transaction->getId());
                        $jsonResponse['url'] = $url;
                        $jsonResponse['success'] = 1;
                    }
                }
            } catch(Exception $e){
                $payment->setStatus(\App\Models\Payment::STATUS_ERROR_CHECKOUT)->save();
            }
        }
        return $jsonResponse;
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
