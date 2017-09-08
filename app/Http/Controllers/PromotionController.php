<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePromotion;
use App\Models\Promotion;
use App\Models\PromotionType;
use App\Utilities\StorageHelper;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use View;

class PromotionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() {
        $this->buildFeedFormData();
        $this->buildCreateFormValues();
        $formData = StorageHelper::getInstance()->get('feed_promotion.form_data');
        $formValues = StorageHelper::getInstance()->get('feed_promotion.form_values');
        $view = View::make('admin.promotion.feed')->with('form_data', $formData)->with('form_values', $formValues)->with('promotion', null)
                ;
        return $view;
    }
    
    /**
     * 
     * @return Response
     */
    public function createAjax(){
        $response = response();
        $jsonResponse = array('success' => 0);
        
        $view = $this->create();
        if($view instanceof \Illuminate\View\View){
            $view->with('ajax', 1);
            $jsonResponse['content'] = $view->render();
            $jsonResponse['success'] = 1;
        }
        $responsePrepared = $response->json($jsonResponse);
        return $responsePrepared;
    }
    
    public function buildFeedFormData() {
        
        StorageHelper::getInstance()->add('feed_promotion.form_data.promotion_types', PromotionType::getLabelByType());
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
            $startDate = new \DateTime($request->get('start_date'));
            $endDate = new \DateTime($request->get('end_date'));
            $promotion = Promotion::create([
                'id' => \App\Utilities\UuidTools::generateUuid(),
                'name' => $request->get('name'),
                'status' => Promotion::STATUS_ACTIVE,
                'description' => $request->get('description'),
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'id_establishment' => \App\Utilities\UuidTools::getId($request->get('id_establishment')),
                'id_promotion_type' => $request->get('id_promotion_type'),
            ]);
            if(checkModel($promotion)){
                $jsonResponse['success'] = 1;
                $media = FileController::storeFile('media', \App\Models\Media::TYPE_USE_ETS_PROMO, $promotion);
            }
        } catch (Exception $ex) {
            foreach ($createdObjects as $createdObject) {
                if ($createdObject instanceof \Illuminate\Database\Eloquent\Model) {
                    $createdObject->delete();
                }
            }
            print_r($ex->getMessage()); die();
        }
        
        if($request->ajax()){
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
    public function ajax(StorePromotion $request){
        $response = response();
        $jsonResponse = array('success' => 0);
        try {
            $action = $request->get('action');
            switch ($action){
                case 'feed-establishment-list':
                    $query = $request->get('q');
                    $establishmentsData = \App\Models\Establishment::select([
                                \Illuminate\Support\Facades\DB::raw(\App\Utilities\DbQueryTools::genRawSqlForGettingUuid('id', \App\Models\Establishment::TABLENAME)), 
                                    \App\Models\Establishment::TABLENAME.'.name', \App\Models\Address::TABLENAME.'.city'])
                            ->join(\App\Models\Address::TABLENAME, \App\Models\Address::TABLENAME.'.id', '=', \App\Models\Establishment::TABLENAME.'.id_address')
                            ->where(\App\Models\Establishment::TABLENAME.'.name', 'LIKE', '%'.$query.'%')
                            ->orWhere(\App\Models\Address::TABLENAME.'.city', 'LIKE', '%'.$query.'%')
                            ->get()
                            ;
                    foreach($establishmentsData as $establishmentData){
                        $jsonResponse['results'][] = array('id' => $establishmentData->uuid, 
                                                            'text' => $establishmentData->name.' ('.$establishmentData->city.')');
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
