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
        $view = View::make('establishment.restaurant.feed')->with('form_data', $formData)->with('form_values', $formValues)->with('establishment', null)
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
        $establishment->incrementWeeklyVisit();
        $data = array();

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
        //Contact
        $data['address'] = $establishment->address()->first()->getDisplayable();
        $data['phone_number'] = null;
        $callNumber = $establishment->callNumbers()->where('type', '=', CallNumber::TYPE_PHONE_NUMBER_RESERVATION)->first();
        if (checkModel($callNumber)) {
            $data['phone_number'] = $callNumber->getDisplayable();
        }

        switch ($page) {
            case 'menu':
                $data['menus'] = array();
                $data['daily_menu'] = array();
                $menusWithMedia = $establishment->menus(false)
                                            ->select([\App\Models\Menu::TABLENAME.'.*', \App\Models\EstablishmentMedia::TABLENAME.'.local_path'])
                                            ->join(\App\Models\EstablishmentMedia::TABLENAME, \App\Models\EstablishmentMedia::TABLENAME.'.id', '='
                                                    , \App\Models\Menu::TABLENAME.'.id_file')
                                            ->orderBy(\App\Models\Menu::TABLENAME.'.created_at')
                                            ->get();
                foreach ($menusWithMedia as $menuWithMedia) {
                    if ($menuWithMedia instanceof \App\Models\Menu) {
                        $menuData = array(
                                                'name' => $menuWithMedia->getName(),
                                                'file' => asset($menuWithMedia->local_path),
                                            );
                        if($menuWithMedia->getIsDailyMenu()){
                            $data['daily_menu'][] = $menuData;
                        } else {
                            $data['menus'][] = $menuData;
                        }
                    }
                }
                
                $data['dishes'] = array();
                $dishesWithMedia = $establishment->dishes()
                                            ->select([\App\Models\Dish::TABLENAME.'.*', \App\Models\EstablishmentMedia::TABLENAME.'.local_path',
                                                \App\Models\Currency::TABLENAME.'.symbol'])
                                            ->join(\App\Models\EstablishmentMedia::TABLENAME, \App\Models\EstablishmentMedia::TABLENAME.'.id', '='
                                                    , \App\Models\Dish::TABLENAME.'.id_photo')
                                            ->join(\App\Models\Currency::TABLENAME, \App\Models\Currency::TABLENAME.'.id', '='
                                                    , \App\Models\Dish::TABLENAME.'.currency')
                                            ->orderBy(\App\Models\Dish::TABLENAME.'.created_at')
                                            ->get();
                foreach ($dishesWithMedia as $dishWithMedia) {
                    if ($dishWithMedia instanceof \App\Models\Dish) {
                        $price = $dishWithMedia->getPrice();
                        $currency = $dishWithMedia->symbol;
                        $priceFormatted = formatPrice($dishWithMedia->getPrice(), $dishWithMedia->getCurrencyLabel());
                        $priceFormatted = str_replace(chr(0xC2).chr(0xA0), ' ', $priceFormatted);
                        $priceArray = explode(' ', $priceFormatted);
                        if(count($priceArray) === 1){
                            $price = $priceFormatted;
                        } else if(count($priceArray) === 2){
                            if($priceArray[1] === $currency){
                                $price = $priceArray[0];
                                $currency = $priceArray[1];
                            } else if($priceArray[0] === $currency){
                                $price = $priceArray[1];
                                $currency = $priceArray[0];
                            } 
                        }
                        $data['dishes'][] = array(
                                                'name' => $dishWithMedia->getName(),
                                                'description' => $dishWithMedia->getDescription(),
                                                'price' => $price,
                                                'currency' => $currency,
                                                'picture' => asset($dishWithMedia->local_path),
                                            );
                    }
                }
                break;
            case 'photos':
                $data['galleries'] = array();
                $galleriesData = $establishment->galleries()
                                    ->select([\App\Models\Gallery::TABLENAME.'.*', DB::raw('count('.\App\Models\Gallery::TABLENAME.'.id) as nbMedias'),
                                                DB::raw(DbQueryTools::genRawSqlForGettingUuid('id', \App\Models\Gallery::TABLENAME))])
                                    ->join(\App\Models\EstablishmentMedia::TABLENAME, \App\Models\EstablishmentMedia::TABLENAME.'.id_gallery', '='
                                            , \App\Models\Gallery::TABLENAME.'.id')
                                    ->orderBy(\App\Models\Gallery::TABLENAME.'.created_at')
                                    ->groupBy(\App\Models\Gallery::TABLENAME.'.id')
                                    ->get();
                $galleriesUuids = $galleriesData->pluck('uuid')->all();
                if(!empty($galleriesUuids)){
                    $galleryMedias = \App\Models\EstablishmentMedia
                                        ::select([DB::raw(DbQueryTools::genRawSqlForGettingUuid('id_gallery')), 'local_path'])
    //                                    ->where('status', '=', \App\Models\EstablishmentMedia::STATUS_VALIDATED)
                                        ->where('position', '=', 1)
                                        ->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id_gallery', $galleriesUuids))
                                        ->orderBy(\App\Models\EstablishmentMedia::TABLENAME.'.created_at')
                                        ->get()
                                    ;
                    $mediaPathByGallery = $galleryMedias->mapWithKeys(function ($item) {
                        return [$item->uuid => asset($item->local_path)];
                    });
                    foreach ($galleriesData as $galleryData) {
                        if ($galleryData instanceof \App\Models\Gallery) {
                            $mediaPath = null;
                            if(isset($mediaPathByGallery[$galleryData->uuid])){
                                $mediaPath = $mediaPathByGallery[$galleryData->uuid];
                            }
                            if(!empty($mediaPath)){
                                $data['galleries'][] = array(
                                                    'id' => $galleryData->getUuid(),
                                                    'name' => $galleryData->getName(),
                                                    'info' => '('.$galleryData->nbMedias.' '.__('photos').')',
                                                    'picture' => $mediaPath
                                                );
                            }
                        }
                    }
                }
                
                $data['last_pics'] = array();
                $lastMedias = \App\Models\EstablishmentMedia
                                    ::join(\App\Models\Gallery::TABLENAME, \App\Models\Gallery::TABLENAME.'.id', '=', 
                                            \App\Models\EstablishmentMedia::TABLENAME.'.id_gallery')
                                    ->select([\App\Models\EstablishmentMedia::TABLENAME.'.*'])
//                                    ->where('status', '=', \App\Models\EstablishmentMedia::STATUS_VALIDATED)
                                    ->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id_establishment', $establishment->getUuid(), 
                                                                                            \App\Models\Gallery::TABLENAME))
                                    ->orderBy(\App\Models\EstablishmentMedia::TABLENAME.'.created_at', 'DESC')
                                    ->limit(18)
                                    ->get()
                                ;
                foreach ($lastMedias as $lastMedia) {
                    if ($lastMedia instanceof \App\Models\EstablishmentMedia) {
                        $data['last_pics'][] = array(
                                                'picture' => asset($lastMedia->local_path)
                                            );
                    }
                }
                break;
            default :
                // Business categories
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
                $data['staff'] = array();
                $employeesWithMedia = $establishment->employees()
                                            ->select([\App\Models\Employee::TABLENAME.'.*', \App\Models\EstablishmentMedia::TABLENAME.'.local_path'])
                                            ->join(\App\Models\EstablishmentMedia::TABLENAME, \App\Models\EstablishmentMedia::TABLENAME.'.id', '='
                                                    , \App\Models\Employee::TABLENAME.'.id_photo')
                                            ->orderBy(\App\Models\Employee::TABLENAME.'.created_at')
                                            ->get();
                foreach ($employeesWithMedia as $employeeWithMedia) {
                    if ($employeeWithMedia instanceof \App\Models\Employee) {
                        $data['staff'][] = array(
                                                'name' => $employeeWithMedia->getFirstname().' '.$employeeWithMedia->getLastname(),
                                                'position' => $employeeWithMedia->getPosition(),
                                                'picture' => asset($employeeWithMedia->local_path),
                                            );
                    }
                }
                
                $data['promotions'] = array();
                $promosWithMedia = $establishment->promotions()
                                            ->select([\App\Models\Promotion::TABLENAME.'.*', \App\Models\EstablishmentMedia::TABLENAME.'.local_path'])
                                            ->leftJoin(\App\Models\EstablishmentMedia::TABLENAME, \App\Models\EstablishmentMedia::TABLENAME.'.id_object_related', '='
                                                    , \App\Models\Promotion::TABLENAME.'.id')
                                            ->whereRaw(\App\Models\Promotion::TABLENAME.'.end_date > NOW()')
                                            ->orderBy(\App\Models\Promotion::TABLENAME.'.start_date')
                                            ->get();
                foreach ($promosWithMedia as $promoWithMedia) {
                    if ($promoWithMedia instanceof \App\Models\Promotion) {
                        $promoData = array(
                                            'name' => $promoWithMedia->getName(),
                                            'description' => $promoWithMedia->getDescription(),
                                            'start_date' => $promoWithMedia->getStartDate(),
                                            'end_date' => $promoWithMedia->getEndDate(),
                                            'start_timestp' => DateTools::getStringTimestpFromDate($promoWithMedia->getStartDate()),
                                            'end_timestp' => DateTools::getStringTimestpFromDate($promoWithMedia->getEndDate()),
                                        );
                        if(!empty($promoWithMedia->local_path)){
                            $promoData['picture'] = asset($promoWithMedia->local_path);
                        }
                        $data['promotions'][] = $promoData;
                    }
                }
                
                $data['story'] = array();
                $storiesWithMedia = $establishment->stories()
                                            ->select([\App\Models\EstablishmentHistory::TABLENAME.'.*', \App\Models\EstablishmentMedia::TABLENAME.'.local_path'])
                                            ->join(\App\Models\EstablishmentMedia::TABLENAME, \App\Models\EstablishmentMedia::TABLENAME.'.id', '='
                                                    , \App\Models\EstablishmentHistory::TABLENAME.'.id_photo')
                                            ->orderBy(\App\Models\EstablishmentHistory::TABLENAME.'.year')
                                            ->get();
                foreach ($storiesWithMedia as $storyWithMedia) {
                    if ($storyWithMedia instanceof \App\Models\EstablishmentHistory) {
                        $data['story'][] = array(
                                                'id' => $storyWithMedia->getUuid(),
                                                'title' => $storyWithMedia->getTitle(),
                                                'text' => $storyWithMedia->getContent(),
                                                'label' => $storyWithMedia->getYear(),
                                                'value' => $storyWithMedia->getYear(),
                                                'picture' => asset($storyWithMedia->local_path),
                                            );
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

                // Close periods
                $closePeriods = $establishment->closePeriods()->whereRaw('end_date >= NOW()')->orderBy('start_date', 'ASC')->orderBy('end_date', 'ASC')->get();
                $data['close_periods'] = array();
                if (!empty($closePeriods)) {
                    foreach ($closePeriods as $closePeriod) {
                        if ($closePeriod instanceof \App\Models\ClosePeriod) {
                            $data['close_periods'][] = $closePeriod;
                        }
                    }
                }
                break;
        }
        
        $this->buildShowFormData($establishment);
        $formData = StorageHelper::getInstance()->get('show_establishment.form_data');
        
        $view = View::make('establishment.restaurant.show')->with('establishment', $establishment)->with('data', $data)->with('page', $page)->with('form_data', $formData)
                ->with('footerHidden', true);;

        return $view;
    }
    
    public function showAjax(Request $request, Establishment $establishment, $page = null){
        $response = response();
        $jsonResponse = array('success' => 0);
        $createdObjects = array();
        
        try {
            $action = $request->get('action');

            switch ($action){
                default :
                    $jsonResponse['error'] = "Le système n'a pu identifier la demande.";
                    break;
                case 'show_gallery':
                    $uuidGallery = $request->get('id_gallery');
                    if(checkModelId($uuidGallery)){
                        $gallery = $establishment->galleries()->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id', $uuidGallery))
                                ->first();
                        if(checkModel($gallery)){
                            $medias = $gallery->medias()/*->where('status', '=', \App\Models\Media::STATUS_VALIDATED)*/->get();
                            
                            $view = View::make('components.gallery-pics')->with('medias', $medias);
                            $jsonResponse['content'] = $view->render();
                            $jsonResponse['success'] = 1;
                        } else {
                            $jsonResponse['error'] = "Un problème est survenu lors du chargement de la galerie.";
                        }
                    } else {
                        $jsonResponse['error'] = "Les informations de la galerie n'ont pas pu être trouvée.";
                    }
                break;
            }
        } catch (Exception $e) {
            // TODO Report error in log system
            print_r($e->getMessage());

            foreach ($createdObjects as $createdObject) {
                if ($createdObject instanceof \Illuminate\Database\Eloquent\Model) {
                    $createdObject->delete();
                }
            }
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
        $this->buildFeedFormData();
        $this->buildEditFormValues($establishment);
        $formData = StorageHelper::getInstance()->get('feed_establishment.form_data');
        $formValues = StorageHelper::getInstance()->get('feed_establishment.form_values');
        $view = View::make('establishment.restaurant.feed')->with('form_data', $formData)->with('form_values', $formValues)->with('establishment', $establishment)
                ->with('disableQuickSearch', true)->with('footerHidden', true);
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
        $response = response();
        $jsonResponse = array('success' => 0);
        
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
        $time = $request->get('time_reservation');
        $date = new \DateTime(str_replace('/', '-', $request->get('datetime_reservation')).' '.$time);

        $bookingReservation = \App\Models\Booking::create([
                    'id' => \App\Utilities\UuidTools::generateUuid(),
                    'status' => \App\Models\Booking::STATUS_PENDING,
                    'lastname' => $request->get('lastname'),
                    'firstname' => $request->get('firstname'),
                    'email' => $request->get('email'),
                    'phone_number' => $request->get('phone_number'),
                    'datetime_reservation' => $date->format('Y-m-d H:i'),
                    'comment' => $request->get('comment'),
                    'nb_adults' => $request->get('nb_adults'),
                    'id_user' => $userId,
                    'id_establishment' => $establishment->getId(),
        ]);
        
        if(checkModel($bookingReservation)){
            $jsonResponse['success'] = 1;
        }
        
        if($request->ajax()){
            $responsePrepared = $response->json($jsonResponse);
            return $responsePrepared;
        } else {
            return redirect();
        }
    }
    
    
    public function createBookingAjax(\Illuminate\Http\Request $request, Establishment $establishment){
        $response = response();
        $jsonResponse = array('success' => 0);
        $createdObjects = array();
        
        try {
            $action = $request->get('action');
            switch ($action){
                default :
                    $jsonResponse['error'] = "Le système n'a pu identifier la demande.";
                    break;
                case 'change_date':
                    $date = $request->get('date');
                    if(!empty($date)){
                        // Opening hours
                        $today = new \DateTime(str_replace('/', '-', $date));
                        $dayIndex = $today->format('N');
                        $datetimeReservation = $today->format('d/m/Y');

                        $timeslots = array();
                        $closePeriods = $establishment->closePeriods()->whereRaw('start_date <= NOW()')->whereRaw('end_date >= NOW()')->count();
                        if($closePeriods === 0){
                            $openingHours = $establishment->openingHours()->where('day', '=', $dayIndex)->where('closed', '=', 0)->whereRaw('end_time >= NOW()')
                                    ->whereNull('start_date')->orWhereRaw('start_date <= NOW()')->whereNull('end_date')->orWhereRaw('end_date >= NOW()')
                                    ->orderBy('day')->orderBy('day_order')->orderBy('start_time')
                                    ->get();
                            foreach($openingHours as $openingHour){
                                $timeslots[$openingHour->getUuid()][$openingHour->getDayOrder()]['start'] = $openingHour->getStartTime();
                                $timeslots[$openingHour->getUuid()][$openingHour->getDayOrder()]['end'] = $openingHour->getEndTime();
                                $timeslots[$openingHour->getUuid()][$openingHour->getDayOrder()]['no_break'] = $openingHour->getNoBreak();
                            }
                        }
                        $formData = ['time_slots' => $timeslots];
                        $view = View::make('establishment.restaurant.feed.booking-hours')->with('form_data', $formData);
                        $jsonResponse['content'] = $view->render();
                        $jsonResponse['success'] = 1;
                    } else {
                        $jsonResponse['error'] = "Les horaires n'ont pas pu être trouvés.";
                    }
                break;
            }
        } catch (Exception $e) {
            // TODO Report error in log system
            print_r($e->getMessage());

            foreach ($createdObjects as $createdObject) {
                if ($createdObject instanceof \Illuminate\Database\Eloquent\Model) {
                    $createdObject->delete();
                }
            }
        }
        
        $responsePrepared = $response->json($jsonResponse);
        return $responsePrepared;
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
        
        $currencies = \App\Models\Currency::getCurrenciesById();

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
        
        $jobTypes = \App\Models\JobType::getLabelByType();

        StorageHelper::getInstance()->add('feed_establishment.form_data.cooking_types', $cookingTypes);
        StorageHelper::getInstance()->add('feed_establishment.form_data.food_specialties', $foodSpecialties);
        StorageHelper::getInstance()->add('feed_establishment.form_data.ambiences', $restaurantAtmospheres);
        StorageHelper::getInstance()->add('feed_establishment.form_data.services', $services);
        StorageHelper::getInstance()->add('feed_establishment.form_data.country_prefixes', $countryPrefixes);
        StorageHelper::getInstance()->add('feed_establishment.form_data.timetable', $timetable);
        StorageHelper::getInstance()->add('feed_establishment.form_data.days', $days);
        StorageHelper::getInstance()->add('feed_establishment.form_data.country_ids', $countryNames);
        StorageHelper::getInstance()->add('feed_establishment.form_data.currency_ids', $currencies);
        StorageHelper::getInstance()->add('feed_establishment.form_data.job_types', $jobTypes);
    }

    
    public function buildShowFormData(Establishment $establishment) {
        // Select for call number prefixes
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
        
        
        // Opening hours
        $today = new \DateTime();
        $dayIndex = $today->format('N');
        $datetimeReservation = $today->format('d/m/Y');
                
        $timeslots = array();
        $closePeriods = $establishment->closePeriods()->whereRaw('start_date <= NOW()')->whereRaw('end_date >= NOW()')->count();
        if($closePeriods === 0){
            $openingHours = $establishment->openingHours()->where('day', '=', $dayIndex)->where('closed', '=', 0)->whereRaw('end_time >= NOW()')
                    ->whereNull('start_date')->orWhereRaw('start_date <= NOW()')->whereNull('end_date')->orWhereRaw('end_date >= NOW()')
                    ->orderBy('day')->orderBy('day_order')->orderBy('start_time')
                    ->get();
            foreach($openingHours as $openingHour){
                $timeslots[$openingHour->getUuid()][$openingHour->getDayOrder()]['start'] = $openingHour->getStartTime();
                $timeslots[$openingHour->getUuid()][$openingHour->getDayOrder()]['end'] = $openingHour->getEndTime();
                $timeslots[$openingHour->getUuid()][$openingHour->getDayOrder()]['no_break'] = $openingHour->getNoBreak();
            }
        }
        
        $idCountry = Country::where('iso', '=', \Illuminate\Support\Facades\App::getLocale())->first()->getId();
        StorageHelper::getInstance()->add('show_establishment.form_data.id_country', $idCountry);
        StorageHelper::getInstance()->add('show_establishment.form_data.country_prefixes', $countryPrefixes);
        StorageHelper::getInstance()->add('show_establishment.form_data.time_slots', $timeslots);
        StorageHelper::getInstance()->add('show_establishment.form_data.datetime_reservation', $datetimeReservation);
    }
    /**
     * 
     * @param Establishment $establishment
     */
    public function buildCreateFormValues() {
        $idCountry = Country::where('iso', '=', \Illuminate\Support\Facades\App::getLocale())->first()->getId();
        $idCurrency = \App\Utilities\CurrencyTools::getIdCurrencyFromLocale();
        StorageHelper::getInstance()->add('feed_establishment.form_values.id_country', $idCountry);
        StorageHelper::getInstance()->add('feed_establishment.form_values.id_currency', $idCurrency);
    }

    /**
     * 
     * @param Establishment $establishment
     */
    public function buildEditFormValues(Establishment $establishment) {
        // Default ID country
        $idCountry = $establishment->address()->first()->getIdCountry();

        // Call numbers
        $callNumbers = $establishment->callNumbers()->get();
        $callNumbersData = array();
        foreach ($callNumbers as $callNumber) {
            if ($callNumber instanceof CallNumber) {
                $callNumbersData[$callNumber->getType()]['id_country_prefix'] = $callNumber->getIdCountry();
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

        $idCurrency = \App\Utilities\CurrencyTools::getIdCurrencyFromLocale();
        if(!empty($establishment->getIdCurrency())){
            $idCurrency = $establishment->getIdCurrency();
        }
        
        StorageHelper::getInstance()->add('feed_establishment.form_values.id_country', $idCountry);
        StorageHelper::getInstance()->add('feed_establishment.form_values.id_currency', $idCurrency);
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
            $postalCode = $request->get('address.postal_code');
            $city = $request->get('address.city');
            $idCountry = $request->get('address.id_country');
            $district = $request->get('address.district');
            $latitude = $request->get('latitude');
            $longitude = $request->get('longitude');

            if (!empty($postalCode) && !empty($city) && !empty($idCountry)) {
                $locationIndexQuery = \App\Models\LocationIndex::where('city', 'LIKE', $city)->where('postal_code', 'LIKE', $postalCode);
//                if(!empty($district)){
//                    $locationIndexQuery->where('district', 'LIKE', $district);
//                }
                $locationIndex = $locationIndexQuery->first();
                if (checkModel($locationIndex)) {
                    $idLocation = $locationIndex->getId();
                } else {
                    $locationIndex = \App\Models\LocationIndex::create([
                                'id' => \App\Utilities\UuidTools::generateUuid(),
                                'postal_code' => $postalCode,
                                'city' => $city,
//                                'district' => $district,
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
                            'district' => $district,
                            'postal_code' => $request->get('address.postal_code'),
                            'po_box' => $request->get('address.po_box'),
                            'city' => $request->get('address.city'),
                            'latitude' => $request->get('latitude'),
                            'longitude' => $request->get('longitude'),
                            'id_country' => $idCountry,
                            'id_location_index' => $idLocation,
                            'id_object_related' => $idEstablishment,
                            'type_object_related' => Establishment::TYPE_GLOBAL_OBJECT,
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
                                    'description' => htmlspecialchars($request->get('description'), ENT_QUOTES),
                                    'id_location_index' => $idLocation,
                                    'average_price_min' => $request->get('average_price_min'),
                                    'average_price_max' => $request->get('average_price_max'),
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
                if ($createdObject instanceof \Illuminate\Database\Eloquent\Model) {
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
                $postalCode = $request->get('address.postal_code');
                $city = $request->get('address.city');
                $idCountry = $request->get('address.id_country');
                $latitude = $request->get('latitude');
                $longitude = $request->get('longitude');

                if (!empty($postalCode) && !empty($city) && !empty($idCountry)) {
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
                            'id_country' => $idCountry,
                            'id_location_index' => $idLocation,
                        ]);

                        // Update establishment
                        $establishment->update([
                            'name' => $request->get('name'),
                            'latitude' => $request->get('latitude'),
                            'longitude' => $request->get('longitude'),
                            'email' => $request->get('email'),
                            'site_url' => $request->get('site_url'),
                            'description' => htmlspecialchars($request->get('description'), ENT_QUOTES),
                            'id_location_index' => $idLocation,
                            'average_price_min' => $request->get('average_price_min'),
                            'average_price_max' => $request->get('average_price_max'),
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
                if ($createdObject instanceof \Illuminate\Database\Eloquent\Model) {
                    $createdObject->delete();
                }
            }
        }
    }

    public function ajax(StoreEstablishment $request, Establishment $establishment) {
        $response = response();
        $jsonResponse = array('success' => 0);
        $createdObjects = array();
        try {
            $action = $request->get('action');
            switch ($action){
                case 'add_gallery':
                    $gallery = \App\Models\Gallery::create([
                        'id' => UuidTools::generateUuid(),
                        'status' => \App\Models\Gallery::STATUS_PENDING,
                        'name' => $request->get('new_gallery_name'),
                        'type' => \App\Models\Gallery::TYPE_ESTABLISHMENT_GALLERY,
                        'id_establishment' => $establishment->getId()
                    ]);

                    if (checkModel($gallery) && $request->file('new_gallery')) {
                        $newGalleryMedias = FileController::storeFileMultiple('new_gallery', \App\Models\Media::TYPE_USE_ETS_GALLERY_ITEM, $gallery);
                        $firstMedia = current($newGalleryMedias);
                        if(checkModel($firstMedia)){
                            $firstMedia->setPosition(1);
                            $firstMedia->save();
                        }

                        $view = View::make('establishment.restaurant.feed.photos-galleries')->with('establishment', $establishment)->with('reloaded', true);
                        $jsonResponse['content'] = $view->render();
                        $jsonResponse['success'] = 1;
                    }
                    break;
                case 'delete_gallery':
                    $uuidGallery = $request->get('id_item');
                    $gallery = \App\Models\Gallery::findUuid($uuidGallery);
                    if(checkModel($gallery)){
                        $deleted = $gallery->delete();
                        if($deleted){
                            $view = View::make('establishment.restaurant.feed.photos-galleries')->with('establishment', $establishment)->with('reloaded', true);
                            $jsonResponse['content'] = $view->render();
                            $jsonResponse['success'] = 1;
                        }
                    }
                    break;
                case 'add_media_to_gallery':
                    $filesToUpload = $request->allFiles();
                    if(isset($filesToUpload['gallery']) && !empty($filesToUpload['gallery'])){
                        foreach($filesToUpload['gallery'] as $uuidGallery => $uploadedFiles){
                            $gallery = \App\Models\Gallery::find($uuidGallery);
                            if(checkModel($gallery)){
                                $galleryMedias = FileController::storeFileMultiple('gallery.'.$uuidGallery, \App\Models\Media::TYPE_USE_ETS_GALLERY_ITEM, $gallery);
                                if(count($galleryMedias) === count($uploadedFiles)){
                                    $medias = $gallery->medias()->orderBy('created_at')->get();
                                    $existingFiles = getMediaUrlForInputFile($medias, false);
                                    $existingFilesConfig = getMediaConfigForInputFile($medias, false);

                                    $jsonResponse['success'] = 1;
                                    $jsonResponse['inputData']['initialPreview'] = $existingFiles;
                                    $jsonResponse['inputData']['initialPreviewConfig'] = $existingFilesConfig;
                                }
                            }
                        }
                    }
                    break;
                case 'add_menu':
                    $menu = \App\Models\Menu::create([
                        'id' => UuidTools::generateUuid(),
                        'name' => $request->get('menu_name'),
                        'status' => \App\Models\Menu::STATUS_ACTIVE,
                        'id_establishment' => $establishment->getId(),
                        'id_file' => 0
                    ]);

                    if (checkModel($menu) && $request->file('new_menu')) {
                        $newMenuMedia = FileController::storeFile('new_menu', \App\Models\Media::TYPE_USE_ETS_MENU, $menu);
                        if(checkModel($newMenuMedia)){
                            $menu->setIdFile($newMenuMedia->getId())->save();
                        } else {
                            $menu->delete();
                        }
                        
                        $menusMedias = array();
                        foreach($establishment->menus()->orderBy('created_at')->get() as $menu){
                            $menusMedias[] = $menu->media()->first();
                        }
                        $existingFiles = getMediaUrlForInputFile($menusMedias, false);
                        $existingFilesConfig = getMediaConfigForInputFile($menusMedias, false);
                        $jsonResponse['inputData']['initialPreview'] = $existingFiles;
                        $jsonResponse['inputData']['initialPreviewConfig'] = $existingFilesConfig;
                        $jsonResponse['success'] = 1;
                    }
                    break;
                case 'add_dish':
                    $price = $request->get('new_dish_price') + ($request->get('new_dish_price_cents') / 100);
                    $dish = \App\Models\Dish::create([
                        'id' => UuidTools::generateUuid(),
                        'name' => $request->get('new_dish_name'),
                        'description' => $request->get('new_dish_description'),
                        'status' => \App\Models\Dish::STATUS_ACTIVE,
                        'price' => $price,
                        'currency' => $request->get('new_dish_price_currency'),
                        'id_establishment' => $establishment->getId(),
                        'id_photo' => 0
                    ]);

                    if (checkModel($dish)) {
                        $newDishMedia = FileController::storeFile('new_dish', \App\Models\Media::TYPE_USE_ETS_DISH, $dish);
                        if(checkModel($newDishMedia)){
                            $dish->setIdPhoto($newDishMedia->getId())->save();
                        } else {
                            $dish->delete();
                        }
                        
                        $dishes = $establishment->dishes()->orderBy('created_at')->get();
                        $dishesMedias = array();
                        foreach($dishes as $dish){
                            $dishesMedias[] = $dish->media()->first();
                        }
                        $existingFiles = getMediaUrlForInputFile($dishesMedias, false);
                        $existingFilesConfig = \App\Models\Dish::getMediaConfigForInputFile($dishes, false);
                        $jsonResponse['inputData']['initialPreview'] = $existingFiles;
                        $jsonResponse['inputData']['initialPreviewConfig'] = $existingFilesConfig;
                        $jsonResponse['success'] = 1;
                    }
                    break;
                case 'add_daily_menu':
                    $dailyMenu = $establishment->dailyMenu()->first();
                    if(!checkModel($dailyMenu)){
                        $dailyMenu = \App\Models\Menu::create([
                            'id' => UuidTools::generateUuid(),
                            'name' => "Menu du jour",
                            'status' => \App\Models\Menu::STATUS_ACTIVE,
                            'id_establishment' => $establishment->getId(),
                            'is_daily_menu' => true,
                            'id_file' => 0
                        ]);
                    }

                    if (checkModel($dailyMenu)) {
                        $newMenuMedia = FileController::storeFile('new_daily_menu', \App\Models\Media::TYPE_USE_ETS_MENU, $dailyMenu, $dailyMenu->media()->first());
                        if(checkModel($newMenuMedia)){
                            $dailyMenu->setIdFile($newMenuMedia->getId())->save();
                        } else {
                            $dailyMenu->delete();
                        }
                        
                        $existingFiles = getMediaUrlForInputFile($newMenuMedia, false);
                        $existingFilesConfig = getMediaConfigForInputFile($newMenuMedia, false);
                        $jsonResponse['inputData']['initialPreview'] = $existingFiles;
                        $jsonResponse['inputData']['initialPreviewConfig'] = $existingFilesConfig;
                        $jsonResponse['success'] = 1;
                    }
                    break;
                case 'add_close_period':
                    $closeStartDate = new \DateTime($request->get('close_start'));
                    $closeEndDate = new \DateTime($request->get('close_end'));

                    $closePeriod = \App\Models\ClosePeriod::create([
                        'id' => UuidTools::generateUuid(),
                        'label' => $request->get('close_name'),
                        'start_date' => $closeStartDate->format('Y-m-d'),
                        'end_date' => $closeEndDate->format('Y-m-d'),
                        'id_establishment' => $establishment->getId()
                    ]);

                    if (checkModel($closePeriod)) {
                        $view = View::make('establishment.restaurant.feed.timetable-close')->with('establishment', $establishment)->with('reloaded', true);
                        $jsonResponse['content'] = $view->render();
                        $jsonResponse['success'] = 1;
                    }
                    break;
                case 'delete_close_period':
                    $uuidClosePeriod = $request->get('id_item');
                    $closePeriod = \App\Models\ClosePeriod::findUuid($uuidClosePeriod);
                    if(checkModel($closePeriod)){
                        $deleted = $closePeriod->delete();
                        if($deleted){
                            $view = View::make('establishment.restaurant.feed.timetable-close')->with('establishment', $establishment)->with('reloaded', true);
                            $jsonResponse['content'] = $view->render();
                            $jsonResponse['success'] = 1;
                        }
                    }
                    break;
                case 'add_employee':
                    $employee = \App\Models\Employee::create([
                        'id' => UuidTools::generateUuid(),
                        'firstname' => $request->get('new_employee_firstname'),
                        'lastname' => $request->get('new_employee_lastname'),
                        'id_job_type' => $request->get('job_type'),
                        'position' => $request->get('new_employee_position'),
                        'status' => \App\Models\Employee::STATUS_ACTIVE,
                        'id_establishment' => $establishment->getId(),
                        'id_photo' => 0
                    ]);

                    if (checkModel($employee)) {
                        $newEmployeeMedia = FileController::storeFile('new_employee', \App\Models\Media::TYPE_USE_ETS_EMPLOYEE, $employee);
                        if(checkModel($newEmployeeMedia)){
                            $employee->setIdPhoto($newEmployeeMedia->getId())->save();
                        } else {
                            $employee->delete();
                        }
                        
                        $employees = $establishment->employees()->orderBy('created_at')->get();
                        $employeesMedias = array();
                        foreach($employees as $employee){
                            $employeesMedias[] = $employee->media()->first();
                        }
                        $existingFiles = getMediaUrlForInputFile($employeesMedias, false);
                        $existingFilesConfig = \App\Models\Employee::getMediaConfigForInputFile($employees, false);
                        $jsonResponse['inputData']['initialPreview'] = $existingFiles;
                        $jsonResponse['inputData']['initialPreviewConfig'] = $existingFilesConfig;
                        $jsonResponse['success'] = 1;
                    }
                    break;
                case 'add_story':
                    $story = \App\Models\EstablishmentHistory::create([
                        'id' => UuidTools::generateUuid(),
                        'year' => $request->get('new_story_year'),
                        'title' => $request->get('new_story_title'),
                        'content' => $request->get('new_story_description'),
                        'id_establishment' => $establishment->getId(),
                        'id_photo' => 0
                    ]);

                    if (checkModel($story)) {
                        $newStoryMedia = FileController::storeFile('new_story', \App\Models\Media::TYPE_USE_ETS_STORY, $story);
                        if(checkModel($newStoryMedia)){
                            $story->setIdPhoto($newStoryMedia->getId())->save();
                        } else {
                            $story->delete();
                        }
                        
                        $stories = $establishment->stories()->orderBy('created_at')->get();
                        $storiesMedias = array();
                        foreach($stories as $story){
                            $storiesMedias[] = $story->media()->first();
                        }
                        $existingFiles = getMediaUrlForInputFile($storiesMedias, false);
                        $existingFilesConfig = \App\Models\EstablishmentHistory::getMediaConfigForInputFile($stories, false);
                        $jsonResponse['inputData']['initialPreview'] = $existingFiles;
                        $jsonResponse['inputData']['initialPreviewConfig'] = $existingFilesConfig;
                        $jsonResponse['success'] = 1;
                    }
                    break;
                case 'add_video':
                    if ($request->file('video')) {
                        $video = $establishment->video()->first();
                        $video = FileController::storeFile('video', \App\Models\Media::TYPE_USE_ETS_VIDEO, $establishment, $video);
                        if (checkModel($video)) {
                            $establishment->setIdVideo($video->getId());
                            $establishment->save();
                            
                            $existingFiles = getMediaUrlForInputFile($video, false);
                            $existingFilesConfig = getMediaConfigForInputFile($video, false);
                            $jsonResponse['inputData']['initialPreview'] = $existingFiles;
                            $jsonResponse['inputData']['initialPreviewConfig'] = $existingFilesConfig;
                            $jsonResponse['success'] = 1;
                        }
                    }
                    break;
            }
        } catch (Exception $e) {
            // TODO Report error in log system
            print_r($e->getMessage());

            foreach ($createdObjects as $createdObject) {
                if ($createdObject instanceof \Illuminate\Database\Eloquent\Model) {
                    $createdObject->delete();
                }
            }
        }
        
        $responsePrepared = $response->json($jsonResponse);
        return $responsePrepared;
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
                    if ((!empty($start) && !empty($end)) || ($dayOrder == 1 && $noBreak)) {
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
            $prefixCountries = DB::table(Country::TABLENAME)->whereIn('id', $prefixCountryIds)
                            ->select(['prefix', 'id'])->get();
            foreach ($prefixCountries as $countryData) {
                $prefixByIdCountry[$countryData->id] = $countryData->prefix;
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
                        'id_country' => $prefixCountryUuid,
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

    public static function buildThumbnailData(\Illuminate\Support\Collection $queryResultsCollection, $maxDistanceKm){
        $thumbnailData = array();
        foreach ($queryResultsCollection as $queryResult) {
            if ($queryResult->rawDistance <= $maxDistanceKm) {
                $uuid = UuidTools::getUuid($queryResult->id_establishment);
                // Search results list
                $etsUuids[] = $uuid;
                $thumbnailData[$uuid]['id'] = $uuid;
                $thumbnailData[$uuid]['name'] = $queryResult->name;
                if(empty($queryResult->logo_path)){
                    $thumbnailData[$uuid]['img'] = \App\Utilities\MediaTools::getRandomDsThumbnailPath();
                } else {
                    $thumbnailData[$uuid]['img'] = $queryResult->logo_path;
                }
                $thumbnailData[$uuid]['city'] = $queryResult->city;
                $thumbnailData[$uuid]['country'] = \App\Models\Country::getCountryLabel($queryResult->id_country);
//                    $dsSelectionEstablishments[$uuid]['biz_category_1'] = $establishmentData->name_biz_category_1;
                $thumbnailData[$uuid]['raw_distance'] = \App\Utilities\StringTools::displayCleanDistance($queryResult->rawDistance);
                $thumbnailData[$uuid]['latitude'] = $queryResult->latitude;
                $thumbnailData[$uuid]['longitude'] = $queryResult->longitude;
                $thumbnailData[$uuid]['url'] = Establishment::getUrlStatic($queryResult->id_business_type, $queryResult->city, 
                        $queryResult->slug, $queryResult->url_id);
                
                if(isset($queryResult->promo_name)){
                    $thumbnailData[$uuid]['promo_name'] = $queryResult->promo_name;
                }
            }
        }
        return $thumbnailData;
    } 
}
