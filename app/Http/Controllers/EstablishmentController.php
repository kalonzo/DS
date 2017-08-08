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
        $this->buildFeedFormData();
        $formData = StorageHelper::getInstance()->get('create_establishment.form_data');
        $view = View::make('establishment.create')->with('form_data', $formData)->with('establishment', null);

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
     * @param  Establishment $establishment
     * @return Response
     */
    public function edit(Establishment $establishment) {
        $this->buildFeedFormData();
        $this->buildFormValues($establishment);
        $formData = StorageHelper::getInstance()->get('create_establishment.form_data');
        $view = View::make('establishment.create')->with('form_data', $formData)->with('establishment', $establishment);
        return $view;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  Establishment  $establishment
     * @return Response
     */
    public function update(StoreEstablishment $request, Establishment $establishment) {
        $establishment = $this->updateEstablishment($request, $establishment);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreEstablishment  $request
     * @return Response
     */
    public function store(StoreEstablishment $request) {
        $establishment = $this->storeEstablishment($request);
        return redirect('/admin');
    }

    public function buildFeedFormData() {
        // Select for business categories
        $cookingTypes = array();
        $foodSpecialities = array();
        $restaurantAtmospheres = array();
        $services = array();
        $businessCategoriesData = DB::table(BusinessCategory::TABLENAME)
                ->selectRaw(DbQueryTools::genRawSqlForGettingUuid() . ', name, type')
                ->whereIn('type', array(BusinessCategory::TYPE_COOKING_TYPE,
                    BusinessCategory::TYPE_FOOD_SPECIALITY,
                    BusinessCategory::TYPE_RESTAURANT_ATMOSPHERE,
                    BusinessCategory::TYPE_SERVICES
                        )
                )
                ->orderBy('name')
                ->get();
        foreach ($businessCategoriesData as $businessCategoryData) {
            switch ($businessCategoryData->type) {
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
                ->selectRaw(DbQueryTools::genRawSqlForGettingUuid() . ', label, prefix')
                ->where('prefix', '>', 0)
                ->orderBy('label')
                ->get();
        foreach ($countriesData as $countryData) {
            $countryPrefixes[$countryData->uuid] = $countryData->label . " | +" . $countryData->prefix;
        }

        // Select for time
        $timetable = array();
        for ($i = 0; $i < 24; $i++) {
            for ($j = 0; $j <= 55; $j += 30) {
                $timetable[$i * 100 + $j] = sprintf('%02d', $i) . ':' . sprintf('%02d', $j);
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
     * @param Establishment $establishment
     */
    public function buildFormValues(Establishment $establishment) {

        // Select for business categories
        $linkEstablishmentBusiness = EstablishmentBusinessCategory::where('id_establishment', '=', $establishment->getId())->get();


        $cookingTypes = array();
        $foodSpecialities = array();
        $restaurantAtmospheres = array();
        $services = array();
        $businessCategoriesData = DB::table(BusinessCategory::TABLENAME)
                ->selectRaw(DbQueryTools::genRawSqlForGettingUuid() . ', name, type')
                ->whereIn('type', array(BusinessCategory::TYPE_COOKING_TYPE,
                    BusinessCategory::TYPE_FOOD_SPECIALITY,
                    BusinessCategory::TYPE_RESTAURANT_ATMOSPHERE,
                    BusinessCategory::TYPE_SERVICES
                        )
                )
                ->orderBy('name')
                ->get();
        foreach ($businessCategoriesData as $businessCategoryData) {
            switch ($businessCategoryData->type) {
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
                ->selectRaw(DbQueryTools::genRawSqlForGettingUuid() . ', label, prefix')
                ->where('prefix', '>', 0)
                ->orderBy('label')
                ->get();
        foreach ($countriesData as $countryData) {
            $countryPrefixes[$countryData->uuid] = $countryData->label . " | +" . $countryData->prefix;
        }

        // Select for time
        $timetable = array();
        for ($i = 0; $i < 24; $i++) {
            for ($j = 0; $j <= 55; $j += 30) {
                $timetable[$i * 100 + $j] = sprintf('%02d', $i) . ':' . sprintf('%02d', $j);
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
    public function storeEstablishment($request) {
        $createdObjects = array();
        try {
            $idLocation = 0;
            $postalCode = $request->get('address.postal_code');
            $city = $request->get('address.city');
            $countryName = $request->get('address.country');
            $latitude = $request->get('latitude');
            $longitude = $request->get('longitude');

            $country = \App\Models\Country::where('label', $countryName)->first();
            if (!empty($postalCode) && !empty($city) && !empty($countryName)) {
                $locationIndex = \App\Models\LocationIndex::where('city', '=', $city)->where('postal_code', '=', $postalCode)->first();
                if (checkModel($locationIndex)) {
                    $idLocation = $locationIndex->getId();
                } else {
                    if (checkModel($country)) {
                        $locationIndex = \App\Models\LocationIndex::create([
                                    'id' => \App\Utilities\UuidTools::generateUuid(),
                                    'postal_code' => $postalCode,
                                    'city' => $city,
                                    'latitude' => $latitude,
                                    'longitude' => $longitude,
                                    'id_country' => $country->getId()
                        ]);
                        if (checkModel($locationIndex)) {
                            $createdObjects[] = $locationIndex;
                            $idLocation = $locationIndex->getId();
                        }
                    }
                }
            }
            if (checkModelId($idLocation)) {
                $idEstablishment = \App\Utilities\UuidTools::generateUuid();
                //Create establishment address
                $address = Address::create([
                    'id' => \App\Utilities\UuidTools::generateUuid(),
                    'street' => $request->get('address.street'),
                    'street_number' => $request->get('address.street_number'),
                    'address_additional' => $request->get('address.address_additional'),
                    'region' => $request->get('address.region'),
                    'district' => $request->get('address.district'),
                    'postal_code' => $request->get('address.postal_code'),
                    'po_box' => $request->get('address.po_box'),
                    'city' => $request->get('address.city'),
                    'latitude' => $request->get('latitude'),
                    'longitude' => $request->get('longitude'),
                    'country' => $countryName,
                    'id_location_index' => $idLocation,
                    'id_object_related' => $idEstablishment,
                    'type_object_related' => Establishment::TYPE_OBJECT_ESTABLISHMENT,
                ]);
                if (checkModel($address)) {
                    $createdObjects[] = $address;

                    // Create establishment user owner
                    $user = User::create([
                        'id' => \App\Utilities\UuidTools::generateUuid(),
                        'name' => $request->get('name'),
                        'type' => User::TYPE_USER_AUTO_INSERTED,
                        'gender' => 0,
                        'id_address' => $address->getId(),
                        'id_inbox' => 0,
                        'id_company' => 0,
                    ]);

                    if (checkModel($user)) {
                        $createdObjects[] = $user;

                        // Create establishment
                        $establishment = Establishment::create([
                            'id' => $idEstablishment,
                            'name' => $request->get('name'),
                            'latitude' => $request->get('latitude'),
                            'longitude' => $request->get('longitude'),
                            'id_location_index' => $idLocation,
                            'id_user_owner' => $user->getId(),
                            'id_address' => $address->getId(),
                            'id_business_type' => \App\Models\BusinessType::TYPE_BUSINESS_RESTAURANT,
                            'id_logo' => 0,
                        ]);
                        if (checkModel($establishment)) {
                            $createdObjects[] = $establishment;
//      TODO Manage clean create below
                            // Create phone numbers
                            if (!empty($request->get('numberReservation'))) {
                                $createdObjects[] = $this->feedCallNumber(null, 0, $request, 'Téléphone utilisé pour les réservation', 
                                        CallNumber::TYPE_PHONE_NUMBER_RESERVATION, $request->get('callNumberPrefixIdsByNameReservation'), 
                                        $request->get('numberReservation'), $establishment->getId());
                            }
                            if (!empty($request->get('contactNumber'))) {
                                $createdObjects[] = $this->feedCallNumber(null, 1, $request, 'Téléphone principal', 
                                        CallNumber::TYPE_PHONE_CONTACT, $request->get('callNumberPrefixIdsByNameContact'), 
                                        $request->get('contactNumber'), $establishment->getId());
                            }
                            if (!empty($request->get('fax'))) {
                                $createdObjects[] = $this->feedCallNumber(null, 0, $request, 'Numéro de fax', 
                                        CallNumber::TYPE_FAX, $request->get('callNumberPrefixIdsByNameFax'), 
                                        $request->get('fax'), $establishment->getId());
                            }
                            if (!empty($request->get('mobile'))) {
                                $createdObjects[] = $this->feedCallNumber(null, 0, $request, 'Téléphone mobile', 
                                        CallNumber::TYPE_MOBILE, $request->get('callNumberPrefixIdsByNameMobile'), 
                                        $request->get('mobile'), $establishment->getId());
                            }

                            // Create cooking types
                            $cookingTypes = request()->get('cooking_types');
                            if (!empty($cookingTypes)) {
                                foreach ($cookingTypes as $cookingType) {
                                    $idCookingType = UuidTools::getId($cookingType);
                                    $createdObjects[] = $this->createLinkBusinessCategory($request, $establishment->getId(), $idCookingType);
                                }
                            }
                            // Create food specialties
                            $foodSpecialties = request()->get('food_specialties');
                            if (!empty($foodSpecialties)) {
                                foreach ($foodSpecialties as $foodSpecialty) {
                                    // TODO Manage existing and new ones
                                    $idSpecialty = UuidTools::getId($foodSpecialty);
                                    $createdObjects[] = $this->createLinkBusinessCategory($request, $establishment->getId(), $idSpecialty);
                                }
                            }
                            // Create ambiences
                            $ambiences = request()->get('ambiences');
                            if (!empty($ambiences)) {
                                foreach ($ambiences as $ambience) {
                                    $idAmbience = UuidTools::getId($ambience);
                                    $createdObjects[] = $this->createLinkBusinessCategory($request, $establishment->getId(), $idAmbience);
                                }
                            }
                            // Create services
                            $services = request()->get('services');
                            if (!empty($services)) {
                                foreach ($services as $service) {
                                    $idService = UuidTools::getId($service);
                                    $createdObjects[] = $this->createLinkBusinessCategory($request, $establishment->getId(), $idService);
                                }
                            }

                            // Create opening hours
                            foreach (DateTools::getDaysArray() as $dayIndex => $dayLabel) {
                                $createdObjects[] = $this->createOpeningHour($request, $dayIndex, $request->get('startTimeAm' . $dayIndex), $request->get('endTimeAm' . $dayIndex), $establishment->getId());
                                $createdObjects[] = $this->createOpeningHour($request, $dayIndex, $request->get('startTimePm' . $dayIndex), $request->get('endTimePm' . $dayIndex), $establishment->getId());
                            }

                            // Create medias
                            $logo = FileController::storeFile('logo', FileController::FILE_ETS_LOGO, $establishment);
                            if (checkModel($logo)) {
                                $createdObjects[] = $logo;
                                $establishment->setIdLogo($logo->getId());
                                $establishment->save();
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
                throw new Exception("L'index géographique n'a pu être enregistré.");
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
    }

    /**
     * 
     * @param  Request $request
     * @param  Establishment  $establishment
     */
    public function updateEstablishment($request, $establishment) {
        $createdObjects = array();
        try {
            if(checkModel($establishment)){
                $idLocation = 0;
                $postalCode = $request->get('address.postal_code');
                $city = $request->get('address.city');
                $countryName = $request->get('address.country');
                $latitude = $request->get('latitude');
                $longitude = $request->get('longitude');

                if (!empty($postalCode) && !empty($city) && !empty($countryName)) {
                    $locationIndex = \App\Models\LocationIndex::where('city', '=', $city)->where('postal_code', '=', $postalCode)->first();
                    if (checkModel($locationIndex)) {
                        $idLocation = $locationIndex->getId();
                    } else {
                        $country = \App\Models\Country::where('label', $countryName)->first();
                        if (checkModel($country)) {
                            $locationIndex = \App\Models\LocationIndex::create([
                                        'id' => \App\Utilities\UuidTools::generateUuid(),
                                        'postal_code' => $postalCode,
                                        'city' => $city,
                                        'latitude' => $latitude,
                                        'longitude' => $longitude,
                                        'id_country' => $country->getId()
                            ]);
                            if (checkModel($locationIndex)) {
                                $idLocation = $locationIndex->getId();
                            }
                        }
                    }
                }
                if (checkModelId($idLocation)) {
                    //Create establishment address
                    $request->merge([
                        'id_location_index' => $idLocation
                    ]);
                    $address = Address::find(UuidTools::getUuid($establishment->getIdAddress()));
                    if (checkModel($address)) {
                        //Create establishment address
                        $address->update([
                            'street' => $request->get('address.street'),
                            'street_number' => $request->get('address.street_number'),
                            'address_additional' => $request->get('address.address_additional'),
                            'region' => $request->get('address.region'),
                            'district' => $request->get('address.district'),
                            'postal_code' => $request->get('address.postal_code'),
                            'po_box' => $request->get('address.po_box'),
                            'city' => $request->get('address.city'),
                            'latitude' => $request->get('latitude'),
                            'longitude' => $request->get('longitude'),
                            'country' => $countryName,
                            'id_location_index' => $idLocation,
                        ]);

                        // Update establishment
                        $establishment->update([
                                'name' => $request->get('name'),
                                'latitude' => $request->get('latitude'),
                                'longitude' => $request->get('longitude'),
                                'id_location_index' => $idLocation,
                                'id_logo' => 0,
                        ]);
                        if (checkModel($establishment)) {
                            
                            // Update medias
                            $logo = $establishment->logo()->getRelated();
                            if(checkModel($logo) && false){
                                
                            } else {
                                $logo = FileController::storeFile('logo', FileController::FILE_ETS_LOGO, $establishment);
                            }
                            if (checkModel($logo)){
                                $establishment->setIdLogo($logo->getId());
                                $establishment->save();
                                $createdObjects[] = $logo;
                            }

                            return $establishment;
                        } else {
                            throw new Exception("L'établissement n'a pu être enregistré.");
                        }
                    } else {
                        throw new Exception("L'adresse de l'établissement n'a pu être enregistrée.");
                    }
                } else {
                    throw new Exception("L'index géographique n'a pu être enregistré.");
                }
            } else {
                throw new Exception("L'établissement est inconnu.");
            }
        } catch (Exception $e) {
            // TODO Report error in log system
            print_r($e->getMessage());

            foreach ($createdObjects as $createdObject) {
                if ($createdObject instanceof Model) {
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
            'id_business_category' => $id
        ]);
        try {
            EstablishmentBusinessCategory::create($request->all());
        } catch (Exception $ex) {


            die($ex);
        }
    }

    public function updateLinkBusinessCategory($request, $establishmentId, $id) {


        $request->merge([
            'id_establishment' => $establishmentId,
            'id_business_category' => $id
        ]);
        try {
            $cookingType = EstablishmentBusinessCategory::find($establishmentId);
            $cookingType->fill($request->all());
            $cookingType->save();
        } catch (Exception $ex) {
            die($ex);
        }
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
    public function feedCallNumber($callNumber, $main, $request, $label, $type, $idCountry, $number, $idEstablishment) {
        if (!checkModel($callNumber)) {
            $prefix = Country::where('id', UuidTools::getId($idCountry))
                    ->first();

            $request->merge([
                'main' => $main,
                'label' => $label,
                'type' => $type,
                'prefix' => $prefix->getPrefix(),
                'number' => $number,
                'id_establishment' => $idEstablishment,
            ]);
            return CallNumber::create($request->all());
        } else {
            $prefix = Country::where('id', UuidTools::getId($idCountry))
                    ->first();

            $request->merge([
                'main' => $main,
                'label' => $label,
                'type' => $type,
                'prefix' => $prefix->getPrefix(),
                'number' => $number,
                'id_establishment' => $idEstablishment,
            ]);
            return CallNumber::find(UuidTools::getUuid($callNumber->id))->first()->fill($request->all());
        }
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
