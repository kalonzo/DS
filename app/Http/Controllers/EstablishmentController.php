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
use Illuminate\Support\Facades\Input;
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
        return $this->displayMiniWebsite($establishment, $page);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  Establishment $establishment
     * @return Response
     */    
    public function displayMiniWebsite(Establishment $establishment, $page = null) {
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
        $data['website'] = $establishment->getSiteUrl();
        
        $meta = array();
        $meta['title'] = "Dinerscope - ".$establishment->getName();

        switch ($page) {
            case 'menu':
                $data['menus'] = array();
                $data['daily_menu'] = array();
                $menusWithMedia = $establishment->menus(false)
                                            ->select([\App\Models\Menu::TABLENAME.'.*', \App\Models\EstablishmentMedia::TABLENAME.'.local_path'])
                                            ->join(\App\Models\EstablishmentMedia::TABLENAME, function ($join) {
                                                $join->on(\App\Models\EstablishmentMedia::TABLENAME.'.id', '=', \App\Models\Menu::TABLENAME.'.id_file')
                                                     ->where(\App\Models\EstablishmentMedia::TABLENAME.'.status', '=', \App\Models\EstablishmentMedia::STATUS_VALIDATED);
                                            })
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
                                            ->join(\App\Models\EstablishmentMedia::TABLENAME, function ($join) {
                                                $join->on(\App\Models\EstablishmentMedia::TABLENAME.'.id', '=', \App\Models\Dish::TABLENAME.'.id_photo')
                                                     ->where(\App\Models\EstablishmentMedia::TABLENAME.'.status', '=', \App\Models\EstablishmentMedia::STATUS_VALIDATED);
                                            })
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
                                    ->select([\App\Models\Gallery::TABLENAME.'.*',  \App\Models\EstablishmentMedia::TABLENAME.'.local_path as media_path', 
//                                                DB::raw('count('.\App\Models\Gallery::TABLENAME.'.id) as nbMedias'),
                                                DB::raw(DbQueryTools::genRawSqlForGettingUuid('id', \App\Models\Gallery::TABLENAME))])
                                    ->join(\App\Models\EstablishmentMedia::TABLENAME, function ($join) {
                                        $join->on(\App\Models\EstablishmentMedia::TABLENAME.'.id_gallery', '=', \App\Models\Gallery::TABLENAME.'.id')
                                             ->where(\App\Models\EstablishmentMedia::TABLENAME.'.status', '=', \App\Models\EstablishmentMedia::STATUS_VALIDATED);
                                    })
                                    ->orderBy(\App\Models\Gallery::TABLENAME.'.created_at')
//                                    ->groupBy(\App\Models\Gallery::TABLENAME.'.id')
                                    ->get();
                foreach ($galleriesData as $galleryData) {
                    if ($galleryData instanceof \App\Models\Gallery) {
                        $mediaPath = asset($galleryData->media_path);
                        if(!empty($mediaPath)){
                            if(!isset($data['galleries'][$galleryData->getUuid()])){
                                $data['galleries'][$galleryData->getUuid()] = array(
                                                    'id' => $galleryData->getUuid(),
                                                    'name' => $galleryData->getName(),
                                                    'nb_media' => 1,
                                                    'info' => 'todo', // '('.$galleryData->nbMedias.' '.__('photos').')',
                                                );
                            } else {
                                $data['galleries'][$galleryData->getUuid()]['nb_media']++;
                            }
                            $data['galleries'][$galleryData->getUuid()]['medias'][] = $mediaPath;
                        }
                    }
                }
                
                $data['last_pics'] = array();
                $lastMedias = \App\Models\EstablishmentMedia
                                    ::join(\App\Models\Gallery::TABLENAME, \App\Models\Gallery::TABLENAME.'.id', '=', 
                                            \App\Models\EstablishmentMedia::TABLENAME.'.id_gallery')
                                    ->select([\App\Models\EstablishmentMedia::TABLENAME.'.*'])
                                    ->where(\App\Models\EstablishmentMedia::TABLENAME.'.status', '=', \App\Models\EstablishmentMedia::STATUS_VALIDATED)
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
                                            ->join(\App\Models\EstablishmentMedia::TABLENAME, function ($join) {
                                                $join->on(\App\Models\EstablishmentMedia::TABLENAME.'.id', '=', \App\Models\Employee::TABLENAME.'.id_photo')
                                                     ->where(\App\Models\EstablishmentMedia::TABLENAME.'.status', '=', \App\Models\EstablishmentMedia::STATUS_VALIDATED);
                                            })
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
                
                $data['promo_events'] = array();
                $promosWithMedia = $establishment->promotions()
                                            ->select([\App\Models\Promotion::TABLENAME.'.*', \App\Models\EstablishmentMedia::TABLENAME.'.local_path'])
                                            ->leftJoin(\App\Models\EstablishmentMedia::TABLENAME, function ($join) {
                                                $join->on(\App\Models\EstablishmentMedia::TABLENAME.'.id_object_related', '=', \App\Models\Promotion::TABLENAME.'.id')
                                                     ->where(\App\Models\EstablishmentMedia::TABLENAME.'.status', '=', \App\Models\EstablishmentMedia::STATUS_VALIDATED);
                                            })
                                            ->whereRaw(\App\Models\Promotion::TABLENAME.'.end_date > NOW()')
                                            ->orderBy(\App\Models\Promotion::TABLENAME.'.start_date')
                                            ->get();
                foreach ($promosWithMedia as $promoWithMedia) {
                    if ($promoWithMedia instanceof \App\Models\Promotion) {
                        $promoData = array(
                                            'type' => 'promo',
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
                        $data['promo_events'][] = $promoData;
                    }
                }
                $eventsWithMedia = $establishment->events()
                                            ->select([\App\Models\Event::TABLENAME.'.*', \App\Models\EstablishmentMedia::TABLENAME.'.local_path'])
                                            ->leftJoin(\App\Models\EstablishmentMedia::TABLENAME, function ($join) {
                                                $join->on(\App\Models\EstablishmentMedia::TABLENAME.'.id_object_related', '=', \App\Models\Event::TABLENAME.'.id')
                                                     ->where(\App\Models\EstablishmentMedia::TABLENAME.'.status', '=', \App\Models\EstablishmentMedia::STATUS_VALIDATED);
                                            })
                                            ->whereRaw(\App\Models\Event::TABLENAME.'.end_date > NOW()')
                                            ->orderBy(\App\Models\Event::TABLENAME.'.start_date')
                                            ->get();
                foreach ($eventsWithMedia as $eventWithMedia) {
                    if ($eventWithMedia instanceof \App\Models\Event) {
                        $eventData = array(
                                            'type' => 'event',
                                            'name' => $eventWithMedia->getName(),
                                            'description' => $eventWithMedia->getDescription(),
                                            'start_date' => $eventWithMedia->getStartDate(),
                                            'end_date' => $eventWithMedia->getEndDate(),
                                            'start_timestp' => DateTools::getStringTimestpFromDate($eventWithMedia->getStartDate()),
                                            'end_timestp' => DateTools::getStringTimestpFromDate($eventWithMedia->getEndDate()),
                                        );
                        if(!empty($eventWithMedia->local_path)){
                            $eventData['picture'] = asset($eventWithMedia->local_path);
                        }
                        $data['promo_events'][] = $eventData;
                    }
                }
                
                $data['story'] = array();
                $storiesWithMedia = $establishment->stories()
                                            ->select([\App\Models\EstablishmentHistory::TABLENAME.'.*', \App\Models\EstablishmentMedia::TABLENAME.'.local_path'])
                                            ->join(\App\Models\EstablishmentMedia::TABLENAME, function ($join) {
                                                $join->on(\App\Models\EstablishmentMedia::TABLENAME.'.id', '=', \App\Models\EstablishmentHistory::TABLENAME.'.id_photo')
                                                     ->where(\App\Models\EstablishmentMedia::TABLENAME.'.status', '=', \App\Models\EstablishmentMedia::STATUS_VALIDATED);
                                            })
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
                ->with('footerHidden', true)->with('meta', $meta);

        return $view;
    }
    
    public function showAjax(Request $request, Establishment $establishment, $page = null){
        $response = response();
        $jsonResponse = array('success' => 0);
        
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
                            $medias = $gallery->medias()->where('status', '=', \App\Models\Media::STATUS_VALIDATED)->get();
                            
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
        $response = response();
        $jsonResponse = array('triggerMode' => 1, 'success' => 0);
        
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
                    $address = $establishment->address()->first();
                    if (!checkModel($address)) {
                        $address = Address::create([
                            'id' => \App\Utilities\UuidTools::generateUuid(),
                            'geocoded' => $request->get('address.geocoded') ? 1 : 0,
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
                            'id_object_related' => $establishment->getId(),
                            'type_object_related' => Establishment::TYPE_GLOBAL_OBJECT,
                        ]);
                    } else {
                        // Update establishment address
                        $address->update([
                            'geocoded' => $request->get('address.geocoded') ? 1 : 0,
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
                    }

                    if(checkModel($address)){
                        // Update establishment
                        $establishmentStatus = $establishment->getStatus();
                        switch($establishmentStatus){
                            case Establishment::STATUS_INCOMPLETE:
                            case Establishment::STATUS_TO_LOCALIZE:
                                $establishmentStatus = Establishment::STATUS_TO_VALID;
                                break;
                        }
                        $establishment->update([
                            'status' => $establishmentStatus,
                            'name' => $request->get('name'),
                            'latitude' => $request->get('latitude'),
                            'longitude' => $request->get('longitude'),
                            'email' => $request->get('email'),
                            'site_url' => $request->get('site_url'),
                            'description' => htmlspecialchars($request->get('description'), ENT_QUOTES),
                            'id_location_index' => $idLocation,
                            'average_price_min' => $request->get('average_price_min'),
                            'average_price_max' => $request->get('average_price_max'),
                            'accept_booking' => $request->get('accept_booking'),
                            'id_address' => $address->getId(),
                            'background_color' => $request->get('background_color'),
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
                            /*
                            if ($request->file('logo')) {
                                $logo = $establishment->logo()->first();
                                $logo = FileController::storeFile('logo', \App\Models\Media::TYPE_USE_ETS_LOGO, $establishment, $logo);
                                if (checkModel($logo)) {
                                    $establishment->setIdLogo($logo->getId());
                                    $establishment->save();
                                }
                            }
                             * 
                             */
                            if ($request->file('home_pictures')) {
                                $homePictures = FileController::storeFileMultiple('home_pictures', \App\Models\Media::TYPE_USE_ETS_HOME_PICS, $establishment);
                            }
                            $establishment->calculateBusinessStatus();
                            $jsonResponse['success'] = 1;
                        } else {
                            $jsonResponse['error'] = "L'établissement n'a pu être enregistré.";
                        }
                    } else {
                        $jsonResponse['error'] = "L'adresse de l'établissement n'a pu être enregistrée.";
                    }
                } else {
                    $jsonResponse['error'] = "L'index géographique n'a pu être enregistré.";
                }
            } else {
                $jsonResponse['error'] = "L'établissement est inconnu.";
            }
        } catch (Exception $e) {
            // TODO Report error in log system
            $jsonResponse['error'] = $e->getMessage();

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
     * @param \App\Http\Requests\StoreBooking $request
     * @param Establishment $establishment
     */
    public function createBooking(\App\Http\Requests\StoreBooking $request, Establishment $establishment) {
        $response = response();
        $jsonResponse = array('success' => 0);
        
        $createAccount = $request->get('create_account');
        $user = \Illuminate\Support\Facades\Auth::user();
        if(!checkModel($user)){
            $user = User::where('email', $request->get('email'))->first();
            $password = null;
            if($createAccount){
                $password = bcrypt($request->get('password'));
            }
            if (checkModel($user)) {
                if($createAccount){
                    $user->update([
                        'firstname' => $request->get('firstname'),
                        'lastname' => $request->get('lastname'),
                        'type' => User::TYPE_USER,
                        'status' => User::STATUS_CREATED,
                        'password' => $password,
                    ]);
                }
            } else {
                // Create user
                $typeUser = User::TYPE_USER_AUTO_INSERTED;
                if($createAccount){
                    $typeUser = User::TYPE_USER;
                }
                $user = User::create([
                            'id' => \App\Utilities\UuidTools::generateUuid(),
                            'name' => $request->get('email'),
                            'firstname' => $request->get('firstname'),
                            'lastname' => $request->get('lastname'),
                            'type' => $typeUser,
                            'status' => User::STATUS_CREATED,
                            'password' => $password,
                            'email' => $request->get('email'),
                            'gender' => 0,
                            'id_address' => 0,
                            'id_inbox' => 0,
                            'id_company' => 0,
                ]);
            }
        }
        
        if (checkModel($user)) {
            $time = $request->get('time_reservation');
            $date = new \DateTime(str_replace('/', '-', $request->get('datetime_reservation')).' '.$time);
            $prefixCountry = DB::table(Country::TABLENAME)->where('id', '=', $request->get('prefix'))
                            ->select(['prefix', 'iso', 'id'])->first();
            $fullPhoneNumber = $request->get('phone_number');
            if(checkModel($prefixCountry)){
                $fullPhoneNumber = formatPhone($prefixCountry->prefix, $request->get('phone_number'), $prefixCountry->iso);
                
                if(!$user->callNumbers()->exists()){
                    CallNumber::create([
                            'id' => UuidTools::generateUuid(),
                            'main' => true,
                            'label' => "Téléphone",
                            'type' => CallNumber::TYPE_PHONE_CONTACT,
                            'prefix' => $request->get('prefix'),
                            'id_country' => $prefixCountry->id,
                            'number' => $request->get('phone_number'),
                            'id_object_related' => $user->getId(),
                            'type_object_related' => User::TYPE_GLOBAL_OBJECT,
                    ]);
                }
            }
            
            $guestsEmails = null;
            if(!empty($request->get('invited_emails'))){
                $guestsEmailArray = array();
                $invitedEmails = explode(',', $request->get('invited_emails'));
                foreach($invitedEmails as $i => $invitedEmail){
                    $guestsEmailArray[] = trim($invitedEmail);
                }
                $guestsEmails = implode(',', $guestsEmailArray);
            }
            
            $bookingStatus = \App\Models\Booking::STATUS_PENDING;
            $booking = \App\Models\Booking::create([
                        'id' => \App\Utilities\UuidTools::generateUuid(),
                        'status' => $bookingStatus,
                        'lastname' => $request->get('lastname'),
                        'firstname' => $request->get('firstname'),
                        'email' => $request->get('email'),
                        'phone_number' => $fullPhoneNumber,
                        'datetime_reservation' => $date->format('Y-m-d H:i'),
                        'comment' => $request->get('comment'),
                        'guests' => $guestsEmails,
                        'guests_message' => $request->get('message'),
                        'guests_email_cc' => $request->get('copy_invitation'),
                        'nb_adults' => $request->get('nb_adults'),
                        'id_user' => $user->getId(),
                        'id_establishment' => $establishment->getId(),
            ]);

            if(checkModel($booking)){
                $jsonResponse['success'] = 1;
                \Illuminate\Support\Facades\Request::session()->flash('status', 
                    "Votre demande de réservation a bien été prise en compte. Vous, et vos éventuels invités, recevrez sous peu un email vous "
                    . " indiquant si le restaurateur peut répondre favorablement ou non à votre demande."
                );
                // Notify user
                $token = null;
                if($user->getStatus() !== User::STATUS_ACTIVE){
                    \App\RegistrationToken::deleteCode($user->getId());
                    $token = \App\RegistrationToken::makeToken($user->getEmail());
                }
                // Notify user pro
                $etsOwner = $establishment->userOwner()->first();
                if(checkModel($etsOwner)){
                    $user->notify(new \App\Notifications\BookingCreatedUser($user, $booking, $establishment, $token));
                    $etsOwner->notify(new \App\Notifications\BookingCreatedPro($user, $booking, $establishment));
                }
            }
        }
        
        if($jsonResponse['success'] !== 1){
            \Illuminate\Support\Facades\Request::session()->flash('errors', 
                        "Votre demande de réservation n'a pu aboutir. Veuillez réessayer ou prendre directement contact avec nos équipes."
                    );
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
                        $today = new \DateTime();
                        $today->setTime(12, 0, 0);
                        
                        $selectedDay = new \DateTime(str_replace('/', '-', $date));
                        $selectedDay->setTime(12, 0, 0);
                        $dayIndex = $selectedDay->format('N');

                        $timeslots = array();
                        $diff = $today->diff($selectedDay);
                        if($diff->days === 0 || $diff->invert === 0){
                            // Invert = 0 if selectedDay is up to come, Days = 0 if selectedDay is today
                            $closePeriods = $establishment->closePeriods()->whereRaw('start_date <= NOW()')->whereRaw('end_date >= NOW()')->count();
                            if($closePeriods === 0){
                                $openingHours = $establishment->openingHours()->where('day', '=', $dayIndex)->where('closed', '=', 0)
                                        ->whereNull('start_date')->orWhereRaw('start_date <= NOW()')
                                        ->whereNull('end_date')->orWhereRaw('end_date >= NOW()')
                                        ->orderBy('day')->orderBy('day_order')->orderBy('start_time')
                                        ->get();
                                foreach($openingHours as $openingHour){
                                    $timeslots[$openingHour->getUuid()][$openingHour->getDayOrder()]['start'] = $openingHour->getStartTime();
                                    $timeslots[$openingHour->getUuid()][$openingHour->getDayOrder()]['end'] = $openingHour->getEndTime();
                                    $timeslots[$openingHour->getUuid()][$openingHour->getDayOrder()]['no_break'] = $openingHour->getNoBreak();
                                }
                            }
                        }
                        $formData = ['time_slots' => $timeslots, 'today' => $diff->days === 0];
                        $view = View::make('establishment.restaurant.booking.booking-hours')->with('form_data', $formData);
                        $jsonResponse['content'] = $view->render();
                        $jsonResponse['success'] = 1;
                    } else {
                        $jsonResponse['error'] = "Les horaires n'ont pas pu être trouvés.";
                    }
                break;
            }
        } catch (Exception $e) {
            // TODO Report error in log system
            $jsonResponse['error'] = $e->getMessage();

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
        $response = response();
        $jsonResponse = array('relocateMode' => 1, 'success' => 0);
        
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
                            'geocoded' => $request->get('address.geocoded') ? 1 : 0,
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

                    // Create establishment
                    $establishment = Establishment::create([
                                'id' => $idEstablishment,
                                'name' => $request->get('name'),
                                'latitude' => $request->get('latitude'),
                                'longitude' => $request->get('longitude'),
                                'status' => Establishment::STATUS_TO_VALID,
                                'email' => $request->get('email'),
                                'site_url' => $request->get('site_url'),
                                'description' => htmlspecialchars($request->get('description'), ENT_QUOTES),
                                'id_location_index' => $idLocation,
                                'average_price_min' => $request->get('average_price_min'),
                                'average_price_max' => $request->get('average_price_max'),
                                'id_user_owner' => 0,
                                'id_address' => $address->getId(),
                                'id_business_type' => \App\Models\BusinessType::TYPE_BUSINESS_RESTAURANT,
                                'accept_booking' => $request->get('accept_booking'),
                                'background_color' => $request->get('background_color'),
                                'id_logo' => 0
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

                        $establishment->calculateBusinessStatus();

                        $jsonResponse['success'] = 1;
                        $jsonResponse['relocateMode'] = 1;
                        $jsonResponse['location'] = '/edit/establishment/'.$establishment->getUuid();
                    } else {
                        $jsonResponse['error'] = "L'établissement n'a pu être enregistré.";
                    }
                } else {
                    $jsonResponse['error'] = "L'adresse de l'établissement n'a pu être enregistrée.";
                }
            } else {
                $jsonResponse['error'] = "L'index géographique n'a pu être enregistré.";
            }
        } catch (Exception $e) {
            // TODO Report error in log system
            $jsonResponse['error'] = $e->getMessage();
            foreach ($createdObjects as $createdObject) {
                if ($createdObject instanceof \Illuminate\Database\Eloquent\Model) {
                    $createdObject->delete();
                }
            }
        }
        
        $responsePrepared = $response->json($jsonResponse);
        return $responsePrepared;
    }
    
    public function validateEstablishment(Establishment $establishment){
        $response = response();
        $jsonResponse = array('triggerMode' => 1,'success' => 0);
        
        if($establishment->getStatus() !== Establishment::STATUS_ACTIVE){
            if($establishment->getBusinessStatus() >= 50){
                $establishment->setStatus(Establishment::STATUS_ACTIVE);
                $establishment->calculateBusinessStatus();
                $jsonResponse['success'] = 1;
            } else {
                $jsonResponse['error'] = "Les informations de l'établissement sont insuffisantes pour procéder à sa validation.";
            }
        } else {
            $jsonResponse['error'] = "L'établissement a déjà été validé.";
        }
        
        $responsePrepared = $response->json($jsonResponse);
        return $responsePrepared;
    }
    
    public function unvalidateEstablishment(Establishment $establishment){
        $response = response();
        $jsonResponse = array('triggerMode' => 1,'success' => 0);
        
        if($establishment->getStatus() !== Establishment::STATUS_TO_VALID){
            $establishment->setStatus(Establishment::STATUS_TO_VALID);
            $establishment->calculateBusinessStatus();
            $jsonResponse['success'] = 1;
        } else {
            $jsonResponse['error'] = "L'établissement est déjà non-validé.";
        }
        
        $responsePrepared = $response->json($jsonResponse);
        return $responsePrepared;
    }
    
    public function preview(Establishment $establishment, $page = null){
        $user = \Illuminate\Support\Facades\Auth::user();
        if($establishment->getBusinessStatus() >= 50 && ($user->getType() === User::TYPE_USER_PRO || $user->getType() === User::TYPE_USER_ADMIN_PRO)){
            return $this->displayMiniWebsite($establishment, $page)->with('preview', true);
        }
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
            $openingHours = $establishment->openingHours()->where('day', '=', $dayIndex)->where('closed', '=', 0)
                    ->whereNull('start_date')->orWhereRaw('start_date <= NOW()')
                    ->whereNull('end_date')->orWhereRaw('end_date >= NOW()')
                    ->orderBy('day')->orderBy('day_order')->orderBy('start_time')
                    ->get();
            foreach($openingHours as $openingHour){
                $timeslots[$openingHour->getUuid()][$openingHour->getDayOrder()]['start'] = $openingHour->getStartTime();
                $timeslots[$openingHour->getUuid()][$openingHour->getDayOrder()]['end'] = $openingHour->getEndTime();
                $timeslots[$openingHour->getUuid()][$openingHour->getDayOrder()]['no_break'] = $openingHour->getNoBreak();
            }
        }
        
        $idCountry = Country::where('iso', '=', GeolocationController::getLocaleCountry())->first()->getId();
        StorageHelper::getInstance()->add('show_establishment.form_data.id_country', $idCountry);
        StorageHelper::getInstance()->add('show_establishment.form_data.country_prefixes', $countryPrefixes);
        StorageHelper::getInstance()->add('show_establishment.form_data.time_slots', $timeslots);
        StorageHelper::getInstance()->add('show_establishment.form_data.today', true);
        StorageHelper::getInstance()->add('show_establishment.form_data.datetime_reservation', $datetimeReservation);
    }
    /**
     * 
     * @param Establishment $establishment
     */
    public function buildCreateFormValues() {
        $idCountry = Country::where('iso', '=', GeolocationController::getLocaleCountry())->first()->getId();
        $idCurrency = \App\Utilities\CurrencyTools::getIdCurrencyFromLocale();
        StorageHelper::getInstance()->add('feed_establishment.form_values.id_country', $idCountry);
        StorageHelper::getInstance()->add('feed_establishment.form_values.id_currency', $idCurrency);
        StorageHelper::getInstance()->add('feed_establishment.form_values.allow_booking', false);
    }

    /**
     * 
     * @param Establishment $establishment
     */
    public function buildEditFormValues(Establishment $establishment) {
        // Default ID country
        $idCountry = 0;
        $address = $establishment->address()->first();
        if(checkModel($address)){
            $idCountry = $address->getIdCountry();
        }
        
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
        
        $allowBooking = false;
        if($establishment->userOwner()->where('status', '=', User::STATUS_ACTIVE)->exists()){
            $allowBooking = true;
        }
        
        StorageHelper::getInstance()->add('feed_establishment.form_values.id_country', $idCountry);
        StorageHelper::getInstance()->add('feed_establishment.form_values.id_currency', $idCurrency);
        StorageHelper::getInstance()->add('feed_establishment.form_values.call_numbers', $callNumbersData);
        StorageHelper::getInstance()->add('feed_establishment.form_values.business_categories', $businessCategoryIds);
        StorageHelper::getInstance()->add('feed_establishment.form_values.opening_hours', $openingHours);
        StorageHelper::getInstance()->add('feed_establishment.form_values.allow_booking', $allowBooking);
    }

    public function ajax(StoreEstablishment $request, Establishment $establishment) {
        $response = response();
        $jsonResponse = array('success' => 0);
        $createdObjects = array();
        $jsonResponse['inputData']['previewRequest'] = $request->get('id_gallery');
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
                            $gallery = \App\Models\Gallery::findUuid($uuidGallery);
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
                case 'add_thumbnail':
                    if ($request->file('thumbnail')) {
                        $thumbnail = $establishment->thumbnail()->first();
                        $thumbnail = FileController::storeFile('thumbnail', \App\Models\Media::TYPE_USE_ETS_THUMBNAIL, $establishment, $thumbnail);
                        if (checkModel($thumbnail)) {
                            $establishment->setIdThumbnail($thumbnail->getId());
                            $establishment->save();
                            
                            $existingFiles = getMediaUrlForInputFile($thumbnail, false);
                            $existingFilesConfig = getMediaConfigForInputFile($thumbnail, false);
                            $jsonResponse['inputData']['initialPreview'] = $existingFiles;
                            $jsonResponse['inputData']['initialPreviewConfig'] = $existingFilesConfig;
                            $jsonResponse['success'] = 1;
                        }
                    }
                    break;
                case 'add_logo':
                    if ($request->file('logo')) {
                        $logo = $establishment->logo()->first();
                        $logo = FileController::storeFile('logo', \App\Models\Media::TYPE_USE_ETS_LOGO, $establishment, $logo);
                        if (checkModel($logo)) {
                            $establishment->setIdLogo($logo->getId());
                            $establishment->save();
                            
                            $existingFiles = getMediaUrlForInputFile($logo, false);
                            $existingFilesConfig = getMediaConfigForInputFile($logo, false);
                            $jsonResponse['inputData']['initialPreview'] = $existingFiles;
                            $jsonResponse['inputData']['initialPreviewConfig'] = $existingFilesConfig;
                            $jsonResponse['success'] = 1;
                        }
                    }
                    break;
                case 'add_home_pictures':
                    $filesToUpload = $request->allFiles();
                    if(isset($filesToUpload['home_pictures']) && !empty($filesToUpload['home_pictures'])){
                        foreach($filesToUpload['home_pictures'] as $uploadedFiles){
                            $homePictures = FileController::storeFileMultiple('home_pictures', \App\Models\Media::TYPE_USE_ETS_HOME_PICS, $establishment);
                            
                            $medias = $establishment->homePictures()->get();
                            $existingFiles = getMediaUrlForInputFile($medias, false);
                            $existingFilesConfig = getMediaConfigForInputFile($medias, false);

                            $jsonResponse['success'] = 1;
                            $jsonResponse['inputData']['initialPreview'] = $existingFiles;
                            $jsonResponse['inputData']['initialPreviewConfig'] = $existingFilesConfig;
                        }
                    }
                    break;
            }
        } catch (Exception $e) {
            // TODO Report error in log system
            $jsonResponse['error'] = $e->getMessage();
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
                        if($dayOrder == 1 && $noBreak){
                            $pmHoursForNonStopDay = $etsOpeningHours->where('day', $day)->where('day_order', 2)->first();
                            if(checkModel($pmHoursForNonStopDay)){
                                $pmHoursForNonStopDay->delete();
                            }
                        }
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
                            if($start > $end){
                                $attributes['overnight'] = 1;
                            }
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
                        'id_object_related' => $establishment->getId(),
                        'type_object_related' => Establishment::TYPE_GLOBAL_OBJECT,
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
//        print_r($queryResultsCollection);
        $thumbnailData = array();
        foreach ($queryResultsCollection as $queryResult) {
            if ($queryResult->rawDistance <= $maxDistanceKm) {
                $uuid = UuidTools::getUuid($queryResult->id_establishment);
                // Search results list
                $thumbnailData[$uuid]['id'] = $uuid;
                $thumbnailData[$uuid]['name'] = $queryResult->name;
                $thumbnailData[$uuid]['logo_img'] = $queryResult->logo_path;
                if(isset($queryResult->thumbnail_path) && !empty($queryResult->thumbnail_path)){
                    $thumbnailData[$uuid]['thumbnail_img'] = $queryResult->thumbnail_path;
                }
                $thumbnailData[$uuid]['background_color'] = $queryResult->background_color;
                $thumbnailData[$uuid]['city'] = $queryResult->city;
                $thumbnailData[$uuid]['country'] = \App\Models\Country::getCountryLabel($queryResult->id_country);
                $thumbnailData[$uuid]['full_address'] = Address::getDisplayableStatic($queryResult->street_number, $queryResult->street, 
                                                        $queryResult->address_additional, $queryResult->postal_code, $queryResult->city, '<br/>');
                $thumbnailData[$uuid]['raw_distance'] = \App\Utilities\StringTools::displayCleanDistance($queryResult->rawDistance);
                $thumbnailData[$uuid]['latitude'] = $queryResult->latitude;
                $thumbnailData[$uuid]['longitude'] = $queryResult->longitude;
                if($queryResult->status == Establishment::STATUS_ACTIVE){
                    $thumbnailData[$uuid]['url'] = Establishment::getUrlStatic($queryResult->id_business_type, $queryResult->city, 
                            $queryResult->slug, $queryResult->url_id);
                }
                
                if(isset($queryResult->promo_name)){
                    $thumbnailData[$uuid]['promo_name'] = $queryResult->promo_name;
                }
            }
        }
        return $thumbnailData;
    } 
    
    /**
     * 
     * @param type $thumbnailDataList
     * @param type $etsUuidList
     * @return type
     */
    public static function buildExtraThumbnailData($thumbnailDataList, $etsUuidList){
        if(!empty($thumbnailDataList)){
            $timezoneByCountryIso = array();
            $countryIsoByEtsUuid = array();
            $etsCountriesData = \App\Models\Country::select([
                                                            \App\Models\Country::TABLENAME . '.iso', 
                                                            \App\Models\Country::TABLENAME . '.label', 
                                                            Address::TABLENAME . '.city', 
                                                            Address::TABLENAME . '.region', 
                                                            Establishment::TABLENAME . '.id',
                                                            DB::raw(DbQueryTools::genRawSqlForGettingUuid('id', Establishment::TABLENAME))
                        ])
                        ->join(Address::TABLENAME, \App\Models\Country::TABLENAME . '.id', '=', Address::TABLENAME . '.id_country')
                        ->join(Establishment::TABLENAME, Establishment::TABLENAME . '.id_address', '=', Address::TABLENAME . '.id')
                        ->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id', $etsUuidList, Establishment::TABLENAME))
                        ->get();
            foreach($etsCountriesData as $etsCountryData){
                $uuidEstablishment = $etsCountryData->uuid;

                $countryIsoByEtsUuid[$uuidEstablishment] = $etsCountryData->iso;
                if(!isset($timezoneByCountryIso[$etsCountryData->iso])){
                    $timezoneByCountryIso[$etsCountryData->iso] = \App\Utilities\GeolocTools::getTimezoneFromCountryIso($etsCountryData->iso);
                }

                foreach($thumbnailDataList as $key => $thumbnailData){
                    if(isset($thumbnailData[$uuidEstablishment]) && !isset($thumbnailData[$uuidEstablishment]['country_iso'])){
                        $thumbnailDataList[$key][$uuidEstablishment]['country_iso'] = $etsCountryData->iso;
                    }
                }
            }

            // Opening hours
            $closePeriods = \App\Models\ClosePeriod::select([
                                \App\Models\ClosePeriod::TABLENAME.'.*',
                                DB::raw(DbQueryTools::genRawSqlForGettingUuid('id_establishment', \App\Models\ClosePeriod::TABLENAME, 'uuid_ets'))
                            ])
                            ->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id_establishment', $etsUuidList, \App\Models\ClosePeriod::TABLENAME))
                            ->whereRaw('start_date <= NOW()')
                            ->whereRaw('end_date >= NOW()')
                            ->get();

            // Collect close periods indexed by establishment
            $closedPeriodsByEts = array();
            foreach($closePeriods as $closePeriod){
                $closedPeriodsByEts[$closePeriod->uuid_ets] = $closePeriod;
            }

            $openingHours = \App\Models\OpeningHour::select([
                        \App\Models\OpeningHour::TABLENAME.'.*',
                        DB::raw(DbQueryTools::genRawSqlForGettingUuid('id_establishment'))
                    ])
                    ->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id_establishment', $etsUuidList, \App\Models\OpeningHour::TABLENAME))
                    ->whereNull('start_date')->orWhereRaw('start_date <= NOW()')
                    ->whereNull('end_date')->orWhereRaw('end_date >= NOW()')
                    ->orderBy('id_establishment')->orderBy('day')->orderBy('day_order')->orderBy('start_time')
                    ->get();

            // Collect opening hours indexed by establishment
            $openingByEts = array();
            foreach($openingHours as $openingHour){
                $uuidEts = $openingHour->uuid;
                $openDayIndex = $openingHour->day;
                $openingByEts[$uuidEts][$openDayIndex][] = $openingHour;
            }

            $today = new \DateTime();
            $dayIndex = $today->format('N');
            $previousDayIndex = $dayIndex -1;
            if($previousDayIndex === 0){
                $previousDayIndex = 7;
            }
            $etsOpeningInfo = array();
            foreach($openingByEts as $uuidEts => $openingHoursByDays){
                $checkPreviousDayOvernight = false;
                $deferedOpening = false;
                $deferedDayIndex = 0;
                $deferedDate = 0;

                // Current day in close period
                if(isset($closedPeriodsByEts[$uuidEts])){
                    $closePeriod = $closedPeriodsByEts[$uuidEts];
                    $endClosing = new \DateTime($closePeriod->getEndDate());
                    // Alter current day index to search from the reopening day index
                    $dayIndex = $endClosing->format('N');
                    $deferedDayIndex = $endClosing->format('N');
                    $deferedDate = $endClosing;
                    $deferedOpening = true;
                } else {
                    // Reset current day index
                    $dayIndex = $today->format('N');
                }

                // Get the right time from the establishment timezone
                $timeNow = $today->format('Hi');
                if(isset($countryIsoByEtsUuid[$uuidEts])){
                    $iso = $countryIsoByEtsUuid[$uuidEts];
                    if(isset($timezoneByCountryIso[$iso])){
                        $timezone = $timezoneByCountryIso[$iso];
                        $dtz = new \DateTimeZone($timezone);
                        $today->setTimezone($dtz);
                        $timeNow = $today->format('Hi');
                    }
                }

                $dayLoop = 0;
                $opened = false;
                $findOpenSlot = false;
                $openDayIndex = 0;
                $timeslots = array();
                // Browse establishment opening hours to find the closest opening from the 7 coming days
                while($dayLoop < 7 && !$findOpenSlot){
                    $cursorDayIndex = $dayIndex + $dayLoop;
                    // Manage day index overflow
                    if($cursorDayIndex > 7){
                        $cursorDayIndex = 1;
                    }

                    if(!$deferedOpening && !$checkPreviousDayOvernight && isset($openingHoursByDays[$previousDayIndex])){
                        // Check for previous day overnight opening
                        $checkPreviousDayOvernight = true;
                        $openingHours = $openingHoursByDays[$previousDayIndex];
                        foreach($openingHours as $openingHour){
                            if(!$openingHour->getClosed() && $openingHour->getOvernight()){
                                $start = str_replace(':', '', $openingHour->start_time) / 100;
                                $end = str_replace(':', '', $openingHour->end_time) / 100;
                                if($timeNow < 1200 && $end > $timeNow){
                                    // Found opening now
                                    $opened = true;
                                    $findOpenSlot = true;
                                    $openDayIndex = $dayIndex;
                                    $timeslots[] = $openingHour;
                                }
                            }
                        }
                    } else {
                        if(isset($openingHoursByDays[$cursorDayIndex])){
                            $openingHours = $openingHoursByDays[$cursorDayIndex];
                            if(!$deferedOpening && $cursorDayIndex == $dayIndex){
                                // Opening hours found on the current day index 
                                foreach($openingHours as $openingHour){
                                    if(!$openingHour->getClosed()){
                                        $start = str_replace(':', '', $openingHour->start_time) / 100;
                                        $end = str_replace(':', '', $openingHour->end_time) / 100;
                                        $overnight = $openingHour->getOvernight();
                                        $overnightEnd = $end + 2400;
                                        if($end > $timeNow || ($overnight && $overnightEnd > $timeNow)){
                                            // Found opening today
                                            if($timeNow >= $start){
                                                // Found opening now
                                                $opened = true;
                                                $findOpenSlot = true;
                                                $openDayIndex = $cursorDayIndex;
                                                $timeslots[] = $openingHour;
                                            } else {
                                                // Found opening later in the day
                                                $findOpenSlot = true;
                                                $openDayIndex = $cursorDayIndex;
                                                $timeslots[] = $openingHour;
                                            }
                                        }
                                    }
                                }
                            } else {
                                // Opening hours found on the following days
                                foreach($openingHours as $openingHour){
                                    if(!$openingHour->getClosed()){
                                        // Found opening later in the week
                                        $findOpenSlot = true;
                                        $openDayIndex = $cursorDayIndex;
                                        $timeslots[] = $openingHour;
                                    }
                                }
                            }
                        }
                        $dayLoop++;
                    }
                }
                if($deferedOpening){
                    // Close period for now
                    $daysFromReopening = 0;
                    if($openDayIndex < $deferedDayIndex){
                        $daysFromReopening = 7 + ($openDayIndex - $deferedDayIndex);
                    } else {
                        $daysFromReopening = $openDayIndex - $deferedDayIndex;
                    }
                    $reopeningDate = date_add($deferedDate, new \DateInterval('P'.$daysFromReopening.'D'));
                    $etsOpeningInfo[$uuidEts]['defered_date'] = formatDate($reopeningDate, \IntlDateFormatter::MEDIUM);
                }
                $etsOpeningInfo[$uuidEts]['day_index'] = $openDayIndex;
                $etsOpeningInfo[$uuidEts]['opened'] = $opened;
                if(!empty($timeslots)){
                    // Collect next opening timeslots
                    foreach($timeslots as $timeslot){
                        $time = date('H:i', strtotime($timeslot->getStartTime())) . ' - ' . date('H:i', strtotime($timeslot->getEndTime()));
                        $etsOpeningInfo[$uuidEts]['timeslots'][] = $time;
                    }
                }
            }

            foreach($etsOpeningInfo as $uuidEstablishment => $openingInfo){
                foreach($thumbnailDataList as $key => $thumbnailData){
                    if(isset($thumbnailData[$uuidEstablishment]) && !isset($thumbnailData[$uuidEstablishment]['opening_info'])){
                        $thumbnailDataList[$key][$uuidEstablishment]['opening_info'] = $openingInfo;
                    }
                }
            }
            
            // Collect promo information
            $etsPromotions = array();
            $promotions = \App\Models\Promotion::select([
                        \App\Models\Promotion::TABLENAME.'.*',
                        DB::raw(DbQueryTools::genRawSqlForGettingUuid('id_establishment', \App\Models\Promotion::TABLENAME, 'ets_uuid'))
                    ])
                    ->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id_establishment', $etsUuidList, \App\Models\Promotion::TABLENAME))
                    ->whereRaw('end_date >= NOW()')->whereRaw('start_date <= NOW()')
                    ->orderBy('id_establishment')->orderBy('start_date')->orderBy('end_date')
                    ->get();
            foreach($promotions as $promotion){
                if(!isset($etsPromotions[$promotion->ets_uuid])){
                    $etsPromotions[$promotion->ets_uuid]['count'] = 1;
                    $etsPromotions[$promotion->ets_uuid]['label'] = $promotion->name;
                } else {
                    $etsPromotions[$promotion->ets_uuid]['count']++;
                }
            }
            foreach($etsPromotions as $uuidEstablishment => $promoInfo){
                foreach($thumbnailDataList as $key => $thumbnailData){
                    if(isset($thumbnailData[$uuidEstablishment]) && !isset($thumbnailData[$uuidEstablishment]['promo'])){
                        $thumbnailDataList[$key][$uuidEstablishment]['promo'] = $promoInfo;
                    }
                }
            }
        }
        return $thumbnailDataList;
    }
}
