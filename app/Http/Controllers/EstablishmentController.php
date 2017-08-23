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
        $view = View::make('establishment.create')->with('form_data', $formData)->with('form_values', $formValues)->with('establishment', null)
                ->with('disableQuickSearch', true);

        return $view;
    }

    /**
     * Display the specified resource.
     *
     * @param  Establishment $establishment
     * @return Response
     */
    public function show(Establishment $establishment, $page = null) {
        $data = array();

        switch ($page) {
            case 'menu':
            case 'photos':
            default :
                // Business categories
                $data['cooking_type'] = '-';
                $mainCookingType = $establishment->businessCategories()->where('type', BusinessCategory::TYPE_COOKING_TYPE)->first();
                if ($mainCookingType instanceof BusinessCategory) {
                    $data['cooking_type'] = $mainCookingType->getName();
                }
                $data['specialties'] = array();
                $specialties = $establishment->businessCategories()->where('type', BusinessCategory::TYPE_FOOD_SPECIALTY)->orderBy('name')->get();
                foreach ($specialties as $specialty) {
                    if ($specialty instanceof BusinessCategory) {
                        $data['specialties'][] = $specialty->getName();
                    }
                }
                $data['services'] = array();
                $services = $establishment->businessCategories()->where('type', BusinessCategory::TYPE_SERVICES)->orderBy('name')->get();
                foreach ($services as $service) {
                    if ($service instanceof BusinessCategory) {
                        $data['services'][] = $service->getName();
                    }
                }
                $data['ambiences'] = array();
                $ambiences = $establishment->businessCategories()->where('type', BusinessCategory::TYPE_RESTAURANT_AMBIENCE)->orderBy('name')->get();
                foreach ($ambiences as $ambience) {
                    if ($ambience instanceof BusinessCategory) {
                        $data['ambiences'][] = $ambience->getName();
                    }
                }

                // Opening hours
                $etsOpeningHours = $establishment->openingHours()->orderBy('day', 'ASC')->orderBy('day_order', 'ASC')->get();
                $data['timetable'] = array();
                if (!empty($etsOpeningHours)) {
                    foreach ($etsOpeningHours as $openingHour) {
                        if ($openingHour instanceof OpeningHour) {
                            $time = '';
                            if ($openingHour->getClosed()) {
                                $time = "Fermé";
                            } else {
                                $time = date('H:i', strtotime($openingHour->getStartTime())) . ' - ' . date('H:i', strtotime($openingHour->getEndTime()));
                                if ($openingHour->getNoBreak()) {
                                    $time .= ' non-stop';
                                }
                            }
                            $data['timetable'][$openingHour->getDayLabel()][$openingHour->getDayOrder()]['time'] = $time;

                            $data['timetable'][$openingHour->getDayLabel()][$openingHour->getDayOrder()]['no_break'] = $openingHour->getNoBreak();
                        }
                    }
                }

                //Contact
                $data['address'] = $establishment->address()->first()->getDisplayable();
                $data['phone_number'] = null;
                $callNumber = $establishment->callNumbers()->where('type', '=', CallNumber::TYPE_PHONE_NUMBER_RESERVATION)->first();
                if (checkModel($callNumber)) {
                    $data['phone_number'] = $callNumber->getDisplayable();
                }
                break;
        }

        $view = View::make('establishment.restaurant.show')->with('establishment', $establishment)->with('data', $data)->with('page', $page);

        return $view;
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
        $view = View::make('establishment.create')->with('form_data', $formData)->with('form_values', $formValues)->with('establishment', $establishment)
                ->with('disableQuickSearch', true);
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
     * 
     * @param \App\Http\Requests\StoreBooking $request
     * @param Establishment $establishment
     */
    public function createBooking(\App\Http\Requests\StoreBooking $request, Establishment $establishment) {
        
        $user = User::where('email', $request->get('email'))->first();

        if (checkModel($user)) {
            $userId = $user->getId();
            $address = Address::where('id_object_related', $userId)->first();
            if (checkModel($address)) {
                $addressId = $address->getId();
            } else {
                //l'utilisateur donnée n'as pas encore renseigné son adresse.
                $addressId = 0;
            }
        } else {
            // Create booking user
            $userId = \App\Utilities\UuidTools::generateUuid();
            $addressId = 0;
            $user = User::create([
                        'id' => $userId,
                        'name' => $request->get('firstname'),
                        'type' => User::TYPE_USER_AUTO_INSERTED,
                        'email' => $request->get('email'),
                        'gender' => 0,
                        'id_address' => $addressId,
                        'id_inbox' => 0,
                        'id_company' => 0,
            ]);
        }
        if ($request->get('time.1') !== null) {
            $hour = $request->get('time.1');
        }
        if ($request->get('time.2') !== null) {
            $hour = $request->get('time.2');
        }
        //chaîne de caractère au format datime de mysql
        $datetime = $request->get('datetime_reservation') . $hour;

        $bookingReservation = \App\Models\Booking::create([
                    'id' => \App\Utilities\UuidTools::generateUuid(),
                    'status' => 0,
                    'lastname' => $request->get('lastname'),
                    'firstname' => $request->get('firstname'),
                    'email' => $request->get('email'),
                    'phone_number' => $request->get('phone_number'),
                    'datetime_reservation' => date('Y-m-d H:i', strtotime($datetime)),
                    'comment' => $request->get('comment'),
                    'nb_adults' => $request->get('nb_adults'),
                    'id_user' => $userId,
                    'id_establishment' => $establishment->getId(),
        ]);

        die('réservation enregistrer');
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
        $foodSpecialties = array();
        $restaurantAtmospheres = array();
        $services = array();
        $businessCategoriesData = DB::table(BusinessCategory::TABLENAME)
                ->selectRaw(DbQueryTools::genRawSqlForGettingUuid() . ', name, type')
                ->whereIn('type', array(BusinessCategory::TYPE_COOKING_TYPE,
                    BusinessCategory::TYPE_FOOD_SPECIALTY,
                    BusinessCategory::TYPE_RESTAURANT_AMBIENCE,
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
                case BusinessCategory::TYPE_FOOD_SPECIALTY:
                    $foodSpecialties[$businessCategoryData->uuid] = $businessCategoryData->name;
                    break;
                case BusinessCategory::TYPE_RESTAURANT_AMBIENCE:
                    $restaurantAtmospheres[$businessCategoryData->uuid] = $businessCategoryData->name;
                    break;
                case BusinessCategory::TYPE_SERVICES:
                    $services[$businessCategoryData->uuid] = $businessCategoryData->name;
                    break;
            }
        }

        // Select for call number prefixes
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

        // Select for time
        $timetable = array();
        for ($i = 0; $i < 24; $i++) {
            for ($j = 0; $j <= 55; $j += 30) {
                $hours = sprintf('%02d', $i);
                $minutes = sprintf('%02d', $j);
                $timetable[$hours . ':' . $minutes] = $hours . ':' . $minutes;
            }
        }
        $timetable[-1] = 'Fermé';

        // Helper array for days
        $days = DateTools::getDaysArray();

        StorageHelper::getInstance()->add('feed_establishment.form_data.cooking_types', $cookingTypes);
        StorageHelper::getInstance()->add('feed_establishment.form_data.food_specialties', $foodSpecialties);
        StorageHelper::getInstance()->add('feed_establishment.form_data.ambiences', $restaurantAtmospheres);
        StorageHelper::getInstance()->add('feed_establishment.form_data.services', $services);
        StorageHelper::getInstance()->add('feed_establishment.form_data.country_prefixes', $countryPrefixes);
        StorageHelper::getInstance()->add('feed_establishment.form_data.timetable', $timetable);
        StorageHelper::getInstance()->add('feed_establishment.form_data.days', $days);
        StorageHelper::getInstance()->add('feed_establishment.form_data.country_ids', $countryNames);
    }

    /**
     * 
     * @param Establishment $establishment
     */
    public function buildCreateFormValues() {
        $idCountry = UuidTools::getUuid(Country::where('iso', '=', \Illuminate\Support\Facades\App::getLocale())->first()->getId());
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
        foreach ($callNumbers as $callNumber) {
            if ($callNumber instanceof CallNumber) {
                $callNumbersData[$callNumber->getType()]['id_country_prefix'] = UuidTools::getUuid($callNumber->getIdCountry());
                $callNumbersData[$callNumber->getType()]['number'] = $callNumber->getNumber();
            }
        }

        // Business categories
        $businessCategories = $establishment->businessCategoryLinks()->selectRaw(DbQueryTools::genRawSqlForGettingUuid('id_business_category'))->get();
        $businessCategoryIds = $businessCategories->pluck('uuid');

        // Opening hours
        $etsOpeningHours = $establishment->openingHours()->orderBy('day', 'ASC')->orderBy('day_order', 'ASC')->get();
        $openingHours = array();
        if (!empty($etsOpeningHours)) {
            foreach ($etsOpeningHours as $openingHour) {
                if ($openingHour instanceof OpeningHour) {
                    $startTime = null;
                    if ($openingHour->getClosed()) {
                        $startTime = -1;
                    } else {
                        $startTime = date('H:i', strtotime($openingHour->getStartTime()));
                    }
                    $openingHours[$openingHour->getDay()][$openingHour->getDayOrder()]['start']['time'] = $startTime;

                    $endTime = null;
                    if ($openingHour->getClosed()) {
                        $endTime = -1;
                    } else {
                        $endTime = date('H:i', strtotime($openingHour->getEndTime()));
                    }
                    $openingHours[$openingHour->getDay()][$openingHour->getDayOrder()]['end']['time'] = $endTime;
                    $openingHours[$openingHour->getDay()][$openingHour->getDayOrder()]['no_break'] = $openingHour->getNoBreak();
                }
            }
        }

        StorageHelper::getInstance()->add('feed_establishment.form_values.id_country', $idCountry);
        StorageHelper::getInstance()->add('feed_establishment.form_values.call_numbers', $callNumbersData);
        StorageHelper::getInstance()->add('feed_establishment.form_values.business_categories', $businessCategoryIds);
        StorageHelper::getInstance()->add('feed_establishment.form_values.opening_hours', $openingHours);
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
                                    'email' => $request->get('email'),
                                    'site_url' => $request->get('site_url'),
                                    'description' => $request->get('description'),
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

                            // Create cooking types
                            $createdObjects = array_merge($createdObjects, $this->feedLinkBusinessCategories($request, $establishment, BusinessCategory::TYPE_COOKING_TYPE));
                            // Create ambiences
                            $createdObjects = array_merge($createdObjects, $this->feedLinkBusinessCategories($request, $establishment, BusinessCategory::TYPE_RESTAURANT_AMBIENCE));
                            // Create services
                            $createdObjects = array_merge($createdObjects, $this->feedLinkBusinessCategories($request, $establishment, BusinessCategory::TYPE_SERVICES));
                            // Create food specialties
                            $this->feedLinkBusinessCategoriesWithTagging($request, $establishment, BusinessCategory::TYPE_FOOD_SPECIALTY);

                            // Create opening hours
                            $createdObjects = array_merge($createdObjects, $this->feedOpeningHours($request, $establishment));

                            // Create medias
                            $logo = FileController::storeFile('logo', \App\Models\Media::TYPE_USE_ETS_LOGO, $establishment);
                            if (checkModel($logo)) {
                                $createdObjects[] = $logo;
                                $establishment->setIdLogo($logo->getId());
                                $establishment->save();
                            }

                            $homePictures = FileController::storeFileMultiple('home_pictures', \App\Models\Media::TYPE_USE_ETS_HOME_PICS, $establishment, null);
                            if (!empty($homePictures)) {
                                $createdObjects[] = $homePictures;
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
                            'email' => $request->get('email'),
                            'site_url' => $request->get('site_url'),
                            'description' => $request->get('description'),
                            'id_location_index' => $idLocation,
                        ]);
                        if (checkModel($establishment)) {
                            // Update phone numbers
                            $this->feedCallNumbers($request, $establishment);

                            // Update cooking types
                            $this->feedLinkBusinessCategories($request, $establishment, BusinessCategory::TYPE_COOKING_TYPE);
                            // Update ambiences
                            $this->feedLinkBusinessCategories($request, $establishment, BusinessCategory::TYPE_RESTAURANT_AMBIENCE);
                            // Update services
                            $this->feedLinkBusinessCategories($request, $establishment, BusinessCategory::TYPE_SERVICES);
                            // Update food specialties
                            $this->feedLinkBusinessCategoriesWithTagging($request, $establishment, BusinessCategory::TYPE_FOOD_SPECIALTY);
                            //Update opening hours
                            $this->feedOpeningHours($request, $establishment);

                            // Update medias
                            if ($request->file('logo')) {
                                $logo = $establishment->logo()->first();
                                $logo = FileController::storeFile('logo', \App\Models\Media::TYPE_USE_ETS_LOGO, $establishment, $logo);
                                if (checkModel($logo)) {
                                    $establishment->setIdLogo($logo->getId());
                                    $establishment->save();
                                    $createdObjects[] = $logo;
                                }
                            }

                            if ($request->file('home_pictures')) {
                                $homePictures = $establishment->homePictures()->get();
                                $homePictures = FileController::storeFileMultiple('home_pictures', \App\Models\Media::TYPE_USE_ETS_HOME_PICS, $establishment, $homePictures);
                                if (!empty($homePictures)) {
                                    $createdObjects[] = $homePictures;
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
     * @param Establishment $establishment
     * @param type $typeBusinessCategory
     */
    public function feedLinkBusinessCategories($request, $establishment, $typeBusinessCategory) {
        $businessCategoriesQuery = $establishment->businessCategoryLinks()
                ->join(BusinessCategory::TABLENAME, BusinessCategory::TABLENAME . '.id', '=', EstablishmentBusinessCategory::TABLENAME . '.id_business_category')
                ->where(BusinessCategory::TABLENAME . '.type', '=', $typeBusinessCategory);
        $links = array();
        $submittedBusinessCategoryUuids = $request->get('businessCategories.' . $typeBusinessCategory);
        try {
            if (empty($submittedBusinessCategoryUuids)) {
                $businessCategoriesQuery->delete();
            } else {
                $businessCategoryLinks = $businessCategoriesQuery->get();
                foreach ($submittedBusinessCategoryUuids as $uuidCategory) {
                    $idCategory = UuidTools::getId($uuidCategory);
                    $existingLink = $businessCategoryLinks->where('id_business_category', $idCategory)->first();
                    if (!checkModel($existingLink)) {
                        $links[] = EstablishmentBusinessCategory::create([
                                    'id' => UuidTools::generateUuid(),
                                    'id_establishment' => $establishment->getId(),
                                    'id_business_category' => $idCategory
                        ]);
                    }
                }
                // Delete existing links removed by the user
                $businessCategoriesQuery->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id_business_category', $submittedBusinessCategoryUuids, '', true))->delete();
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
            die();
        }
        return $links;
    }

    /**
     * 
     * @param StoreEstablishment $request
     * @param Establishment $establishment
     * @param type $typeBusinessCategory
     */
    public function feedLinkBusinessCategoriesWithTagging($request, $establishment, $typeBusinessCategory) {
        $links = array();
        $businessCategories = array();
        try {
            $requestInputKey = 'businessCategories.' . $typeBusinessCategory;
            $submittedBusinessCategoryValues = $request->get($requestInputKey);
            if (!empty($submittedBusinessCategoryValues)) {
                foreach ($submittedBusinessCategoryValues as $value) {
                    if (!empty($value) && !checkHexUuid($value)) {
                        // Create tagged business category
                        $businessCategory = BusinessCategory::create([
                                    'id' => UuidTools::generateUuid(),
                                    'name' => $value,
                                    'type' => $typeBusinessCategory
                        ]);
                        $businessCategories[] = $businessCategory;
                    }
                }
                if (!empty($businessCategories)) {
                    foreach ($businessCategories as $businessCategory) {
                        $index = array_search($businessCategory->getName(), $submittedBusinessCategoryValues);
                        if ($index !== false) {
                            $submittedBusinessCategoryValues[$index] = $businessCategory->getUuid();
                        }
                    }
                    $requestInputs = $request->all();
                    $requestInputs['businessCategories'][$typeBusinessCategory] = $submittedBusinessCategoryValues;
                    $request->replace($requestInputs);
                }
            }
            $links = $this->feedLinkBusinessCategories($request, $establishment, $typeBusinessCategory);
        } catch (Exception $e) {
            print_r($e->getMessage());
            die();
        }
        return array_merge($businessCategories, $links);
    }

    /**
     * 
     * @param StoreEstablishment $request
     * @param type $day
     * @param type $startTime
     * @param type $endTime
     * @param Establishment $establishment
     */
    public function feedOpeningHours($request, $establishment) {
        $openingHours = array();
        try {
            $etsOpeningHours = $establishment->openingHours()->get();
            foreach ($request->get('openingHours') as $day => $dayData) {
                foreach ($dayData as $dayOrder => $timeslotData) {
                    $start = null;
                    if (isset($timeslotData['start'])) {
                        $start = $timeslotData['start'];
                    }
                    $end = null;
                    if (isset($timeslotData['end'])) {
                        $end = $timeslotData['end'];
                    }
                    $noBreak = null;
                    if ($dayOrder == 1 && isset($dayData[2]['no_break'])) {
                        $noBreak = true;
                    } else if (isset($timeslotData['no_break'])) {
                        $noBreak = true;
                    }
                    if ((!empty($start) && !empty($end)) || $noBreak) {
                        $openingHour = $etsOpeningHours->where('day', $day)->where('day_order', $dayOrder)->first();
                        $attributes = [
                            'day' => $day,
                            'day_order' => $dayOrder,
                            'id_establishment' => $establishment->getId(),
                            'no_break' => $noBreak
                        ];

                        if ($start == -1 || $end == -1) {
                            $attributes['start_time'] = null;
                            $attributes['end_time'] = null;
                            $attributes['closed'] = true;
                        } else {
                            $attributes['start_time'] = date('H:i', strtotime($start));
                            $attributes['end_time'] = date('H:i', strtotime($end));
                            $attributes['closed'] = false;
                        }

                        if (checkModel($openingHour)) {
                            $attributes['day_order'] = $openingHour->getDayOrder();
                            $openingHour->update($attributes);
                        } else {
                            $attributes['id'] = UuidTools::generateUuid();
                            $openingHour = OpeningHour::create($attributes);
                        }
                    }
                }
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
            die();
        }
        return $openingHours;
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
            if (!empty($request->get('call_number.' . $typeNumber)) && checkModelId($idPrefix)) {
                $prefixCountryIds[$idPrefix] = $idPrefix;
            } else {
                $numberTypesToDelete[] = $typeNumber;
            }
        }
        // Delete existing number removed by the user
        if (!empty($numberTypesToDelete)) {
            $establishment->callNumbers()->whereIn('type', $numberTypesToDelete)->delete();
        }
        if (!empty($prefixCountryIds)) {
            // Get all countries data matching each selected number prefix
            $prefixCountries = DB::table(Country::TABLENAME)->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id', $prefixCountryIds))
                            ->selectRaw(DbQueryTools::genRawSqlForGettingUuid() . ', prefix, id')->get();
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
                $prefixCountryUuid = $request->get('id_country_prefix.' . $typeNumber);
                if (isset($prefixByIdCountry[$prefixCountryUuid])) {
                    $prefix = $prefixByIdCountry[$prefixCountryUuid];
                }

                if (!empty($typeNumber) && !empty($prefix) && !empty($number)) {
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

                    try {
                        if (!checkModel($callNumber)) {
                            $attributes['id'] = UuidTools::generateUuid();
                            $callNumber = CallNumber::create($attributes);
                        } else {
                            $callNumber->update($attributes);
                        }
                        $callNumbers[] = $callNumber;
                    } catch (Exception $e) {
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
