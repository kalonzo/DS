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
        $this->buildCreateFormValues();
        $formData = StorageHelper::getInstance()->get('feed_establishment.form_data');
        $formValues = StorageHelper::getInstance()->get('feed_establishment.form_values');
        $view = View::make('establishment.create')->with('form_data', $formData)->with('form_values', $formValues)->with('establishment', null);

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
        $this->buildEditFormValues($establishment);
        $formData = StorageHelper::getInstance()->get('feed_establishment.form_data');
        $formValues = StorageHelper::getInstance()->get('feed_establishment.form_values');
        $view = View::make('establishment.create')->with('form_data', $formData)->with('form_values', $formValues)->with('establishment', $establishment);
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
        $countryName = array();
        $countriesData = DB::table(Country::TABLENAME)
                ->selectRaw(DbQueryTools::genRawSqlForGettingUuid() . ', label, prefix')
                ->where('prefix', '>', 0)
                ->orderBy('label')
                ->get();
        foreach ($countriesData as $countryData) {
            $countryPrefixes[$countryData->uuid] = $countryData->label . " | +" . $countryData->prefix;
            $countryName[$countryData->uuid] = $countryData->label;
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

        StorageHelper::getInstance()->add('feed_establishment.form_data.cooking_types', $cookingTypes);
        StorageHelper::getInstance()->add('feed_establishment.form_data.food_specialities', $foodSpecialities);
        StorageHelper::getInstance()->add('feed_establishment.form_data.ambiences', $restaurantAtmospheres);
        StorageHelper::getInstance()->add('feed_establishment.form_data.services', $services);
        StorageHelper::getInstance()->add('feed_establishment.form_data.country_prefixes', $countryPrefixes);
        StorageHelper::getInstance()->add('feed_establishment.form_data.timetable', $timetable);
        StorageHelper::getInstance()->add('feed_establishment.form_data.days', $days);
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
        // Values for business categories
//        $linkEstablishmentBusiness = EstablishmentBusinessCategory::where('id_establishment', '=', $establishment->getId())->get();
        $idCountry = UuidTools::getUuid($establishment->address()->first()->getIdCountry());
        $callNumbers = $establishment->callNumbers()->get();
        $callNumbersData = array();
        foreach($callNumbers as $callNumber){
            if($callNumber instanceof CallNumber){
                $callNumbersData[$callNumber->getType()]['id_country_prefix'] = UuidTools::getUuid($callNumber->getIdCountry());
                $callNumbersData[$callNumber->getType()]['number'] = $callNumber->getNumber();
            }
        }
        
        StorageHelper::getInstance()->add('feed_establishment.form_values.id_country', $idCountry);
        StorageHelper::getInstance()->add('feed_establishment.form_values.call_numbers', $callNumbersData);
    }

    /**
     * 
     * @param StoreEstablishment $request
     */
    public function storeEstablishment($request) {
        $createdObjects = array();
        try {
            $idLocation = 0;
            $idCountry = 0;
            $postalCode = $request->get('address.postal_code');
            $city = $request->get('address.city');
            $uuidCountry = $request->get('address.id_country');
            $latitude = $request->get('latitude');
            $longitude = $request->get('longitude');

            $country = \App\Models\Country::findUuid($uuidCountry);
            if (!empty($postalCode) && !empty($city) && checkModelId($uuidCountry)) {
                $idCountry = UuidTools::getId($uuidCountry);
                $locationIndex = \App\Models\LocationIndex::where('city', '=', $city)->where('postal_code', '=', $postalCode)->first();
                if (checkModel($locationIndex)) {
                    $idLocation = $locationIndex->getId();
                } else {
                    $locationIndex = \App\Models\LocationIndex::create([
                                'id' => \App\Utilities\UuidTools::generateUuid(),
                                'postal_code' => $postalCode,
                                'city' => $city,
                                'latitude' => $latitude,
                                'longitude' => $longitude,
                                'id_country' => $idCountry
                    ]);
                    if (checkModel($locationIndex)) {
                        $createdObjects[] = $locationIndex;
                        $idLocation = $locationIndex->getId();
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
                            'id_country' => $idCountry,
                            'country' => $country->getLabel(),
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
                            // Create phone numbers
                            $createdObjects = array_merge($createdObjects, $this->feedCallNumbers($request, $establishment));

//      TODO Manage clean create below
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
            if (checkModel($establishment)) {
                $idLocation = 0;
                $idCountry = 0;
                $postalCode = $request->get('address.postal_code');
                $city = $request->get('address.city');
                $uuidCountry = $request->get('address.id_country');
                $latitude = $request->get('latitude');
                $longitude = $request->get('longitude');

                $country = \App\Models\Country::findUuid($uuidCountry);
                if (!empty($postalCode) && !empty($city) && checkModelId($uuidCountry)) {
                    $idCountry = UuidTools::getId($uuidCountry);
                    $locationIndex = \App\Models\LocationIndex::where('city', '=', $city)->where('postal_code', '=', $postalCode)->first();
                    if (checkModel($locationIndex)) {
                        $idLocation = $locationIndex->getId();
                    } else {
                        $locationIndex = \App\Models\LocationIndex::create([
                                    'id' => \App\Utilities\UuidTools::generateUuid(),
                                    'postal_code' => $postalCode,
                                    'city' => $city,
                                    'latitude' => $latitude,
                                    'longitude' => $longitude,
                                    'id_country' => $idCountry
                        ]);
                        if (checkModel($locationIndex)) {
                            $idLocation = $locationIndex->getId();
                        }
                    }
                }
                if (checkModelId($idLocation)) {
                    $address = Address::find(UuidTools::getUuid($establishment->getIdAddress()));
                    if (checkModel($address)) {
                        // Update establishment address
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
                            'id_country' => $country->getId(),
                            'country' => $country->getLabel(),
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
                            // Update phone numbers
                            $this->feedCallNumbers($request, $establishment);

                            // Update medias
                            if ($request->file('logo')) {
                                $logo = $establishment->logo()->first();
                                if (checkModel($logo) && false) {
                                    
                                } else {
                                    $logo = FileController::storeFile('logo', FileController::FILE_ETS_LOGO, $establishment);
                                }
                                if (checkModel($logo)) {
                                    $establishment->setIdLogo($logo->getId());
                                    $establishment->save();
                                    $createdObjects[] = $logo;
                                }
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
     * @param StoreEstablishment $request
     * @param Establishment $establishment
     */
    public function feedCallNumbers($request, $establishment) {
        $callNumbers = array();
        $prefixByIdCountry = array();
        // Get all country ids matching each selected number prefix
        $prefixCountryIds = array();
        foreach ($request->get('id_country_prefix') as $typeNumber => $idPrefix) {
            if (!empty($request->get('call_number.'.$typeNumber)) && checkModelId($idPrefix)) {
                $prefixCountryIds[$idPrefix] = $idPrefix;
            }
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
