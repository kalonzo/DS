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
        $this->buildFeedFormData();
        $this->buildCreateFormValues();
        $formData = StorageHelper::getInstance()->get('feed_establishment.form_data');
        $formValues = StorageHelper::getInstance()->get('feed_establishment.form_values');
        $view = View::make('establishment.register')
                ->with('form_data', $formData)->with('form_values', $formValues)->with('establishment', null)
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
        // check box for business type
        $businessTypeData = DB::table(BusinessType::TABLENAME)
                ->selectRaw(DbQueryTools::genRawSqlForGettingUuid() . ',label')
                ->orderBy('label')
                ->get();
        foreach ($businessTypeData as $businessCategoryData) {   
                    $businessTools[$businessCategoryData->uuid] = $businessCategoryData->label;
        }
        
        //chekbox payment methods
        $paymentMethods = array();
        $paymentMethodsData = PaymentMethod::selectRaw(DbQueryTools::genRawSqlForGettingUuid() . ', name')
                     ->orderBy('name')
                     ->get();
        
        foreach ($paymentMethodsData as $paymentMethod) {
            $paymentMethods[$paymentMethod->uuid] = $paymentMethod->name;
        }
   

        // Select for call number prefixes
        $countryPrefixes = array();
        $countryName = array();
        $countriesData = DB::table(Country::TABLENAME)
                ->selectRaw(DbQueryTools::genRawSqlForGettingUuid() . ', label, prefix')
                ->where('prefix', '>', 0)
                ->orderBy('label')
                ->get();
        foreach ($countriesData as $countryData) {
            $countryPrefixes[$countryData->uuid] = __($countryData->label) . " | +" . $countryData->prefix;
            $countryName[$countryData->uuid] = __($countryData->label);
        }

        StorageHelper::getInstance()->add('feed_establishment.form_data.business_tools', $businessTools);
        StorageHelper::getInstance()->add('feed_establishment.form_data.payment_methods', $paymentMethods);
        StorageHelper::getInstance()->add('feed_establishment.form_data.country_prefixes', $countryPrefixes);
        StorageHelper::getInstance()->add('feed_establishment.form_data.country_ids', $countryName);
    }

    /**
     * 
     * @param Establishment $establishment
     */
    public function buildCreateFormValues() {
        $idCountry = UuidTools::getUuid(Country::where('iso', '=', 'CH')->first()->getId());
        StorageHelper::getInstance()->add('feed_establishment.form_values.id_country', $idCountry);
    }

    /**
     * 
     * @param Establishment $establishment
     */
    public function buildEditFormValues(Establishment $establishment) {
        // Default ID country
        $idCountry = UuidTools::getUuid($establishment->address()->first()->getIdCountry());
        
        // Call numbers
        $callNumbers = $establishment->callNumbers()->get();
        $callNumbersData = array();
        foreach($callNumbers as $callNumber){
            if($callNumber instanceof CallNumber){
                $callNumbersData[$callNumber->getType()]['id_country_prefix'] = UuidTools::getUuid($callNumber->getIdCountry());
                $callNumbersData[$callNumber->getType()]['number'] = $callNumber->getNumber();
            }
        }
        
        // Business categories
        $businessCategories = $establishment->businessCategoryLinks()->selectRaw(DbQueryTools::genRawSqlForGettingUuid('id_business_category'))->get();
        $businessCategoryIds = $businessCategories->pluck('uuid');
        
        StorageHelper::getInstance()->add('feed_establishment.form_values.id_country', $idCountry);
        StorageHelper::getInstance()->add('feed_establishment.form_values.call_numbers', $callNumbersData);
        StorageHelper::getInstance()->add('feed_establishment.form_values.business_categories', $businessCategoryIds);
    }  

    /**
     * 
     * @param StoreEstablishment $request
     * @param Establishment $establishment
     */
    public function feedCallNumbers($request, $establishment) {
        $callNumbers = array();
        $prefixByIdCountry = array();
        $numberTypesToDelete = array();
        // Get all country ids matching each selected number prefix
        $prefixCountryIds = array();
        foreach ($request->get('id_country_prefix') as $typeNumber => $idPrefix) {
            if (!empty($request->get('call_number.'.$typeNumber)) && checkModelId($idPrefix)) {
                $prefixCountryIds[$idPrefix] = $idPrefix;
            } else {
                $numberTypesToDelete[] = $typeNumber;
            }
        }
        // Delete existing number removed by the user
        if(!empty($numberTypesToDelete)){
            $establishment->callNumbers()->whereIn('type', $numberTypesToDelete)->delete();
        }
        if(!empty($prefixCountryIds)){
            // Get all countries data matching each selected number prefix
            $prefixCountries = DB::table(Country::TABLENAME)->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id', $prefixCountryIds))
                            ->selectRaw(DbQueryTools::genRawSqlForGettingUuid().', prefix, id')->get();
            foreach ($prefixCountries as $countryData) {
                $prefixByIdCountry[$countryData->uuid] = $countryData->prefix;
            }

            foreach ($request->get('call_number') as $typeNumber => $number) {
                $numberLabel = null;
                $prefix = null;
                $isMain = false;
                switch ($typeNumber) {
                    case CallNumber::TYPE_PHONE_NUMBER_RESERVATION:
                        $numberLabel = 'Téléphone utilisé pour les réservations';
                        break;
                    case CallNumber::TYPE_PHONE_CONTACT:
                        $numberLabel = 'Téléphone principal';
                        $isMain = true;
                        break;
                    case CallNumber::TYPE_FAX:
                        $numberLabel = 'Numéro de fax';
                        break;
                    case CallNumber::TYPE_MOBILE:
                        $numberLabel = 'Téléphone mobile';
                        break;
                }
                $prefixCountryUuid = $request->get('id_country_prefix.'.$typeNumber);
                if (isset($prefixByIdCountry[$prefixCountryUuid])) {
                    $prefix = $prefixByIdCountry[$prefixCountryUuid];
                }

                if(!empty($typeNumber) && !empty($prefix) && !empty($number)){
                    $callNumber = $establishment->callNumbers()->where('type', '=', $typeNumber)->first();
                    $attributes = [
                        'main' => $isMain,
                        'label' => $numberLabel,
                        'type' => $typeNumber,
                        'prefix' => $prefix,
                        'id_country' => UuidTools::getId($prefixCountryUuid),
                        'number' => $number,
                        'id_establishment' => $establishment->getId(),
                    ];

                    try{
                        if (!checkModel($callNumber)) {
                            $attributes['id'] = UuidTools::generateUuid();
                            $callNumber = CallNumber::create($attributes);
                        } else {
                            $callNumber->update($attributes);
                        }
                        $callNumbers[] = $callNumber;
                    } catch(Exception $e){
                        print_r($e->getMessage());
                        die();
                    }
                }
            }
        }
        return $callNumbers;
    }

    /**
     * 
     * @param Establishment $establishment
     * @param type $main
     * @param type $label
     * @param type $type
     * @param type $uuidCountry
     * @param type $number
     * @return type
     */
    public function feedCallNumber($establishment, $main, $label, $type, $uuidCountry, $prefix, $number) {
        
        return $callNumber;
    }

    /**
     * 
     * @param type $name
     * @param type $lat
     * @param type $lng
     * @return boolean
     */
    public function isUniqueEstablishment($name, $lat, $lng) {
        $bool = false;
        if (isset($name) & isset($lat) & isset($lng)) {
            $name = DB::table('Establishment')
                            ->where('name', $name)->first();
            $lat = DB::table('Establishment')
                            ->where('latitude', $lat)->first();
            $lng = DB::table('Establishment')
                            ->where('longitude', $lng)->first();
        } else {
            $bool = false;
        }

        if (isset($name->name) & isset($lat->latitude) & isset($lng->longitude)) {
            $bool = false;
        } else {

            $bool = true;
        }

        return $bool;
    }

}
