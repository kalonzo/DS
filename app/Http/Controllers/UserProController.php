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
     * @param  StoreEstablishment  $request
     * @return Response
     */
    public function store() {
        
        
        die("Traitement de informations...");
        
       // return redirect('/admin');
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
                    ->selectRaw(DbQueryTools::genRawSqlForGettingUuid() . ', name')
                    ->orderBy('name')
                    ->get();
        foreach ($paymentMethodsData as $paymentMethod) {
            $paymentMethods[$paymentMethod->uuid] = $paymentMethod->name;
        }

        // Call number prefixes
        $countryPrefixes = array();
        $countryNames = array();
        $countriesData = DB::table(Country::TABLENAME)
                ->selectRaw(DbQueryTools::genRawSqlForGettingUuid() . ', label, prefix')
                ->where('prefix', '>', 0)
                ->orderBy('label')
                ->get();
        $countriesData->map(function($item, $key){
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

        $priceFormatter = new \NumberFormatter(\Illuminate\Support\Facades\App::getLocale(), \NumberFormatter::CURRENCY);
        $subscriptions = array(
            array(
                'price' => $priceFormatter->formatCurrency(250, 'CHF'),
                'color' => 'green',
                'label' => 'Standard',
            ),
            array(
                'price' => $priceFormatter->formatCurrency(350, 'CHF'),
                'color' => 'brown',
                'label' => 'Avancé',
            )
        );
        
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
        $idCountry = Country::where('iso', 'LIKE', \Illuminate\Support\Facades\App::getLocale())->first()->getUuid();
        
        
        StorageHelper::getInstance()->add('feed_user.form_values.id_country', $idCountry);
        StorageHelper::getInstance()->add('feed_user.form_values.business_type', BusinessType::TYPE_BUSINESS_RESTAURANT);
    }

}
