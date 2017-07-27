<?php

namespace App\Http\Controllers;

use App\php;
use Illuminate\Http\Request;
use View;

class EstablishmentController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    public function getElementsIdsByName($request) {
        $getElementsIdByName = array();
        foreach ($request as $key) {
            $getElementsIdByName[$key->getUuid()] = $key->getName();
        }

        return $getElementsIdByName;
    }

    function filtersValue() {
        $cookingTypes = \App\Models\BusinessCategory::where('type', \App\Models\BusinessCategory::TYPE_COOKING_TYPE)->get();
        $foodSpecialities = \App\Models\BusinessCategory::where('type', \App\Models\BusinessCategory::TYPE_FOOD_SPECIALITY)->get();
        $restaurantAtmosphere = \App\Models\BusinessCategory::where('type', \App\Models\BusinessCategory::TYPE_RESTAURANT_ATMOSPHERE)->get();
        $service = \App\Models\BusinessCategory::where('type', \App\Models\BusinessCategory::TYPE_SERVICES)->get();
        $callNumberPrefix = \App\Models\Country::get();

        $cookingTypesIdsByName = EstablishmentController::getElementsIdsByName($cookingTypes);
        $foodSpecialitieIdsByName = EstablishmentController::getElementsIdsByName($foodSpecialities);
        $restaurantAtmospherIdsByName = EstablishmentController::getElementsIdsByName($restaurantAtmosphere);
        $servicIdsByName = EstablishmentController::getElementsIdsByName($service);
        $callNumberPrefixIdsByName = array();

        foreach ($callNumberPrefix as $call) {
            $callNumberPrefixIdsByName[$call->getUuid()] = $call->label . " " . "(" . $call->prefix . ")";
        }

        $view = View::make('establishment.create')->with('cookingTypesIdsByName', $cookingTypesIdsByName)
                ->with('foodSpecialitieIdsByName', $foodSpecialitieIdsByName)
                ->with('restaurantAtmospherIdsByName', $restaurantAtmospherIdsByName)
                ->with('servicIdsByName', $servicIdsByName)
                ->with('callNumberPrefixIdsByName', $callNumberPrefixIdsByName);

        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $view = EstablishmentController::filtersValue();
        return $view;
    }

    public function insertEstablishment($request) {

        $id_location = EstablishmentController::retrieveIdLocation($request->get('postal_code'));

        $request->merge([
            'id_location_index' => $id_location
        ]);

        $address = \App\Models\Address::create($request->all());

        $uuid_address = $address->getId();

        $request->merge([
            'type' => \App\Models\User::TYPE_USER_ADMIN_PRO,
            'gender' => \App\Models\User::TYPE_GENDER_SOCITY,
            'id_address' => $uuid_address,
            'id_inbox' => 0,
            'id_company' => 0,
        ]);

        $user = \App\Models\User::create($request->all());

        $uuid_user = $user->getId();

        $request->merge([
            'id_location_index' => $id_location,
            'id_user_owner' => $uuid_user,
            'id_address' => $uuid_address,
            'id_business_type' => \App\Models\Restaurant::TYPE_BUSINESS_RESTAURANT,
            'id_logo' => 0
        ]);

        $establishment = \App\Models\Establishment::create($request->all());

        if ($request->get('numberReservation') != "") {
            EstablishmentController::createPhoneNumber(0, $request, 'Téléphone utilisé pour les réservation', \App\Models\CallNumber::TYPE_PHONE_NUMBER_RESERVATION, $request->get('callNumberPrefixIdsByNameReservation'), $request->get('number'), $establishment->getId());
        }
        if ($request->get('contactNumber') != "") {
            EstablishmentController::createPhoneNumber(1, $request, 'Téléphone principale', \App\Models\CallNumber::TYPE_PHONE_CONTACT, $request->get('callNumberPrefixIdsByNameMobile'), $request->get('callNumberPrefixIdsByNameContact'), $establishment->getId());
        }
        if ($request->get('fax') != "") {
            EstablishmentController::createPhoneNumber(0, $request, 'Numéro de contacte', \App\Models\CallNumber::TYPE_FAX, $request->get('callNumberPrefixIdsByNameContact'), $request->get('callNumberPrefixIdsByNameFax'), $establishment->getId());
        }
        if ($request->get('mobile') != "") {
            EstablishmentController::createPhoneNumber(0, $request, 'Téléphone mobile', \App\Models\CallNumber::TYPE_MOBILE, $request->get('callNumberPrefixIdsByNameContact'), $request->get('callNumberPrefixIdsByNameMobile'), $establishment->getId());
        }

        $cookingTypes = \App\Models\BusinessCategory::whereRaw(\App\Utilities\DbQueryTools::genRawSqlForWhereInUuidList
                (\App\Models\BusinessCategory::TABLENAME, 'id', $request->get('cookingTypeSelection')))->get();

        
        foreach ($cookingTypes as $cookingType) {
            $request->merge([
                'id_establishment' => $establishment->getId(),
                'id_business_categorie' => $cookingType->getid()
            ]);
            \App\Models\EstablishmentBusinessCategory::create();
        }

        //$arr = $cookingTypes->collapse();
        //var_dump($cookingTypes->get('id'));
        die('Enregistrement du restaurant dans la base de données');
    }

    public function validateForm($request, $phase) {
        switch ($phase) {
            case '2':
                $this->validate($request, [
                    'name' => 'required|min:2|max:255',
                    'street' => 'required|min:3|max:255',
                    'street_number' => 'required|max:45',
                    'postal_code' => 'required|max:11',
                    'city' => 'required|max:255',
                    'country' => 'required|max:255',
                    'latitude' => 'required',
                    'longitude' => 'required',
                        ], [
                    'name.required' => ' Vous devez spécifier un nom pour votre établissement.',
                    'name.min' => ' Le nom de votre restaurant dois contenir au minimum 2 caractères.',
                    'name.max' => ' Le nom du restaurant ne dois pas dépasser 255 caractères',
                    'street.required' => 'Vous devez spécifiez une rue pour votre établissement',
                    'street.min' => 'Le nom de rue dois contenir au minimum 3 caractères',
                    'street_number.required' => ' Vous devez spécifiez un numéro de rue pour votre établissement.',
                    'postal_code.required' => 'Vous devez spécifier un code postal',
                    'city.required' => ' Vous devez spécifiez une ville pour votre établissement.',
                    'country.required' => ' Vous devez spécifiez le pays de votre établissement.',
                    'latitude.required' => 'Veuillez cliquer sur le bouton localisation de mon restaurant.',
                    'longitude.required' => 'Veuillez cliquer sur le bouton localisation de mon restaurant.',
                ]);
                break;
            case '3':
                $this->validate($request, [
                    'numberReservation' => 'required|min:11|numeric',
                    'contactNumber' => 'required|min:11|numeric',
                        ], [
                    'numberReservation.required' => 'Veuillez indiquer un numéro de résérvation.',
                    'numberReservation.min' => 'Le numéro ne doit pas contenir plus de 11 numéro.',
                    'numberReservation.numeric' => 'Le numéro de résérvation de dois pas contenir de caractères',
                    'contactNumber.required' => 'Veuillez indiquer un numéro pour vous joindre.',
                    'contactNumber.min' => 'Le numéro ne doit pas contenir plus de 11 numéro.',
                    'contactNumber.numeric' => 'Le numéro de résérvation de dois pas contenir de caractères',
                ]);
                break;
            case '4':
                $this->validate($request, [
                    'site_url' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
                        ], [
                    'site_url.regex' => 'Veuillez .',
                ]);

                break;
            case '5':
                /** $this->validate($request, [
                  'countCookingType' => 'required|max:3',
                  ], [
                  'countCookingType.max' => 'Veuillez .',
                  ]);* */
                break;
            case 'complete':
                EstablishmentController::insertEstablishment();
                break;
        }
    }

    public function validatePhase(Request $request, $validationPhase) {
        if (intval($validationPhase) >= 5) {
            $validationPhase = 'complete';
        }

        switch ($validationPhase) {
            case '2':
                EstablishmentController::validateForm($request, '3');
                $validationPhase = '3';
                $request->merge([
                    'validationPhase' => $validationPhase
                ]);
                break;
            case '3':
                EstablishmentController::validateForm($request, '4');
                $validationPhase = '4';
                $request->merge([
                    'validationPhase' => $validationPhase
                ]);
                break;
            case '4':
                $request->merge([
                    'validationPhase' => $request->get('validationPhase')
                ]);

                EstablishmentController::validateForm($request, '5');
                $validationPhase = '5';
                $request->merge([
                    'validationPhase' => $validationPhase
                ]);
                break;
            case 'complete':
                EstablishmentController::insertEstablishment($request);
                break;
            default:
                EstablishmentController::validateForm($request, '2');
                $validationPhase = '2';
                $request->merge([
                    'validationPhase' => $validationPhase
                ]);
        }
        return $validationPhase;
    }

    public function retrieveIdLocation($postalCode) {
        $idLocation = \Illuminate\Support\Facades\DB::table('location_index')
                        ->where('postal_code', $postalCode)->first();
        $id = $idLocation->id;
        return $id;
    }

    public function getUniqueEstablishment($name, $lat, $lng) {
        $bool = false;
        if (isset($name) & isset($lat) & isset($lng)) {
            $name = \Illuminate\Support\Facades\DB::table('Establishment')
                    ->where('name', $name);
            $lat_id = \Illuminate\Support\Facades\DB::table('Establishment')
                    ->where('latitude', $lat);
            $lng_id = \Illuminate\Support\Facades\DB::table('Establishment')
                    ->where('longitude', $lng);
        } else {
            $bool = false;
        }

        if (isset($name->name) & isset($lat_id->latitude) & isset($lng_id->longitude)) {
            $bool = false;
        } else {

            $bool = true;
        }

        return $bool;
    }

    public function createPhoneNumber($main, $request, $label, $type, $id, $number, $idEstablishment) {

        $prefix = \App\Models\Country::where('id', $id)->get();
        
   

        var_dump($prefix);
        die('<br>' . $id);
        $request->merge([
            'main' => $main,
            'label' => $label,
            'type' => $type,
            'prefix' => $prefix,
            'number' => $number,
            'id_establishment' => $idEstablishment,
        ]);

        \App\Models\CallNumber::create($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $validationPhase = $request->get('validationPhase');

        $validationPhase = EstablishmentController::validatePhase($request, $validationPhase);

        $msg = 'Veuillez passez à l\'étape de saisie des contact';

        //return back()->with('message', $msg);
        $view = EstablishmentController::filtersValue();
        return $view;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\php  $php
     * @return \Illuminate\Http\Response
     */
    public function show(php $php) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\php  $php
     * @return \Illuminate\Http\Response
     */
    public function edit(php $php) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\php  $php
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, php $php) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\php  $php
     * @return \Illuminate\Http\Response
     */
    public function destroy(php $php) {
        //
    }

}
