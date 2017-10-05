<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Requests\StoreUserPro;
use App\Models\Address;
use App\Models\BusinessType;
use App\Models\CallNumber;
use App\Models\Company;
use App\Models\Country;
use App\Models\Establishment;
use App\Models\PaymentMethod;
use App\Models\User;
use App\php;
use App\Utilities\DbQueryTools;
use App\Utilities\StorageHelper;
use App\Utilities\UuidTools;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use View;

class UserProController extends Controller {

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
        $user = null; // TODO Search for matching user
        $this->buildFeedFormData();
        $this->buildCreateFormValues();
        $formData = StorageHelper::getInstance()->get('feed_user.form_data');
        $formValues = StorageHelper::getInstance()->get('feed_user.form_values');
        $view = View::make('pro_user.register')
                ->with('form_data', $formData)->with('form_values', $formValues)->with('user', $user)
                ->with('disableQuickSearch', true);

        return $view;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\php  $php
     * @return Response
     */
    public function show(php $php) {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserPro  $request
     * @return Response
     */
    public function store(StoreUserPro $request) {
        $response = response();
        $jsonResponse = array('success' => 0, 'triggerMode' => 1);
        $createdObjects = array();
        $payment = null;
        try {
            $uuidEstablishment = $request->get('id_establishment');
            $uuidSubscription = $request->get('id_subscription');
            $businessType = $request->get('business_type');
            $uuidUser = $request->get('id_user');
            $idCountry = $request->get('address.id_country');

            $user = User::findUuid($uuidUser);
            $subscriptionItem = \App\Models\BuyableItem::findUuid($uuidSubscription);
            if (checkModel($subscriptionItem)) {
                if(!checkModel($user)){
                    $user = User::where('status', '=', User::STATUS_CREATION_PENDING)->where('email', 'LIKE', $request->get('user.email'))->first();
                } 
                $idCompany = 0;
                if(checkModel($user)){
                    $company = $user->company()->first();
                    if(checkModel($company)){
                        if(empty($request->get('user.company'))){
                            $company->delete();
                        } else {
                            $company->update([
                                'name' => $request->get('user.company'),
                            ]);
                            $idCompany = $company->getId();
                        }
                    }
                    
                    $user->update([
                        'gender' => $request->get('user.gender'),
                        'name' => $request->get('user.email'),
                        'email' => $request->get('user.email'),
                        'firstname' => $request->get('user.firstname'),
                        'lastname' => $request->get('user.lastname'),
                        'password' => bcrypt($request->get('user.password')),
                    ]);
                    $userId = $user->getId();
                } else {
                    $userId = UuidTools::generateUuid();
                    if (!empty($request->get('user.company'))) {
                        $company = Company::create([
                                    'id' => UuidTools::generateUuid(),
                                    'name' => $request->get('user.company'),
                                    'id_logo' => 0
                        ]);
                        $createdObjects[] = $company;
                        $idCompany = $company->getId();
                    }

                    $user = User::create([
                                'id' => $userId,
                                'type' => User::TYPE_USER_PRO,
                                'status' => User::STATUS_CREATION_PENDING,
                                'gender' => $request->get('user.gender'),
                                'name' => $request->get('user.email'),
                                'firstname' => $request->get('user.firstname'),
                                'lastname' => $request->get('user.lastname'),
                                'email' => $request->get('user.email'),
                                'password' => bcrypt($request->get('user.password')),
                                'id_company' => $idCompany,
                                'id_address' => 0,
                                'id_inbox' => 0,
                    ]);
                    $createdObjects[] = $user;
                }

                if(checkModel($user)) {
                    SessionController::getInstance()->setIdPendingUser($user->getId());
                    $jsonResponse['id_user'] = $user->getUuid();
                    
                    $callNumbers = $this->feedCallNumbers($request, $user, 'user');
                    $createdObjects = array_merge($createdObjects, $callNumbers);
                    
                    $cart = $user->getCurrentPendingCart();
                    if(!checkModel($cart)){
                        $cart = \App\Models\Cart::create([
                                'id' => UuidTools::generateUuid(),
                                'id_user' => $user->getId(),
                                'status' => \App\Models\Cart::STATUS_PENDING,
                                'id_currency' => \App\Utilities\CurrencyTools::getIdCurrencyFromLocale()
                        ]);
                        $createdObjects[] = $cart;
                    } else {
                        $cart->removeAllLines();
                    }
                    if(checkModel($cart)){
                        $cartLine = $subscriptionItem->convertToCartLine();
                        $createdObjects[] = $cartLine;
                        $cart->addLine($cartLine);
                        $cart->updateAmounts();

                        $payment = $cart->getOrCreatePayment();
                        if(checkModel($payment)){
                            $createdObjects[] = $payment;
                            $idPaymentMethod = $request->get('payment_method');
                            $payment->setIdPaymentMethod($idPaymentMethod)->save();
                            
                            $cart->setStatus(\App\Models\Cart::STATUS_CHECKEDOUT)->save();
                            
                            if(checkRight(\App\Models\Action::CREATE_USER_PRO_ADMIN)){
                                $establishment = Establishment::findUuid($uuidEstablishment);
                                if(checkModel($establishment)){
                                    $establishment->setIdUserOwner($user->getId());
                                    $establishment->save();
                                }
                            }
                            
                            $subscriptionStatus = null;
                            $billStatus = null;
                            $contractStatus = \App\Models\Contract::STATUS_PROCESSING;
                            $businessStatus = 0;
                            switch($idPaymentMethod){
                                case PaymentMethod::METHOD_30_DAYS_BILL:
                                    $subscriptionStatus = \App\Models\Subscription::STATUS_WAITING_4_PAYMENT;
                                    $billStatus = \App\Models\Bill::STATUS_CREATED;
                                    $contractStatus = \App\Models\Contract::STATUS_ACTIVE;
                                    $businessStatus = 25;
                                    break;
                                case PaymentMethod::METHOD_PACKAGE_INCLUDED:
                                case PaymentMethod::METHOD_FREE_PASS:
                                case PaymentMethod::METHOD_DELAYED_PAYMENT:
                                    $jsonResponse['relocateMode'] = 1;
                                    $jsonResponse['location'] = '/admin';
                                    unset($jsonResponse['triggerMode']);
                                    $businessStatus = 25;
                                    if($idPaymentMethod === PaymentMethod::METHOD_FREE_PASS){
                                        $subscriptionStatus = \App\Models\Subscription::STATUS_ACTIVE;
                                        $billStatus = \App\Models\Bill::STATUS_PAID;
                                        $contractStatus = \App\Models\Contract::STATUS_ACTIVE;
                                    } else {
                                        $subscriptionStatus = \App\Models\Subscription::STATUS_WAITING_4_PAYMENT;
                                        $billStatus = \App\Models\Bill::STATUS_CREATED;
                                    }
                                    break;
                                default :
                                    $walleeController = App::make(WalleeController::class);
                                    if ($walleeController instanceof WalleeController) {
                                        $walleeJsonResponse = $walleeController->startCheckout($payment, $cart, $user, WalleeController::CHECKOUT_OP_SUBSCRIPTION);
                                        $jsonResponse = array_merge($jsonResponse, $walleeJsonResponse);
                                        $subscriptionStatus = \App\Models\Subscription::STATUS_WAITING_4_PAYMENT;
                                        $billStatus = \App\Models\Bill::STATUS_CREATED;
                                    } else {
                                        $jsonResponse['error'] = "Le controller de paiement a connu une erreur. Veuillez avertir le webmaster.";
                                    }
                                    break;
                            }
                            
                            if($subscriptionStatus !== null){
                                $duration = $request->get('duration');
                                $startDate = new DateTime();
                                $startDateFormatted = $startDate->format('Y-m-d H:i:s');
                                
                                $endDate = date_add($startDate, new DateInterval('P'.$duration.'Y'));
                                $endDateFormatted = $endDate->format('Y-m-d H:i:s');
                                
                                $contract = \App\Models\Contract::create([
                                    'id' => UuidTools::generateUuid(),
                                    'status' => $contractStatus,
                                    'start_date' => $startDateFormatted,
                                    'end_date' => $endDateFormatted,
                                    'id_user_in_charge' => 0,
                                    'id_establishment_customer' => 0,
                                    'id_user_customer' => $user->getId(),
                                    'type_business' => $businessType
                                ]);
                                $contract->generateNumber();
                                $createdObjects[] = $contract;
                                
                                $bill = \App\Models\Bill::create([
                                    'id' => UuidTools::generateUuid(),
                                    'status' => $billStatus,
                                    'title' => $request->get('bill.title'),
                                    'lastname' => $request->get('bill.lastname'),
                                    'firstname' => $request->get('bill.firstname'),
                                    'company_name' => $request->get('bill.company_name'),
                                    'email' => $request->get('bill.email'),
                                    'id_user' => $user->getId(),
                                    'id_cart' => $cart->getId(),
                                    'id_contract' => $contract->getId()
                                ]);
                                $createdObjects[] = $bill;
                                $payment->setIdBill($bill->getId())->save();
                                $cart->setStatus(\App\Models\Cart::STATUS_BILL)->save();
                                
                                $callNumbers = $this->feedCallNumbers($request, $bill, 'bill');
                                $createdObjects = array_merge($createdObjects, $callNumbers);
                                
                                $address = Address::create([
                                    'id' => UuidTools::generateUuid(),
                                    'title' => $request->get('bill.title'),
                                    'company_name' => $request->get('bill.company_name'),
                                    'firstname' => $request->get('bill.firstname'),
                                    'lastname' => $request->get('bill.lastname'),
                                    'email' => $request->get('bill.email'),
                                    'street' => $request->get('address.street'),
                                    'street_number' => $request->get('address.street_number'),
                                    'postal_code' => $request->get('address.postal_code'),
                                    'po_box' => $request->get('address.po_box'),
                                    'city' => $request->get('address.city'),
                                    'id_country' => $idCountry,
                                    'id_object_related' => $bill->getId(),
                                    'type_object_related' => \App\Models\Bill::TYPE_GLOBAL_OBJECT,
                                    'id_location_index' => 0,
                                ]);
                                $createdObjects[] = $address;
                                
                                $subscription = \App\Models\Subscription::create([
                                    'id' => UuidTools::generateUuid(),
                                    'status' => $subscriptionStatus,
                                    'priceTTC' => $subscriptionItem->getPriceTTC(),
                                    'start_date' => $startDateFormatted,
                                    'end_date' => $endDateFormatted,
                                    'id_establishment' => 0,
                                    'id_user' => $user->getId(),
                                    'id_bill' => $bill->getId(),
                                    'id_buyable_item' => $subscriptionItem->getId(),
                                    'duration' => $duration * 12
                                ]);
                                $createdObjects[] = $subscription;
                                
                                $establishment = Establishment::create([
                                    'id' => UuidTools::generateUuid(),
                                    'status' => Establishment::STATUS_INCOMPLETE,
                                    'id_user_owner' => $user->getId(),
                                    'id_address' => 0,
                                    'id_business_type' => $businessType,
                                    'business_status' => $businessStatus,
                                    'slug' => '',
                                    'url_id' => 0,
                                ]);
                                $createdObjects[] = $establishment;
                                
                                if($idPaymentMethod != PaymentMethod::METHOD_CB){
                                    $jsonResponse['success'] = 1;
                                    $jsonResponse['relocateMode'] = 1;
                                    unset($jsonResponse['triggerMode']);
                                    if(isAdmin()){
                                        $jsonResponse['location'] = '/admin';
                                    } else {
                                        $jsonResponse['location'] = '/establishment/register/success?id_user='.$user->getUuid();
                                        // TODO Auth user activation
                                    }
                                }
                            }
                        } else {
                            $jsonResponse['error'] = "Le processus de paiement n'a pas pu être initié";
                        }
                    } else {
                        $jsonResponse['error'] = "Le panier n'a pas pu être créé";
                    }
                } else {
                    $jsonResponse['error'] = "Les données saisies ne permettent pas de créer correctement le compte utilisateur";
                }
            } else {
                $jsonResponse['error'] = "Aucun abonnement sélectionné";
            }
        } catch (Exception $e) {
            // TODO Report error in log system
            $jsonResponse['error'] = $e->getMessage();
            try{
                foreach ($createdObjects as $createdObject) {
                    if ($createdObject instanceof Model) {
                        $deleted = $createdObject->delete();
                    } else {
                        print_r($createdObject);
                    }
                }
            } catch(Exception $ex){
                $jsonResponse['error'] = $ex->getMessage();
            }
            $jsonResponse['success'] = 0;
        }
        if(!$jsonResponse['success'] && checkModel($payment)){
            $payment->setStatus(\App\Models\Payment::STATUS_ERROR_CHECKOUT)->save();
        }
        
        $responsePrepared = $response->json($jsonResponse);
        return $responsePrepared;
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
    public function update() {

        return redirect('/admin');
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

    public function buildFeedFormData() {
        // Business categories
        $businessTypes = array();
        $businessTypesData = BusinessType::select([BusinessType::TABLENAME.'.*', \App\Models\EstablishmentMedia::TABLENAME.'.local_path'])
                                        ->leftJoin(\App\Models\EstablishmentMedia::TABLENAME, \App\Models\EstablishmentMedia::TABLENAME.'.id', '='
                                                    , BusinessType::TABLENAME.'.id_media')
//                                        ->where(BusinessType::TABLENAME.'.status', '=', BusinessType::STATUS_ACTIVE)
                                        ->orderBy(BusinessType::TABLENAME.'.id')
                                        ->get();
        foreach ($businessTypesData as $businessTypeData) {
            $businessTypes[$businessTypeData->id]['label'] = $businessTypeData->label;
            $businessTypes[$businessTypeData->id]['url_media'] = asset($businessTypeData->local_path);
            $businessTypes[$businessTypeData->id]['enabled'] = $businessTypeData->status === BusinessType::STATUS_ACTIVE ? true : false;
        }

        // Payment methods
        $availableMethods = array(PaymentMethod::METHOD_CB, PaymentMethod::METHOD_30_DAYS_BILL);
        if(checkRight(\App\Models\Action::CREATE_USER_PRO_ADMIN)){
            $availableMethods[] = PaymentMethod::METHOD_PACKAGE_INCLUDED;
            $availableMethods[] = PaymentMethod::METHOD_FREE_PASS;
            $availableMethods[] = PaymentMethod::METHOD_DELAYED_PAYMENT;
        }
        $paymentMethods = array();
        $paymentMethodsData = DB::table(PaymentMethod::TABLENAME)
                ->select('id', 'name')
                ->whereIn('id', $availableMethods)
                ->orderBy('name')
                ->get();
        foreach ($paymentMethodsData as $paymentMethod) {
            $paymentMethods[$paymentMethod->id] = $paymentMethod->name;
        }

        // Call number prefixes
        $countryPrefixes = array();
        $countryNames = array();
        $countriesData = DB::table(Country::TABLENAME)
                ->select(['id', 'label', 'prefix'])
                ->where('prefix', '>', 0)
                ->orderBy('label')
                ->get();
        $countriesData->map(function($item, $key) {
            // Translate country name
            $item->label = __($item->label);
            return $item;
        });
        foreach ($countriesData as $countryData) {
            $countryPrefixes[$countryData->id] = $countryData->label . " | +" . $countryData->prefix;
            $countryNames[$countryData->id] = $countryData->label;
        }
        // Sort list by translated country name
        asort($countryPrefixes);
        asort($countryNames);

        $subscriptions = \App\Models\BuyableItem::selectRaw(DbQueryTools::genRawSqlForGettingUuid() . ', id, designation, net_price, color')
                        ->whereIn('type', [
                                            \App\Models\BuyableItem::TYPE_PRO_SUBSCRIPTION_LEVEL1,
                                            \App\Models\BuyableItem::TYPE_PRO_SUBSCRIPTION_LEVEL2,
                                            \App\Models\BuyableItem::TYPE_PRO_SUBSCRIPTION_LEVEL3,
                                            \App\Models\BuyableItem::TYPE_PRO_SUBSCRIPTION_LEVEL4
                        ])->where('status', '=', \App\Models\BuyableItem::STATUS_ACTIVE)
                        ->orderBy('net_price', 'ASC')->get();
        
        $durations = [1 => "1 an", 3 => "3 ans", 5 => "5 ans"];

        StorageHelper::getInstance()->add('feed_user.form_data.business_types', $businessTypes);
        StorageHelper::getInstance()->add('feed_user.form_data.payment_methods', $paymentMethods);
        StorageHelper::getInstance()->add('feed_user.form_data.country_prefixes', $countryPrefixes);
        StorageHelper::getInstance()->add('feed_user.form_data.country_ids', $countryNames);
        StorageHelper::getInstance()->add('feed_user.form_data.subscriptions', $subscriptions);
        StorageHelper::getInstance()->add('feed_user.form_data.durations', $durations);
    }

    /**
     * 
     * @param Establishment $establishment
     */
    public function buildCreateFormValues() {
        $idCountry = Country::where('iso', 'LIKE', App::getLocale())->first()->getId();


        StorageHelper::getInstance()->add('feed_user.form_values.id_country', $idCountry);
        StorageHelper::getInstance()->add('feed_user.form_values.business_type', BusinessType::TYPE_BUSINESS_RESTAURANT);
    }

    /**
     * 
     * @param StoreUserPro $request
     * @param \App\Models\Bill|User $entity
     */
    public function feedCallNumbers($request, $entity, $prefix) {
        $jsonResponse = array();
        $callNumbers = array();
        $prefixByIdCountry = array();
        $numberTypesToDelete = array();
        // Get all country ids matching each selected number prefix
        $prefixCountryIds = array();
        
        try {
            foreach ($request->get($prefix.'.id_country_prefix') as $typeNumber => $idPrefix) {
                if (!empty($request->get($prefix.'.call_number.' . $typeNumber)) && checkModelId($idPrefix)) {
                    $prefixCountryIds[$idPrefix] = $idPrefix;
                } else {
                    $numberTypesToDelete[] = $typeNumber;
                }
            }
            // Delete existing number removed by the user
            /*
            if (!empty($numberTypesToDelete)) {
                $user->callNumbers()->whereIn('type', $numberTypesToDelete)->delete();
            }
             */
            if (!empty($prefixCountryIds)) {
                // Get all countries data matching each selected number prefix
                $prefixCountries = DB::table(Country::TABLENAME)->whereIn('id', $prefixCountryIds)
                                ->select(['prefix', 'id'])->get();
                foreach ($prefixCountries as $countryData) {
                    $prefixByIdCountry[$countryData->id] = $countryData->prefix;
                }

                foreach ($request->get($prefix.'.call_number') as $typeNumber => $number) {
                    $numberLabel = null;
                    $prefix = null;
                    $isMain = false;
                    switch ($typeNumber) {
                        case CallNumber::TYPE_PHONE_PRO:
                            $numberLabel = 'Téléphone professionnel';
                            if($entity instanceof \App\Models\Bill){
                                $isMain = true;
                            }
                            break;
                        case CallNumber::TYPE_PHONE_CONTACT:
                            $numberLabel = 'Téléphone';
                            if($entity instanceof \App\Models\User){
                                $isMain = true;
                            }
                            break;
                        case CallNumber::TYPE_FAX:
                            $numberLabel = 'Numéro de fax';
                            break;
                        case CallNumber::TYPE_MOBILE:
                            $numberLabel = 'Téléphone mobile';
                            break;
                    }
                    $prefixCountryUuid = $request->get($prefix.'.id_country_prefix.' . $typeNumber);
                    var_dump($prefixCountryUuid);
                    if (isset($prefixByIdCountry[$prefixCountryUuid])) {
                        $prefix = $prefixByIdCountry[$prefixCountryUuid];
                    }

                    if (!empty($typeNumber) && !empty($prefix) && !empty($number)) {
                        $callNumber = $entity->callNumbers()->where('type', '=', $typeNumber)->first();
                        $attributes = [
                            'main' => $isMain,
                            'label' => $numberLabel,
                            'type' => $typeNumber,
                            'prefix' => $prefix,
                            'id_country' => $prefixCountryUuid,
                            'number' => $number,
                            'id_object_related' => $entity->getId(),
                            'type_object_related' => $entity::TYPE_GLOBAL_OBJECT,
                        ];

                        if (!checkModel($callNumber)) {
                            $attributes['id'] = UuidTools::generateUuid();
                            $callNumber = CallNumber::create($attributes);
                        } else {
                            $callNumber->update($attributes);
                        }
                        $callNumbers[] = $callNumber;
                    }
                }
            }
        } catch (Exception $e) {
            $jsonResponse['error'] = $e->getMessage();
            // TODO Manage error
        }
        return $callNumbers;
    }
}
