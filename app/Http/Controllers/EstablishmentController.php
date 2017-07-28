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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $view = $this->filterValues();
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validatePhase($request, $request->get('validationPhase'));
        //$msg = 'Veuillez passez à l\'étape de saisie des contact';
        //return back()->with('message', $msg);
        $view = $this->filterValues();
        return $view;
    }

    /**
     * 
     * @param \Illuminate\Support\Facades\Request $request
     * @param type $validationPhase
     * @return string
     */
    public function validatePhase(Request $request, $validationPhase) {
        //condition de formulaire remplie au dela de l'étape 5
        if (intval($validationPhase) >= 5) {
            $validationPhase = 'complete';
        }
        switch ($validationPhase) {
            case '2':
                $this->validateForm($request, '3');

                $validationPhase = '3';
                $request->merge([
                    'validationPhase' => $validationPhase
                ]);
                break;
            case '3':
                $this->validateForm($request, '4');

                $validationPhase = '4';
                $request->merge([
                    'validationPhase' => $validationPhase
                ]);
                break;
            case '4':
                $request->merge([
                    'validationPhase' => $request->get('validationPhase')
                ]);

                $this->validateForm($request, '5');

                $validationPhase = '5';
                $request->merge([
                    'validationPhase' => $validationPhase
                ]);
                break;
            case 'complete':
                $this->insertEstablishment($request);
                break;
            default:
                $this->validateForm($request, '2');
                $validationPhase = '2';
                $request->merge([
                    'validationPhase' => $validationPhase
                ]);
        }
        return $validationPhase;
    }

    /**
     * 
     * @param \Illuminate\Support\Facades\Request $request
     * @param type $phase
     */
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
                    'site_url.regex' => 'Veuillez.',
                    'site_url' => 'requis pour toto'
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
                $this->insertEstablishment();
                break;
        }
    }

    /**
     * Permet de créer des tableaux associatif pour les business catégory (filtersValu )
     * @param \Illuminate\Support\Facades\Request $request
     * @return type
     */
    public function getElementsIdsByName($request) {
        $getElementsIdByName = array();
        foreach ($request as $uUId) {
            $getElementsIdByName[$uUId->getUuid()] = $uUId->getName();
        }
        return $getElementsIdByName;
    }

    public function filterValues() {
        $cookingTypes = \App\Models\BusinessCategory::where('type', \App\Models\BusinessCategory::TYPE_COOKING_TYPE)->get();
        $foodSpecialities = \App\Models\BusinessCategory::where('type', \App\Models\BusinessCategory::TYPE_FOOD_SPECIALITY)->get();
        $restaurantAtmosphere = \App\Models\BusinessCategory::where('type', \App\Models\BusinessCategory::TYPE_RESTAURANT_ATMOSPHERE)->get();
        $services = \App\Models\BusinessCategory::where('type', \App\Models\BusinessCategory::TYPE_SERVICES)->get();
        $callNumberPrefix = \App\Models\Country::get();

        $cookingTypesIdsByName = $this->getElementsIdsByName($cookingTypes);
        $foodSpecialitieIdsByName = $this->getElementsIdsByName($foodSpecialities);
        $restaurantAtmospherIdsByName = $this->getElementsIdsByName($restaurantAtmosphere);
        $servicIdsByName = $this->getElementsIdsByName($services);
        $callNumberPrefixIdsByName = array();

        foreach ($callNumberPrefix as $call) {
            $callNumberPrefixIdsByName[$call->getUuid()] = $call->label . " " . "(" . $call->prefix . ")";
        }

        foreach ($callNumberPrefix as $call) {
            $callNumberPrefixIdsByName[$call->getUuid()] = $call->label . " " . "(" . $call->prefix . ")";
        }

        $houreField = array();

        for ($i = 1; $i <= 24; $i++) {
            $houreField[sprintf('%02d', $i) . ':00'] = sprintf('%02d', $i) . ':00';
            $houreField[sprintf('%02d', $i) . ':30'] = sprintf('%02d', $i) . ':30';
        }

        $view = View::make('establishment.create')->with('cookingTypesIdsByName', $cookingTypesIdsByName)
                ->with('foodSpecialitieIdsByName', $foodSpecialitieIdsByName)
                ->with('restaurantAtmospherIdsByName', $restaurantAtmospherIdsByName)
                ->with('servicIdsByName', $servicIdsByName)
                ->with('callNumberPrefixIdsByName', $callNumberPrefixIdsByName)
                ->with('houreField', $houreField);

        return $view;
    }

    /**
     * 
     * @param \Illuminate\Support\Facades\Request $request
     */
    public function insertEstablishment($request) {
        //Validation général du formulaire
        for($i=1;$i < 5 ; $i++){  
            $this->validatePhase($request, $i);
        }
        
        $idLocation = $this->getIdLocation($request->get('postal_code'), $request->get('city'));
        $request->merge([
            'id_location_index' => $idLocation
        ]);
        $address = \App\Models\Address::create($request->all());
        $uUIdAddress = $address->getId();

        $request->merge([
            'type' => \App\Models\User::TYPE_USER_AUTO_INSERTED,
            'gender' => 0,
            'id_address' => $uUIdAddress,
            'id_inbox' => 0,
            'id_company' => 0,
        ]);

        $user = \App\Models\User::create($request->all());
        $uuid_user = $user->getId();

        $request->merge([
            'id_location_index' => $idLocation,
            'id_user_owner' => $uuid_user,
            'id_address' => $uUIdAddress,
            'id_business_type' => \App\Models\Restaurant::TYPE_BUSINESS_RESTAURANT,
            'id_logo' => 0
        ]);

        $establishment = \App\Models\Establishment::create($request->all());

        if ($request->get('numberReservation') != "") {
            $this->insertPhoneNumber(0, $request, 'Téléphone utilisé pour les réservation', \App\Models\CallNumber::TYPE_PHONE_NUMBER_RESERVATION, $request->get('callNumberPrefixIdsByNameReservation'), $request->get('numberReservation'), $establishment->getId());
        }
        if ($request->get('contactNumber') != "") {
            $this->insertPhoneNumber(1, $request, 'Téléphone principale', \App\Models\CallNumber::TYPE_PHONE_CONTACT, $request->get('callNumberPrefixIdsByNameContact'), $request->get('contactNumber'), $establishment->getId());
        }
        if ($request->get('fax') != "") {
            $this->insertPhoneNumber(0, $request, 'Numéro de fax', \App\Models\CallNumber::TYPE_FAX, $request->get('callNumberPrefixIdsByNameFax'), $request->get('fax'), $establishment->getId());
        }
        if ($request->get('mobile') != "") {
            $this->insertPhoneNumber(0, $request, 'Téléphone mobile', \App\Models\CallNumber::TYPE_MOBILE, $request->get('callNumberPrefixIdsByNameMobile'), $request->get('mobile'), $establishment->getId());
        }

        //Insertion des types de cuisine
        foreach (request()->get('cookingTypeSelection') as $cookingType) {
            $id = \App\Utilities\UuidTools::getId($cookingType);
            $this->insertBusinessCategory($request, $establishment->getId(), $id);
        }
        //Insertion des spécialité
        foreach (request()->get('foodSpecialitieIdsByName') as $foodSpeciality) {
            $id = \App\Utilities\UuidTools::getId($foodSpeciality);
            $this->insertBusinessCategory($request, $establishment->getId(), $id);
        }
        //Insertion des spécialité
        foreach (request()->get('restaurantAtmospherIdsByName') as $restaurantAtmospherIdsByName) {
            $id = \App\Utilities\UuidTools::getId($restaurantAtmospherIdsByName);
            $this->insertBusinessCategory($request, $establishment->getId(), $id);
        }
        //Insertion des spécialité
        foreach (request()->get('servicIdsByName') as $servicIdsByName) {
            $id = \App\Utilities\UuidTools::getId($servicIdsByName);
            $this->insertBusinessCategory($request, $establishment->getId(), $id);
        }

        $this->insertOpeningHours($request, 1, $request->get('startTimeAm1'), $request->get('endTimeAm1'), $establishment->getId());
        $this->insertOpeningHours($request, 1, $request->get('startTimePm1'), $request->get('endTimePm1'), $establishment->getId());

        $this->insertOpeningHours($request, 2, $request->get('startTimeAm2'), $request->get('endTimeAm2'), $establishment->getId());
        $this->insertOpeningHours($request, 2, $request->get('startTimePm2'), $request->get('endTimePm2'), $establishment->getId());

        $this->insertOpeningHours($request, 3, $request->get('startTimeAm3'), $request->get('endTimeAm3'), $establishment->getId());
        $this->insertOpeningHours($request, 3, $request->get('startTimePm3'), $request->get('endTimePm3'), $establishment->getId());

        $this->insertOpeningHours($request, 4, $request->get('startTimeAm4'), $request->get('endTimeAm4'), $establishment->getId());
        $this->insertOpeningHours($request, 4, $request->get('startTimePm4'), $request->get('endTimePm4'), $establishment->getId());

        $this->insertOpeningHours($request, 5, $request->get('startTimeAm5'), $request->get('endTimeAm5'), $establishment->getId());
        $this->insertOpeningHours($request, 5, $request->get('startTimePm5'), $request->get('endTimePm5'), $establishment->getId());

        $this->insertOpeningHours($request, 6, $request->get('startTimeAm6'), $request->get('endTimeAm6'), $establishment->getId());
        $this->insertOpeningHours($request, 6, $request->get('startTimePm6'), $request->get('endTimePm6'), $establishment->getId());

        $this->insertOpeningHours($request, 7, $request->get('startTimeAm7'), $request->get('endTimeAm7'), $establishment->getId());
        $this->insertOpeningHours($request, 7, $request->get('startTimePm7'), $request->get('endTimePm7'), $establishment->getId());

        die('Enregistrement du restaurant dans la base de données');
    }

    /**
     * 
     * @param \Illuminate\Support\Facades\Request $request
     * @param type $establishmentId
     * @param type $id
     */
    public function insertBusinessCategory($request, $establishmentId, $id) {
        $request->merge([
            'id_establishment' => $establishmentId,
            'id_business_categories' => $id
        ]);
        //var_dump($request->all());
         \App\Models\EstablishmentBusinessCategory::create($request->all());
    }

    /**
     * 
     * @param \Illuminate\Support\Facades\Request $request
     * @param type $day
     * @param type $startTime
     * @param type $endTime
     * @param type $idEstablishment
     */
    public function insertOpeningHours($request, $day, $startTime, $endTime, $idEstablishment) {
        $request->merge([
            'day' => $day,
            'start_time' => date('H:i', strtotime($startTime)),
            'end_time' => date('H:i', strtotime($endTime)),
            'idEstablishment' => $idEstablishment
        ]);
        \App\Models\OpeningHour::create($request->all());
    }

    /**
     * 
     * @param type $main
     * @param \Illuminate\Support\Facades\Request $request
     * @param type $label
     * @param type $type
     * @param type $idCountry
     * @param type $number
     * @param type $idEstablishment
     */
    public function insertPhoneNumber($main, $request, $label, $type, $idCountry, $number, $idEstablishment) {
        $prefix = \App\Models\Country::where('id', \App\Utilities\UuidTools::getId($idCountry))->first();

        $request->merge([
            'main' => $main,
            'label' => $label,
            'type' => $type,
            'prefix' => $prefix->getPrefix(),
            'number' => $number,
            'id_establishment' => $idEstablishment,
        ]);

        \App\Models\CallNumber::create($request->all());
    }

    /**
     * 
     * @param type $postalCode
     * @param type $city
     * @return type
     */
    public function getIdLocation($postalCode, $city) {
        $locationIndex = \App\Models\LocationIndex::where('postal_code', $postalCode)
                ->where('city', $city)->first();   
        $id = $locationIndex->id;
        return $id;
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
            $name = \Illuminate\Support\Facades\DB::table('Establishment')
                    ->where('name', $name)->first();
            $lat = \Illuminate\Support\Facades\DB::table('Establishment')
                    ->where('latitude', $lat)->first();
            $lng = \Illuminate\Support\Facades\DB::table('Establishment')
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
