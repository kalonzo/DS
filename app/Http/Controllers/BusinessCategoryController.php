<?php

namespace App\Http\Controllers;

use App\Http\Request as Request2;
use App\Http\Requests\StoreBusinessCategory;
use App\Models\BusinessCategory;
use App\Utilities\StorageHelper;
use App\Utilities\UuidTools;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use View;

class BusinessCategoryController extends Controller {
    
    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() {
        $this->buildFeedFormData();
        $this->buildCreateFormValues();
        $formData = StorageHelper::getInstance()->get('feed_business_categories.form_data');
        $formValues = StorageHelper::getInstance()->get('feed_business_categories.form_values');
        $view = View::make('admin.admin.business_categories.feed')->with('form_data', $formData)->with('form_values', $formValues)->with('businessCategory', null)
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
        
        StorageHelper::getInstance()->add('feed_business_categories.form_data.business_categories_types', BusinessCategory::getLabelByType());
    }
    
    public function buildCreateFormValues() {
        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreBusinessCategory  $request
     * @return Response
     */
    public function store(StoreBusinessCategory $request) {
        $response = response();
        $jsonResponse = array('success' => 0);
        $businessCategory = null;
        $createdObjects = array();
        try {
            $businessCategory = BusinessCategory::create([
                'id' => UuidTools::generateUuid(),
                'name' => $request->get('name'),
                'type' => $request->get('type'),
                'status' => null,
            ]);
            if(checkModel($businessCategory)){
                $jsonResponse['success'] = 1;
            }
        } catch (Exception $ex) {
            foreach ($createdObjects as $createdObject) {
                if ($createdObject instanceof Model) {
                    $createdObject->delete();
                }
            }
            $jsonResponse['error'] = $ex->getMessage(); 
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
     * @param Request2 $request
     * @param BusinessCategory $businessCategory
     * @return type
     */
    public function edit(Request2 $request, BusinessCategory $businessCategory) {
        $response = response();
        $jsonResponse = array('success' => 0);
        $view = null;
        
        if(checkModel($businessCategory)){
            switch ($businessCategory->getStatus()) {
                case BusinessCategory::STATUS_TO_CHECK :
                    $status = array();
                    $status[] = 'En attente de validation';
                    $status[] = false;
                    break;
                default :
                    $status[] = 'Confirmé par Dinerscope';
                    break;
            }

            $view = View::make('admin.business_categories')->with('businessCategory', $businessCategory)
                    ->with('status', $status);
            $jsonResponse['content'] = $view->render();
            $jsonResponse['success'] = 1;
        }
        
        $responsePrepared = $response->json($jsonResponse);
        return $responsePrepared;
    }
    
    /**
     * 
     * @param Request $request
     * @param BusinessCategory $businessCategory
     * @return type
     */
    public function update(Request $request, BusinessCategory $businessCategory) {
        $businessCategory->update([
            'name' => $request->get('name'),
            'type' => $request->get('type'),
            'status' => null,
        ]);
//        $businessCategory->save();
        return redirect('/admin');
    }

    public function destroy($id) {
        $businessCategory = BusinessCategory::where('id', '=', $id)->first();
        if (checkModel($businessCategory)) {
            $businessCategory->delete();
        }
        return redirect('/admin');
    }

    /**
     * 
     * @param type $idEstablishment
     * @param type $name
     * @param type $type
     */
    function linkBusinessCategory($idEstablishment, $name, $type) {
        $businessModel = BusinessCategory::where('name', '=', $name)->where('type', '=', $type)->first();
        if (checkModel($businessModel)) {
            self::feedEstablishmentBusinessCategory($businessModel->getId(), $idEstablishment);
        } else {
            $specialityModel = BusinessCategory::create([
                        'id' => UuidTools::generateUuid(),
                        'name' => $name,
                        'type' => $type,
                        'status' => BusinessCategory::STATUS_TO_CHECK
            ]);
            self::feedEstablishmentBusinessCategory($specialityModel->getId(), $idEstablishment);
        }
    }
}
