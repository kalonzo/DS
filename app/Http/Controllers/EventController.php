<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvent;
use App\Models\Address;
use App\Models\Establishment;
use App\Models\Event;
use App\Models\EventType;
use App\Models\Media;
use App\Models\Promotion;
use App\Models\Utilities\LatLng;
use App\Utilities\DbQueryTools;
use App\Utilities\StorageHelper;
use App\Utilities\StringTools;
use App\Utilities\StyleTools;
use App\Utilities\UuidTools;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use View;

class EventController extends Controller {

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() {
        $this->buildFeedFormData();
        $this->buildCreateFormValues();
        $formData = StorageHelper::getInstance()->get('feed_event.form_data');
        $formValues = StorageHelper::getInstance()->get('feed_event.form_values');
        $view = View::make('admin.admin.event.feed')->with('form_data', $formData)->with('form_values', $formValues)->with('event', null)
        ;
        return $view;
    }

    /**
     * 
     * @return Response
     */
    public function createAjax() {
        $response = response();
        $jsonResponse = array('success' => 0);

        $view = $this->create();
        if ($view instanceof \Illuminate\View\View) {
            $view->with('ajax', 1);
            $jsonResponse['content'] = $view->render();
            $jsonResponse['success'] = 1;
        }
        $responsePrepared = $response->json($jsonResponse);
        return $responsePrepared;
    }

    public function buildFeedFormData() {

        StorageHelper::getInstance()->add('feed_event.form_data.event_types', EventType::getLabelByType());
    }

