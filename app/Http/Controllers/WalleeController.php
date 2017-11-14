<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\Bill;
use App\Models\Cart;
use App\Models\CartLine;
use App\Models\Contract;
use App\Models\Establishment;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Subscription;
use App\Models\User;
use App\Utilities\DbQueryTools;
use App\Utilities\UuidTools;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Wallee\Sdk\ApiClient;
use Wallee\Sdk\Model\LineItemCreate;
use Wallee\Sdk\Model\LineItemType;
use Wallee\Sdk\Model\TaxCreate;
use Wallee\Sdk\Model\TransactionPending;
use Wallee\Sdk\Model\TransactionState;
use Wallee\Sdk\Service\TransactionService;

class WalleeController extends Controller {
    
    const API_CLIENT_KEY = 'SSh8KJebkHmR7zhQJ58jCONIX5kk64uITe8CRgccdHs=';
    const API_CLIENT_USER_ID = 592;
    const MAIN_SPACE_ID = 454;
    
    const CHECKOUT_OP_SUBSCRIPTION = 1;
    const CHECKOUT_OP_VOUCHER = 2;

    /**
     * Display the specified resource.
     * @param Payment $payment
     * @param Cart $cart
     * @param User $user
     */
    public function startCheckout($payment, $cart, $user, $operation = null) {
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
                        if($cartLine instanceof CartLine){
                            $tax = new TaxCreate();
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
                    
//                    $paymentMethodConfiguration = new \Wallee\Sdk\Model\PaymentMethodConfiguration();
//                    $paymentMethodConfiguration->setId(888);
//                    $paymentConnectorConfiguration = new \Wallee\Sdk\Model\PaymentConnectorConfiguration();
//                    $paymentConnectorConfiguration->setPaymentMethodConfiguration($paymentMethodConfiguration);
//                    
//                    $transactionPending->setPaymentConnectorConfiguration($paymentConnectorConfiguration);

                    $transactionPending->setCurrency($cart->getCurrencyLabel());
                    $transactionPending->setCustomerEmailAddress($user->getEmail());
                    $transactionPending->setCustomerId($user->getUuid());
                    $transactionPending->setLineItems($lineItems);
                    
                    $failedUrl = url('/transaction/error').'?id_cart='.$cart->getUuid();
                    $successUrl = url('/transaction/success').'?id_cart='.$cart->getUuid();
                    switch($operation){
                        case self::CHECKOUT_OP_SUBSCRIPTION:
                            $successUrl = url('/establishment/register/success?id_user='.$user->getUuid());
                            $failedUrl = url('/establishment/register/failure?id_user='.$user->getUuid());
                            break;
                    }
                    $transactionPending->setFailedUrl($failedUrl);
                    $transactionPending->setSuccessUrl($successUrl);

                    $transaction = $service->create(self::MAIN_SPACE_ID, $transactionPending);
                }

                if(!empty($transaction) && $transaction->isValid() && !empty($transaction->getId())){
                    $payment->setIdTransaction($transaction->getId())->save();
                    
                    switch($payment->getMethodConfig()){
                        case PaymentMethod::METHOD_CONFIG_OFFSITE:
                            $payment_page = $service->buildPaymentPageUrl(self::MAIN_SPACE_ID, $transaction->getId());
                            if(!empty($payment_page)){
                               SessionController::getInstance()->setIdTransactionProUser($transaction->getId());
                               $jsonResponse['payment_page'] = $payment_page;
                               $jsonResponse['success'] = 1;
                            } else {
                                 $jsonResponse['error'] = "La page de paiement n'a pas pu être affichée";
                            }
                            break;
                        default :
                            $url = $service->buildJavaScriptUrl(self::MAIN_SPACE_ID, $transaction->getId());
                            if(!empty($url)){
                                SessionController::getInstance()->setIdTransactionProUser($transaction->getId());
                                $jsonResponse['url'] = $url;
                                $jsonResponse['success'] = 1;
                            } else {
                                $jsonResponse['error'] = "Le formulaire de paiement n'a pas pu être affiché";
                            }
                            break;
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
    
    public function transactionSucceed(\Illuminate\Http\Request $request){
        $idCart = $request->get('id_cart');
        
        if(!empty($idCart)){
//            $payment = Payment::where('id_transaction', '=', $idTransaction)->first();
//            if(checkModel($payment) && $payment instanceof Payment && $payment->getIdUser() === $idUser){
//                $user = User::find($idUser);
//                $payment->setStatus(Payment::STATUS_AUTHORIZED)->save();
//            }
        }
        print_r('Transaction succeed!');
        die();
    }

    public function transactionFailed(\Illuminate\Http\Request $request){
        $idCart = $request->get('id_cart');
        
        print_r('Transaction failed!');
        die();
    }
    
    public function subscriptionSucceed(\Illuminate\Http\Request $request){
        $uuidUserUrl = $request->get('id_user');
        $idUserUrl = UuidTools::getId($request->get('id_user'));
        $idUserSession = SessionController::getInstance()->getIdPendingUser();
        $idTransactionSession = SessionController::getInstance()->getIdTransactionProUser();
        
        $errors = array();
        
        if(!empty($idTransactionSession) && !empty($idUserSession) && $idUserSession == $idUserUrl){
            $user = User::findUuid($uuidUserUrl);
            if(checkModel($user)){
                $cart = $user->cart()->orderBy('updated_at', 'DESC')->first();
                if(checkModel($cart) && $cart instanceof Cart){
                    $payment = $cart->payments()->orderBy('updated_at', 'DESC')->first();
                    if(checkModel($payment) && $payment instanceof Payment && $payment->getIdUser() === $idUserSession && $payment->getIdTransaction() === $idTransactionSession){
                        $payment->setStatus(Payment::STATUS_AUTHORIZED)->save();
                        $bill = $cart->bills()->first();
                        if(checkModel($bill) && $bill instanceof Bill){
                            $bill->setStatus(Bill::STATUS_PAID)->save();
                            $contract = $bill->contract()->first();
                            if(checkModel($contract) && $contract instanceof Contract){
                                $contract->setStatus(Contract::STATUS_ACTIVE)->save();
//                                $subscription = Subscription::whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id_bill', $bill->getUuid()))->first();
                                $subscription = $bill->subscriptions()->first();
                                if(checkModel($subscription) && $subscription instanceof Subscription){
                                    $subscription->setStatus(Subscription::STATUS_ACTIVE)->save();
                                    $establishment = $subscription->establishment()->first();
                                    if(checkModel($establishment) && $establishment instanceof Establishment){
                                        $establishment->setBusinessStatus(25)->save();
                                        
                                        $registerController = App::make(RegisterController::class);
                                        if($registerController instanceof RegisterController){
                                            $registerController->registerUserPro($user);
                                        }
                                    } else {
                                        $errors[] = "Impossible d'identifier l'établissement lié.";
                                    }
                                } else {
                                    $errors[] = "Impossible de retrouver les informations d'abonnement.";
                                }
                            } else {
                                $errors[] = "Impossible de retrouver les informations du contrat.";
                            }
                        } else {
                            $errors[] = "Impossible de retrouver les informations de facturation.";
                        }
                    } else {
                        $errors[] = "Impossible de retrouver le détail du paiement.";
                    }
                } else {
                    $errors[] = "Impossible de retrouver le détail de la transaction.";
                }
            } else {
                $errors[] = "Impossible d'identifier l'utilisateur.";
            }
        } else {
            $errors[] = "Impossible d'identifier l'utilisateur et/ou la transaction.";
        }
        
        if(isAdmin()){
            if(empty($errors)){
                \Illuminate\Support\Facades\Request::session()->flash('status', 
                    "L'utilisateur a bien été créé. Un email de confirmation lui a été envoyé avec un lien d'activation qui "
                    . " ouvrira son espace client."
                );
                return redirect(url("/edit/establishment/".$establishment->getUuid()));
            } else {
                \Illuminate\Support\Facades\Request::session()->flash('status', 
                    "L'utilisateur a bien été créé et son paiement a été enregistré. Toutefois des erreurs ont été rencontrées et l'email d'activation n'a"
                    . " pu lui être envoyé. Veuillez contrôler l'état de l'inscription."
                );
                \Illuminate\Support\Facades\Request::session()->flash('error', implode('; ', $errors));
                return redirect(url("/admin"));
            }
        } else {
            $view = \Illuminate\Support\Facades\View::make('pro_user.register-feedback')
                    ->with('success', true)
                    ->with('errors', $errors)
                    ;
        }

        return $view;
    }
    
    public function subscriptionFailed(\Illuminate\Http\Request $request){
        $idUserUrl = $request->get('id_user');
        $idUserSession = SessionController::getInstance()->getIdPendingUser();
        $idTransactionSession = SessionController::getInstance()->getIdTransactionProUser();
        
        $errors = array();
        
        if(!empty($idTransactionSession) && !empty($idUserSession) && $idUserSession == $idUserUrl){
            $user = User::findUuid($idUserSession);
            if(checkModel($user)){
                $cart = $user->cart()->orderBy('updated_at', 'DESC')->first();
                if(checkModel($cart) && $cart instanceof Cart){
                    $payment = $cart->payments()->orderBy('updated_at', 'DESC')->first();
                    if(checkModel($payment) && $payment instanceof Payment && $payment->getIdUser() === $idUserSession && $payment->getIdTransaction() === $idTransactionSession){
                        $payment->setStatus(Payment::STATUS_DENIED)->save();
                    } else {
                        $errors[] = "Impossible de retrouver le détail du paiement.";
                    }
                } else {
                    $errors[] = "Impossible de retrouver le détail de la transaction.";
                }
            } else {
                $errors[] = "Impossible d'identifier l'utilisateur.";
            }
        } else {
            $errors[] = "Impossible d'identifier l'utilisateur et/ou la transaction.";
        }
        
        $view = \Illuminate\Support\Facades\View::make('pro_user.register-feedback')
                ->with('success', false)
                ->with('errors', $errors)
                ;

        return $view;
    }
}
