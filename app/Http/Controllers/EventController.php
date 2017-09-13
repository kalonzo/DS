<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvent;
use App\Http\Requests\StorePromotion;
use App\Models\Event;
use App\Models\EventType;
use App\Utilities\StorageHelper;
use Exception;
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
        $view = View::make('admin.event.feed')->with('form_data', $formData)->with('form_values', $formValues)->with('event', null)
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
     * @param  StorePromotion  $request
     * @return Response
     */
    public function store(StorePromotion $request) {
        $response = response();
        $jsonResponse = array('success' => 0);
        $promotion = null;
        $createdObjects = array();
        try {

            if ($request->get('start_hour') !== null) {
                $startHour = $request->get('start_hour');
            }
            if ($request->get('end_hour') !== null) {
                $endHour = $request->get('start_end');
            }
            
            $startDate = new \DateTime(str_replace('/', '-', $request->get('datetime_reservation')) . ' ' . $startHour);
            $endDate = new \DateTime(str_replace('/', '-', $request->get('datetime_reservation')) . ' ' . $endHour);

            $event = Event::create([
                        'id' => \App\Utilities\UuidTools::generateUuid(),
                        'name' => $request->get('name'),
                        'status' => Event::STATUS_ACTIVE,
                        'description' => $request->get('description'),
                        'start_date' => $startDate->format('Y-m-d H:i'),
                        'end_date' => $startDate->format('Y-m-d H:i'),
                        'type_event' => $request->get('type_event'),
                        'end_date' => $endDate->format('Y-m-d'),
                        'id_establishment' => \App\Utilities\UuidTools::getId($request->get('id_establishment')),
            ]);
            if (checkModel($event)) {
                $jsonResponse['success'] = 1;
                $media = FileController::storeFile('media', \App\Models\Media::TYPE_USE_ETS_EVENT, $event);
            }
        } catch (Exception $ex) {
            foreach ($createdObjects as $createdObject) {
                if ($createdObject instanceof \Illuminate\Database\Eloquent\Model) {
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
     * 
     * @param StorePromotion $request
     * @return type
     */
//    public function storeAjax(StorePromotion $request){
//        $response = response();
//        $jsonResponse = array('success' => 0);
//        
//        $promotion = $this->store($request);
//        if(checkModel($promotion)){
//            $jsonResponse['success'] = 1;
//        }
//        $responsePrepared = $response->json($jsonResponse);
//        return $responsePrepared;
//    }

    /**
     * 
     * @param StorePromotion $request
     * @return type
     */
    public function ajax(StorePromotion $request) {
        $response = response();
        $jsonResponse = array('success' => 0);
        try {
            $action = $request->get('action');
            switch ($action) {
                case 'feed-establishment-list':
                    $query = $request->get('q');
                    $establishmentsData = \App\Models\Establishment::select([
                                \Illuminate\Support\Facades\DB::raw(\App\Utilities\DbQueryTools::genRawSqlForGettingUuid('id', \App\Models\Establishment::TABLENAME)),
                                \App\Models\Establishment::TABLENAME . '.name', \App\Models\Address::TABLENAME . '.city'])
                            ->join(\App\Models\Address::TABLENAME, \App\Models\Address::TABLENAME . '.id', '=', \App\Models\Establishment::TABLENAME . '.id_address')
                            ->where(\App\Models\Establishment::TABLENAME . '.name', 'LIKE', '%' . $query . '%')
                            ->orWhere(\App\Models\Address::TABLENAME . '.city', 'LIKE', '%' . $query . '%')
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

}