    public function buildCreateFormValues() {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreEvent  $request
     * @return Response
     */
    public function store(StoreEvent $request) {
        $response = response();
        $jsonResponse = array('success' => 0);
        $promotion = null;
        $createdObjects = array();
        try {

            $startHour = $request->get('start_hour');
            $startDate = new DateTime(str_replace('/', '-', $request->get('start_date')).' '.$startHour);
            
            $endHour = $request->get('end_hour');
            $endDate = new DateTime(str_replace('/', '-', $request->get('end_date')).' '.$endHour);

            $event = Event::create([
                        'id' => UuidTools::generateUuid(),
                        'name' => $request->get('name'),
                        'status' => Event::STATUS_ACTIVE,
                        'description' => $request->get('description'),
                        'start_date' => $startDate->format('Y-m-d H:i'),
                        'end_date' => $endDate->format('Y-m-d H:i'),
                        'type_event' => $request->get('type_event'),
                        'id_establishment' => UuidTools::getId($request->get('id_establishment')),
            ]);
            if (checkModel($event)) {
                $jsonResponse['success'] = 1;
                $media = FileController::storeFile('media', Media::TYPE_USE_ETS_EVENT, $event);
            }
        } catch (Exception $ex) {
            foreach ($createdObjects as $createdObject) {
                if ($createdObject instanceof Model) {
                    $createdObject->delete();
                }
            }
            print_r($ex->getMessage());
            die();
        }

        if ($request->ajax()) {
            $responsePrepared = $response->json($jsonResponse);
            return $responsePrepared;
        } else {
            return redirect('/admin');
        }
    }
    
     /**
     * Show the form for editing the specified resource.
     *
     * @param  Establishment $event
     * @return Response
     */
    public function edit(Event $event) {
        $this->buildFeedFormData();
        $this->buildEditFormValues($event);
        $formData = StorageHelper::getInstance()->get('feed_event.form_data');
        $formValues = StorageHelper::getInstance()->get('feed_event.form_values');
        //var_dump($event->getId());
        $view = View::make('admin.event.feed')->with('form_data', $formData)->with('form_values', $formValues)->with('event', $event);
        return $view;
    }
    
     /**
     * 
     * @param Event $event
     */
    public function buildEditFormValues(Event $event) {
        // Default ID establishment
        $idEstablishment = $event->id_establishment;      
        StorageHelper::getInstance()->add('feed_event.form_values.id_establishment', $idEstablishment);
    }

    /**
     * 
     * @param StoreEvent $request
     * @return type
     */
    public function ajax(StoreEvent $request) {
        $response = response();
        $jsonResponse = array('success' => 0);
        try {
            $action = $request->get('action');
            switch ($action) {
                case 'feed-establishment-list':
                    $query = $request->get('q');
                    $establishmentsData = Establishment::select([
                                DB::raw(DbQueryTools::genRawSqlForGettingUuid('id', Establishment::TABLENAME)),
                                Establishment::TABLENAME . '.name', Address::TABLENAME . '.city'])
                            ->join(Address::TABLENAME, Address::TABLENAME . '.id', '=', Establishment::TABLENAME . '.id_address')
                            ->where(Establishment::TABLENAME . '.name', 'LIKE', '%' . $query . '%')
                            ->orWhere(Address::TABLENAME . '.city', 'LIKE', '%' . $query . '%')
                            ->get()
                    ;
                    foreach ($establishmentsData as $establishmentData) {
                        $jsonResponse['results'][] = array('id' => $establishmentData->uuid,
                            'text' => $establishmentData->name . ' (' . $establishmentData->city . ')');
                    }
                    break;
            }
        } catch (Exception $ex) {
            $jsonResponse['error'] = $ex->getMessage();
        }
        $responsePrepared = $response->json($jsonResponse);
        return $responsePrepared;
    }

    public static function getPromotionsDropdownFeed(){
        $defaultGeoloc = false;
        $searchDistance = SearchController::DEFAULT_DISTANCE_KM_SEARCH;
        $userLat = SessionController::getInstance()->getUserLat();
        $userLng = SessionController::getInstance()->getUserLng();
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        $userLatLng = new LatLng($userLat, $userLng);
        if (!$userLatLng->isValid()) {
            $userLatLng = GeolocationController::getRawInitialGeolocation();
        }
        
        $attempt = 1;
        $nbResults = 0;
        $promosAroundData = array();
        do{
            $ignoreStep = false;
            switch($attempt){
                case 2:
                    $searchDistance = 20;
                    break;
                case 3:
                    $searchDistance = 50;
                    break;
                case 4:
                    if($defaultGeoloc || $nbResults === 0){
                        $searchDistance = SearchController::DEFAULT_DISTANCE_KM_SEARCH;
                        $userLatLng = GeolocationController::getRawInitialGeolocation();
                        $defaultGeoloc = true;
                    } else {
                        $ignoreStep = true;
                    }
                    break;
                case 5:
                    if($defaultGeoloc || $nbResults === 0){
                        $searchDistance = 20;
                        $userLatLng = GeolocationController::getRawInitialGeolocation();
                        $defaultGeoloc = true;
                    } else {
                        $ignoreStep = true;
                    }
                    break;
            }

            $promoAroundQuery = Promotion::select([
                        Promotion::TABLENAME.'.name AS promo_name',
                        Establishment::TABLENAME.'.*',
                        Establishment::TABLENAME.'.name AS ets_name',
                        Address::TABLENAME.'.city',
                        DB::raw(DbQueryTools::genRawSqlForGettingUuid('id', Promotion::TABLENAME, 'uuid_promo')),
                        DB::raw(DbQueryTools::genRawSqlForDistanceCalculation($userLatLng, Establishment::TABLENAME))
                    ])
                    ->join(Establishment::TABLENAME, Establishment::TABLENAME . '.id', '=', Promotion::TABLENAME . '.id_establishment')
                    ->join(Address::TABLENAME, Address::TABLENAME . '.id', '=', Establishment::TABLENAME . '.id_address')
                    ->where('id_business_type', '=', $typeEts)
                    ->where(Establishment::TABLENAME . '.status', '=', Establishment::STATUS_ACTIVE)
                    ->where(Establishment::TABLENAME . '.business_status', '>=', 50)
                    ->whereRaw(Promotion::TABLENAME . '.end_date > NOW()')
            ;
            $geolocLimitSuccess = DbQueryTools::setGeolocLimits($promoAroundQuery, $userLatLng, $searchDistance, Establishment::TABLENAME);
            $nbResults = $promoAroundQuery->count();
            if ($ignoreStep || ($geolocLimitSuccess && $nbResults >= 10)) {
                $promosAroundData = $promoAroundQuery->get();
            }
            if($ignoreStep){
                break;
            }
            $attempt++;
        } while($nbResults < 10 && $attempt < 5);
        
        $promosAround = array();
        foreach($promosAroundData as $promoData){
            $promoDistance = $promoData->rawDistance;
            $distanceDisplay = str_replace(' ', '<br/>', StringTools::displayCleanDistance($promoDistance));
            $bgColor = StyleTools::genColorHexaForVisualGradient('0090ff', '00b33b', ($promoDistance/($searchDistance*1000)));
            
            $promoUuid = $promoData->uuid_promo;
            $promosAround[$promoUuid]['distance'] = $distanceDisplay;
            $promosAround[$promoUuid]['bg_color'] = $bgColor;
            $promosAround[$promoUuid]['item_name'] = $promoData->promo_name;
            $promosAround[$promoUuid]['ets_name'] = $promoData->ets_name;
            $promosAround[$promoUuid]['ets_url'] =
                    url(Establishment::getUrlStatic($promoData->id_business_type, $promoData->city, $promoData->slug, $promoData->url_id)."#ets-show-events");
        }
        return $promosAround;
    }

    public static function getEventsDropdownFeed(){
        $defaultGeoloc = false;
        $searchDistance = SearchController::DEFAULT_DISTANCE_KM_SEARCH;
        $userLat = SessionController::getInstance()->getUserLat();
        $userLng = SessionController::getInstance()->getUserLng();
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        $userLatLng = new LatLng($userLat, $userLng);
        if (!$userLatLng->isValid()) {
            $userLatLng = GeolocationController::getRawInitialGeolocation();
        }
        
        $attempt = 1;
        $nbResults = 0;
        $eventsAroundData = array();
        do{
            $ignoreStep = false;
            switch($attempt){
                case 2:
                    $searchDistance = 20;
                    break;
                case 3:
                    $searchDistance = 50;
                    break;
                case 4:
                    if($defaultGeoloc || $nbResults === 0){
                        $searchDistance = SearchController::DEFAULT_DISTANCE_KM_SEARCH;
                        $userLatLng = GeolocationController::getRawInitialGeolocation();
                        $defaultGeoloc = true;
                    } else {
                        $ignoreStep = true;
                    }
                    break;
                case 5:
                    if($defaultGeoloc || $nbResults === 0){
                        $searchDistance = 20;
                        $userLatLng = GeolocationController::getRawInitialGeolocation();
                        $defaultGeoloc = true;
                    } else {
                        $ignoreStep = true;
                    }
                    break;
            }

            $eventAroundQuery = Event::select([
                        Event::TABLENAME.'.name AS event_name',
                        Establishment::TABLENAME.'.*',
                        Establishment::TABLENAME.'.name AS ets_name',
                        Address::TABLENAME.'.city',
                        DB::raw(DbQueryTools::genRawSqlForGettingUuid('id', Event::TABLENAME, 'uuid_event')),
                        DB::raw(DbQueryTools::genRawSqlForDistanceCalculation($userLatLng, Establishment::TABLENAME))
                    ])
                    ->join(Establishment::TABLENAME, Establishment::TABLENAME . '.id', '=', Event::TABLENAME . '.id_establishment')
                    ->join(Address::TABLENAME, Address::TABLENAME . '.id', '=', Establishment::TABLENAME . '.id_address')
                    ->where('id_business_type', '=', $typeEts)
                    ->where(Establishment::TABLENAME . '.status', '=', Establishment::STATUS_ACTIVE)
                    ->where(Establishment::TABLENAME . '.business_status', '>=', 50)
                    ->whereRaw(Event::TABLENAME . '.end_date > NOW()')
            ;
            $geolocLimitSuccess = DbQueryTools::setGeolocLimits($eventAroundQuery, $userLatLng, $searchDistance, Establishment::TABLENAME);
            $nbResults = $eventAroundQuery->count();
            if ($ignoreStep || ($geolocLimitSuccess && $nbResults >= 10)) {
                $eventsAroundData = $eventAroundQuery->get();
            }
            if($ignoreStep){
                break;
            }
            $attempt++;
        } while($nbResults < 10 && $attempt < 5);
        
        $eventsAround = array();
        foreach($eventsAroundData as $eventData){
            $eventDistance = $eventData->rawDistance;
            $distanceDisplay = str_replace(' ', '<br/>', StringTools::displayCleanDistance($eventDistance));
            $bgColor = StyleTools::genColorHexaForVisualGradient('0090ff', '00b33b', ($eventDistance/($searchDistance*1000)));
            
            $eventUuid = $eventData->uuid_event;
            $eventsAround[$eventUuid]['distance'] = $distanceDisplay;
            $eventsAround[$eventUuid]['bg_color'] = $bgColor;
            $eventsAround[$eventUuid]['item_name'] = $eventData->event_name;
            $eventsAround[$eventUuid]['ets_name'] = $eventData->ets_name;
            $eventsAround[$eventUuid]['ets_url'] =
                    url(Establishment::getUrlStatic($eventData->id_business_type, $eventData->city, $eventData->slug, $eventData->url_id)."#ets-show-events");
        }
        return $eventsAround;
    }
    
    public function displayPromoFeed(){
        $promosAround = $this->getPromotionsDropdownFeed();
        $view = View::make('components.navbar-dropdown')
                ->with('containerId', 'promotionButton')
                ->with('buttonImageSrc', asset("/img/icons/ICONS-MAP-PROMOTIONS.svg"))
                ->with('buttonImageAlt', 'Promos')
                ->with('dropdownTitle', 'Promotions')
                ->with('eventsList', $promosAround)
                ->with('reloaded', true)
                ;
        return $view;
    }
    
    public function displayEventFeed(){
        $eventsAround = $this->getEventsDropdownFeed();
        $view = View::make('components.navbar-dropdown')
                ->with('containerId', 'eventButton')
                ->with('buttonImageSrc', asset("/img/icons/ICONS-CALENDAR-EVENTS.svg"))
                ->with('buttonImageAlt', 'Evénements')
                ->with('dropdownTitle', 'Evénements')
                ->with('eventsList', $eventsAround)
                ->with('reloaded', true)
                ;
        return $view;
    }
}
