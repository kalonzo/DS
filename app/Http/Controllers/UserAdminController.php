<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBusinessCategory;
use App\Models\Model;
use App\Models\User;
use App\Utilities\StorageHelper;
use App\Utilities\UuidTools;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use View;

class UserAdminController extends Controller
{
    
    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() {
        $this->buildFeedFormData();
        $this->buildCreateFormValues();
        $formData = StorageHelper::getInstance()->get('feed_user_admin.form_data');
        $formValues = StorageHelper::getInstance()->get('feed_user_admin.form_values');
        $view = View::make('admin.admin.user_admin.feed')->with('form_data', $formData)->with('form_values', $formValues)->with('user', null)
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
        StorageHelper::getInstance()->add('feed_user_admin.form_data.type', User::TYPE_USER_ADMIN_PRO);
        StorageHelper::getInstance()->add('feed_user_admin.form_data.user_types', User::getLabelByType());
    }
    
    public function buildCreateFormValues() {
        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreBusinessCategory  $request
     * @return Response
     */
    public function store(\App\Http\Requests\StoreUserAdmin $request) {
        $response = response();
        $jsonResponse = array('success' => 0);
        $user = null;
        $createdObjects = array();
        try {
            $user = User::create([
                'id' => UuidTools::generateUuid(),
                'type' => $request->get('type'),
                'status' => User::STATUS_ACTIVE,
                'gender' => 0,
                'name' => $request->get('email'),
                'firstname' => $request->get('firstname'),
                'lastname' => $request->get('lastname'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
                'id_company' => 0,
                'id_address' => 0,
                'id_inbox' => 0,
            ]);
            if(checkModel($user)){
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
}
