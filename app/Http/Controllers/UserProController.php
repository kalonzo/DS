<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Requests\StoreUserPro;
use App\Models\Address;
use App\Models\BusinessType;
use App\Models\Company;
use App\Models\Country;
use App\Models\Establishment;
use App\Models\Model;
use App\Models\PaymentMethod;
use App\Models\User;
use App\php;
use App\Utilities\DbQueryTools;
use App\Utilities\StorageHelper;
use App\Utilities\UuidTools;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use NumberFormatter;
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
        $jsonResponse = array('success' => 0);
        $createdObjects = array();
        try {
            $uuidSubscription = $request->get('id_subscription');
            $businessType = $request->get('business_type');

            $subscriptionItem = \App\Models\BuyableItem::findUuid($uuidSubscription);
            if (checkModel($subscriptionItem)) {
                $company = Company::where('name', '=', $request->get('company.name'))->first();
                if (!checkModel($company) && !empty($request->get('company.name'))) {
                    $company = Company::create([
                                'id' => UuidTools::generateUuid(),
                                'name' => $request->get('company.name')
                    ]);
                    $createdObjects[] = $company;
                }
                $userId = UuidTools::generateUuid();

                $country = Country::findUuid($request->get('address.id_country'));
                if (checkModel($country)) {
                    $address = Address::create([
                                'id' => UuidTools::generateUuid(),
                                'firstname' => $request->get('address.firstname'),
                                'lastname' => $request->get('address.lastname'),
                                'street' => $request->get('address.street'),
                                'street_number' => $request->get('address.street_number'),
                                'postal_code' => $request->get('address.postal_code'),
                                'po_box' => $request->get('address.po_box'),
                                'city' => $request->get('address.city'),
                                'id_country' => $request->get('address.id_country'),
                                'country' => $country->getLabel(),
                                'id_object_related' => $userId,
                                'type_object_related' => User::TYPE_GLOBAL_OBJECT,
                    ]);
                    $createdObjects[] = $address;

                    if (checkModel($address)) {
                        $user = User::create([
                                    'id' => $userId,
                                    'type' => User::TYPE_USER_PRO,
                                    'gender' => $request->get('gender'),
                                    'firstname' => $request->get('firstname'),
                                    'lastname' => $request->get('lastname'),
                                    'email' => $request->get('email'),
                                    'password' => bcrypt($request->get('password')), // TODO Auth user activation
                                    'id_company' => $company->getId(),
                                    'id_address' => $address->getId(),
                                    'id_inbox' => 0,
                        ]);
                        $createdObjects[] = $user;

                        if (checkModel($user)) {
                            $jsonResponse['id_user'] = $user->getUuid();
                            
                            $cart = \App\Models\Cart::create([
                                    'id' => UuidTools::generateUuid(),
                                    'id_user' => $user->getId(),
                                    'status' => \App\Models\Cart::STATUS_PENDING,
                                    'id_currency' => \App\Utilities\CurrencyTools::getCurrencyFromLocale()
                            ]);
                            $createdObjects[] = $cart;

                            if(checkModel($cart)){
                                $cartLine = $subscriptionItem->convertToCartLine();
                                $createdObjects[] = $cartLine;
                                $cart->addLine($cartLine);
                                $cart->updateAmounts();
                                
                                $payment = $cart->getOrCreatePayment();
                                if(checkModel($payment)){
                                    $createdObjects[] = $payment;
                                    $paymentMethod = $request->get('payment_method');
                                    $payment->setIdPaymentMethod($paymentMethod)->save();
                                    try {
                                        $walleeController = \Illuminate\Support\Facades\App::make(WalleeController::class);
                                        if ($walleeController instanceof WalleeController) {
                                            $walleeJsonResponse = $walleeController->startCheckout($payment, $cart, $user);
                                            $jsonResponse = array_merge($jsonResponse, $walleeJsonResponse);
                                        }
                                    } catch (Exception $ex) {
                                        $jsonResponse['error'] = $e->getMessage();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            // TODO Report error in log system
            print_r($e->getMessage());

            foreach ($createdObjects as $createdObject) {
                if ($createdObject instanceof Model) {
                    $createdObject->delete();
                }
            }
            die();
        }
        
        $responsePrepared = $response->json($jsonResponse);
        return $responsePrepared;
//        return redirect('/establishment/create');
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
        $businessTypeData = DB::table(BusinessType::TABLENAME)
                ->selectRaw(DbQueryTools::genRawSqlForGettingUuid() . ',label')
                ->orderBy('label')
                ->get();
        foreach ($businessTypeData as $businessCategoryData) {
            $businessTypes[$businessCategoryData->uuid] = $businessCategoryData->label;
        }

        // Payment methods
        $paymentMethods = array();
        $paymentMethodsData = DB::table(PaymentMethod::TABLENAME)
                ->select('id', 'name')
                ->orderBy('name')
                ->get();
        foreach ($paymentMethodsData as $paymentMethod) {
            $paymentMethods[$paymentMethod->id] = $paymentMethod->name;
        }

        // Call number prefixes
        $countryPrefixes = array();
        $countryNames = array();
        $countriesData = DB::table(Country::TABLENAME)
                ->selectRaw(DbQueryTools::genRawSqlForGettingUuid() . ', label, prefix')
                ->where('prefix', '>', 0)
                ->orderBy('label')
                ->get();
        $countriesData->map(function($item, $key) {
            // Translate country name
            $item->label = __($item->label);
            return $item;
        });
        foreach ($countriesData as $countryData) {
            $countryPrefixes[$countryData->uuid] = $countryData->label . " | +" . $countryData->prefix;
            $countryNames[$countryData->uuid] = $countryData->label;
        }
        // Sort list by translated country name
        asort($countryPrefixes);
        asort($countryNames);

        $subscriptions = \App\Models\BuyableItem::selectRaw(DbQueryTools::genRawSqlForGettingUuid() . ', id, designation, net_price, color')
                        ->where('type', '=', \App\Models\BuyableItem::TYPE_PRO_SUBSCRIPTION)->where('status', '=', \App\Models\BuyableItem::STATUS_ACTIVE)
                        ->orderBy('net_price', 'ASC')->get();

        StorageHelper::getInstance()->add('feed_user.form_data.business_types', $businessTypes);
        StorageHelper::getInstance()->add('feed_user.form_data.payment_methods', $paymentMethods);
        StorageHelper::getInstance()->add('feed_user.form_data.country_prefixes', $countryPrefixes);
        StorageHelper::getInstance()->add('feed_user.form_data.country_ids', $countryNames);
        StorageHelper::getInstance()->add('feed_user.form_data.subscriptions', $subscriptions);
    }

    /**
     * 
     * @param Establishment $establishment
     */
    public function buildCreateFormValues() {
        $idCountry = Country::where('iso', 'LIKE', App::getLocale())->first()->getUuid();


        StorageHelper::getInstance()->add('feed_user.form_values.id_country', $idCountry);
        StorageHelper::getInstance()->add('feed_user.form_values.business_type', BusinessType::TYPE_BUSINESS_RESTAURANT);
    }

}
