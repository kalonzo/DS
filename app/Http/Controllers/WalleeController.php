<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Wallee\Sdk\ApiClient;
use Wallee\Sdk\Model\LineItemCreate;
use Wallee\Sdk\Model\LineItemType;
use Wallee\Sdk\Model\TransactionPending;
use Wallee\Sdk\Model\TransactionState;
use Wallee\Sdk\Service\TransactionService;

class WalleeController extends Controller {
    
    const API_CLIENT_KEY = 'SSh8KJebkHmR7zhQJ58jCONIX5kk64uITe8CRgccdHs=';
    const API_CLIENT_USER_ID = 592;
    const MAIN_SPACE_ID = 454;

    /**
     * Display the specified resource.
     * @param Payment $payment
     * @param Cart $cart
     * @param User $user
     */
    public function startCheckout($payment, $cart, $user) {
        $jsonResponse = array('success' => 0);
        if(checkModel($payment) && checkModel($cart) && checkModel($user)){
            try{
                // Setup API client
                $client = new ApiClient(self::API_CLIENT_USER_ID, self::API_CLIENT_KEY);

                // Create API service instance
                $service = new TransactionService($client);

                $transaction = null;
                $idTransaction = $payment->getIdTransaction();//SessionController::getInstance()->getIdTransactionProUser();
                if(!empty($idTransaction)){
                    $transaction = $service->read(self::MAIN_SPACE_ID, $idTransaction);
                }
                if(empty($transaction) || !$transaction->isValid() || empty($transaction->getId())){
                    $lineItems = array();

                    foreach($cart->cartLines()->get() as $cartLine){
                        if($cartLine instanceof \App\Models\CartLine){
                            $tax = new \Wallee\Sdk\Model\TaxCreate();
                            $tax->setRate($cartLine->getVatRate());
                            $tax->setTitle("Standard");
                            
                            $lineItem = new LineItemCreate();
                            $lineItem->setSku(str_slug($cartLine->getDesignation()));
                            $lineItem->setName($cartLine->getDesignation());
                            $lineItem->setQuantity($cartLine->getQty());
                            $lineItem->setTaxes($tax);
                            $lineItem->setAmountIncludingTax($cartLine->getNetPriceTTC());
                            $lineItem->setUniqueId($cartLine->getUuid());
                            $lineItem->setType(LineItemType::PRODUCT);
                            $lineItems[] = $lineItem;
                        }
                    }

                    $transactionPending = new TransactionPending();
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
                    } else {
                        $jsonResponse['error'] = "Le formulaire de paiement n'a pas pu être affiché";
                    }
                } else {
                    $jsonResponse['error'] = "La transaction n'a pu être générée correctement";
                }
            } catch(Exception $e){
                $payment->setStatus(Payment::STATUS_ERROR_CHECKOUT)->save();
                $jsonResponse['error'] = $e->getMessage();
            }
        } else {
            $jsonResponse['error'] = "Le processus de paiement n'a pu aboutir car les données sont incomplètes";
        }
        return $jsonResponse;
    }
    
    /**
     * 
     * @return Response
     */
    public function createOrder(){
        $jsonResponse = array('success' => 0);
        $response = response();
        $cookies = array();
        $idUser = SessionController::getInstance()->getIdPendingUser();
        $idTransaction = SessionController::getInstance()->getIdTransactionProUser();
        
        if(!empty($idTransaction) && !empty($idUser)){
            $payment = Payment::where('id_transaction', '=', $idTransaction)->first();
            
            if(checkModel($payment) && $payment instanceof Payment && $payment->getIdUser() === $idUser){
                $payment->setStatus(Payment::STATUS_VALID_CHECKOUT)->save();
                $client = new ApiClient(self::API_CLIENT_USER_ID, self::API_CLIENT_KEY);
                $service = new TransactionService($client);

                $transaction = $service->read(self::MAIN_SPACE_ID, $idTransaction);
                if(!$transaction->isValid()){
                    $transaction = $service->confirm(self::MAIN_SPACE_ID, $transaction);
                    if($transaction->getState() == TransactionState::CONFIRMED){
                        $payment->setStatus(Payment::STATUS_PROCESSING)->save();
                        $jsonResponse['success'] = 1;
                    }
                }
            }
        }
        
        $responsePrepared = $response->json($jsonResponse);
        foreach($cookies as $cookie){
            $responsePrepared->withCookie($cookie);
        }
        return $responsePrepared;
    }
    
    public function completeOrder(\Illuminate\Http\Request $request){
        $idUser = SessionController::getInstance()->getIdPendingUser();
        $idTransaction = SessionController::getInstance()->getIdTransactionProUser();
        
        if(!empty($idTransaction) && !empty($idUser)){
            $payment = Payment::where('id_transaction', '=', $idTransaction)->first();
            if(checkModel($payment) && $payment instanceof Payment && $payment->getIdUser() === $idUser){
                if($request->get('success')){
                    $payment->setStatus(Payment::STATUS_AUTHORIZED)->save();
                } else {
                    $payment->setStatus(Payment::STATUS_DENIED)->save();
                }
            }
        }
        print_r($request->all());
        die();
    }

}
