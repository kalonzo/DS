<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Requests\StoreEstablishment;
use App\Models\Address;
use App\Models\BusinessCategory;
use App\Models\CallNumber;
use App\Models\Country;
use App\Models\Establishment;
use App\Models\EstablishmentBusinessCategory;
use App\Models\LocationIndex;
use App\Models\Model;
use App\Models\OpeningHour;
use App\Models\Restaurant;
use App\Models\User;
use App\php;
use App\Utilities\DateTools;
use App\Utilities\DbQueryTools;
use App\Utilities\StorageHelper;
use App\Utilities\UuidTools;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use View;

class EstablishmentController extends Controller {

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
        $this->buildCreateFormData();
        $formData = StorageHelper::getInstance()->get('create_establishment.form_data');
        $view = View::make('establishment.create')->with('form_data', $formData);

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
     * Show the form for editing the specified resource.
     *
     * @param  \App\php  $php
     * @return Response
     */
    public function edit(Establishment $establishment) {
        $this->buildCreateFormData();
        $formData = StorageHelper::getInstance()->get('create_establishment.form_data');
        $view = View::make('establishment.create')->with('form_data', $formData)->with('establishment', $establishment);
        
        return $view;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  \App\php  $php
     * @return Response
     */
    public function update(Request $request, php $php) {
        //
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreEstablishment  $request
     * @return Response
     */
    public function store(StoreEstablishment $request) {
        $establishment = $this->insertEstablishment($request);
        return redirect('/admin');
    }

    public function buildCreateFormData() {
        // Select for business categories
        $cookingTypes = array();
        $foodSpecialities = array();
        $restaurantAtmospheres = array();
        $services = array();
        $businessCategoriesData = DB::table(BusinessCategory::TABLENAME)
                                        ->selectRaw(DbQueryTools::genRawSqlForGettingUuid().', name, type')
                                        ->whereIn('type', array(BusinessCategory::TYPE_COOKING_TYPE,
                                                                BusinessCategory::TYPE_FOOD_SPECIALITY,
                                                                BusinessCategory::TYPE_RESTAURANT_ATMOSPHERE,
                                                                BusinessCategory::TYPE_SERVICES
                                                                )
                                        )
                                        ->orderBy('name')
                                        ->get();
        foreach($businessCategoriesData as $businessCategoryData){
            switch($businessCategoryData->type){
                case BusinessCategory::TYPE_COOKING_TYPE:
                    $cookingTypes[$businessCategoryData->uuid] = $businessCategoryData->name;
                    break;
                case BusinessCategory::TYPE_FOOD_SPECIALITY:
                    $foodSpecialities[$businessCategoryData->uuid] = $businessCategoryData->name;
                    break;
                case BusinessCategory::TYPE_RESTAURANT_ATMOSPHERE:
                    $restaurantAtmospheres[$businessCategoryData->uuid] = $businessCategoryData->name;
                    break;
                case BusinessCategory::TYPE_SERVICES:
                    $services[$businessCategoryData->uuid] = $businessCategoryData->name;
                    break;
            }
        }

        // Select for call number prefixes
        $countryPrefixes = array();
        $countriesData = DB::table(Country::TABLENAME)
                                        ->selectRaw(DbQueryTools::genRawSqlForGettingUuid().', label, prefix')
                                        ->where('prefix', '>', 0)
                                        ->orderBy('label')
                                        ->get();
        foreach ($countriesData as $countryData) {
            $countryPrefixes[$countryData->uuid] = $countryData->label." | +".$countryData->prefix;
        }

        // Select for time
        $timetable = array();
        for ($i = 0; $i < 24; $i++) {
            for ($j = 0; $j <= 55; $j+=30) {
                $timetable[$i*100 + $j] = sprintf('%02d', $i).':'.sprintf('%02d', $j);
            }
        }
        
        // Helper array for days
        $days = DateTools::getDaysArray();
        
        StorageHelper::getInstance()->add('create_establishment.form_data.cooking_types', $cookingTypes);
        StorageHelper::getInstance()->add('create_establishment.form_data.food_specialities', $foodSpecialities);
        StorageHelper::getInstance()->add('create_establishment.form_data.ambiences', $restaurantAtmospheres);
        StorageHelper::getInstance()->add('create_establishment.form_data.services', $services);
        StorageHelper::getInstance()->add('create_establishment.form_data.country_prefixes', $countryPrefixes);
        StorageHelper::getInstance()->add('create_establishment.form_data.timetable', $timetable);
        StorageHelper::getInstance()->add('create_establishment.form_data.days', $days);
    }

    /**
     * 
     * @param StoreEstablishment $request
     */
    public function insertEstablishment($request) {
        $createdObjects = array();
        try{
            
            $idLocation = 0;
            $postalCode = $request->get('postal_code');
            $city = $request->get('city');
            if(!empty($postalCode) && !empty($city)){
                $locationIndex = LocationIndex::where('postal_code', $postalCode)
                                                ->where('city', $city)->first(); 
                if(checkModel($locationIndex)){
                    $idLocation = $locationIndex->getId();
                }
            }
            if(checkModelId($idLocation)){
                //Create establishment address
                $request->merge([
                    'id_location_index' => $idLocation
                ]);
                $address = Address::create($request->all());
                if(checkModel($address)){
                    $createdObjects[] = $address;
                    $idAddress = $address->getId();

                    // Create establishment user owner
                    $request->merge([
                        'name' => $request->get('establishment.name'),
                        'type' => User::TYPE_USER_AUTO_INSERTED,
                        'gender' => 0,
                        'id_address' => $idAddress,
                        'id_inbox' => 0,
                        'id_company' => 0,
                    ]);
                    $user = User::create($request->all());
                   
                    if(checkModel($user)){
                        $createdObjects[] = $user;
                        $idUser = $user->getId();

                        // Create establishment
                        $request->merge([
                            'id_location_index' => $idLocation,
                            'id_user_owner' => $idUser,
                            'id_address' => $idAddress,
                            'id_business_type' => \App\Models\BusinessType::TYPE_BUSINESS_RESTAURANT,
                            'id_logo' => 0
                        ]);
                        $establishment = Establishment::create($request->all());
                        if(checkModel($establishment)){
                            $createdObjects[] = $establishment;

                            // Create phone numbers
                            if ($request->get('numberReservation') != "") {
                                $createdObjects[] = $this->createCallNumber(0, $request, 'Téléphone utilisé pour les réservation', CallNumber::TYPE_PHONE_NUMBER_RESERVATION, 
                                        $request->get('callNumberPrefixIdsByNameReservation'), $request->get('numberReservation'), $establishment->getId());
                            }
                            if ($request->get('contactNumber') != "") {
                                $createdObjects[] = $this->createCallNumber(1, $request, 'Téléphone principal', CallNumber::TYPE_PHONE_CONTACT, $request->get('callNumberPrefixIdsByNameContact'), 
                                        $request->get('contactNumber'), $establishment->getId());
                            }
                            if ($request->get('fax') != "") {
                                $createdObjects[] = $this->createCallNumber(0, $request, 'Numéro de fax', CallNumber::TYPE_FAX, $request->get('callNumberPrefixIdsByNameFax'), $request->get('fax'), 
                                        $establishment->getId());
                            }
                            if ($request->get('mobile') != "") {
                                $createdObjects[] = $this->createCallNumber(0, $request, 'Téléphone mobile', CallNumber::TYPE_MOBILE, $request->get('callNumberPrefixIdsByNameMobile'), 
                                        $request->get('mobile'), $establishment->getId());
                            }

                            // Create cooking types
                            $cookingTypes = request()->get('cooking_types');
                            if(!empty($cookingTypes)){
                                foreach ($cookingTypes as $cookingType) {
                                    $idCookingType = UuidTools::getId($cookingType);
                                    $createdObjects[] = $this->createLinkBusinessCategory($request, $establishment->getId(), $idCookingType);
                                }
                            }
                            // Create food specialties
                            $foodSpecialties = request()->get('food_specialties');
                            if(!empty($foodSpecialties)){
                                foreach ($foodSpecialties as $foodSpecialty) {
                                    // TODO Manage existing and new ones
                                    $idSpecialty = UuidTools::getId($foodSpecialty);
                                    $createdObjects[] = $this->createLinkBusinessCategory($request, $establishment->getId(), $idSpecialty);
                                }
                            }
                            // Create ambiences
                            $ambiences = request()->get('ambiences');
                            if(!empty($ambiences)){
                                foreach ($ambiences as $ambience) {
                                    $idAmbience = UuidTools::getId($ambience);
                                    $createdObjects[] = $this->createLinkBusinessCategory($request, $establishment->getId(), $idAmbience);
                                }
                            }
                            // Create services
                            $services = request()->get('services');
                            if(!empty($services)){
                                foreach ($services as $service) {
                                    $idService = UuidTools::getId($service);
                                    $createdObjects[] = $this->createLinkBusinessCategory($request, $establishment->getId(), $idService);
                                }
                            }

                            // Create opening hours
                            foreach(DateTools::getDaysArray() as $dayIndex => $dayLabel){
                                $createdObjects[] = $this->createOpeningHour($request, $dayIndex, $request->get('startTimeAm'.$dayIndex), 
                                        $request->get('endTimeAm'.$dayIndex), $establishment->getId());
                                $createdObjects[] = $this->createOpeningHour($request, $dayIndex, $request->get('startTimePm'.$dayIndex), 
                                        $request->get('endTimePm'.$dayIndex), $establishment->getId());
                            }
                            return $establishment;
                        } else {
                            throw new Exception("L'établissement n'a pu être enregistré.");
                        }
                    } else {
                        throw new Exception("Le propriétaire de l'établissement n'a pu être enregistré.");
                    }
                } else {
                    throw new Exception("L'adresse de l'établissement n'a pu être enregistrée.");
                }
            } else {
                throw new Exception("L'adresse saisie ne correspond à aucun index géographique connu.");
            }
        } catch(Exception $e){
            // TODO Report error in log system
            print_r($e->getMessage());
            
            foreach($createdObjects as $createdObject){
                if($createdObject instanceof Model){
                    $createdObject->delete();
                }
            }
        }
    }

    /**
     * 
     * @param StoreEstablishment $request
     * @param type $establishmentId
     * @param type $id
     */
    public function createLinkBusinessCategory($request, $establishmentId, $id) {

        $request->merge([
            'id_establishment' => $establishmentId,
            'id_business_categories' =>  $id
        ]);
        return EstablishmentBusinessCategory::create($request->all());
    }

    /**
     * 
     * @param StoreEstablishment $request
     * @param type $day
     * @param type $startTime
     * @param type $endTime
     * @param type $idEstablishment
     */
    public function createOpeningHour($request, $day, $startTime, $endTime, $idEstablishment) {
        $request->merge([
            'day' => $day,
            'start_time' => date('H:i', strtotime($startTime)),
            'end_time' => date('H:i', strtotime($endTime)),
            'id_establishment' => $idEstablishment
        ]);
        return OpeningHour::create($request->all());
    }

    /**
     * 
     * @param type $main
     * @param StoreEstablishment $request
     * @param type $label
     * @param type $type
     * @param type $idCountry
     * @param type $number
     * @param type $idEstablishment
     */
    public function createCallNumber($main, $request, $label, $type, $idCountry, $number, $idEstablishment) {
        $prefix = Country::where('id', UuidTools::getId($idCountry))->first();

        $request->merge([
            'main' => $main,
            'label' => $label,
            'type' => $type,
            'prefix' => $prefix->getPrefix(),
            'number' => $number,
            'id_establishment' => $idEstablishment,
        ]);

        return CallNumber::create($request->all());
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
