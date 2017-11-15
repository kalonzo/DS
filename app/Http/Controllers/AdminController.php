<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvent;
use App\Http\Requests\StorePromotion;
use App\Models\BusinessCategory;
use App\Models\Event;
use App\Models\Promotion;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class AdminController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public static function routes() {
        // BusinessCategory
        Route::get('/admin/'.BusinessCategory::TABLENAME.'/{businessCategory}', 'BusinessCategoryController@edit')
                ->middleware('auth');
        Route::put('/admin/'.BusinessCategory::TABLENAME.'/{businessCategory}', 'BusinessCategoryController@update')
                ->middleware('auth');
        // Subscription
        Route::get('/admin/'. \App\Models\Subscription::TABLENAME.'/{subscription}', 'SubscriptionController@edit')
                ->middleware('auth');
        Route::put('/admin/'.\App\Models\Subscription::TABLENAME.'/{subscription}', 'SubscriptionController@update')
                ->middleware('auth');
        
        //destroy        
        Route::get('/admin/delete/{table_name}/{id}', function($table_name, $id) {
            $controllerClass = null;

            switch ($table_name) {
                case BusinessCategory::TABLENAME:
                    $controllerClass = App::make(BusinessCategoryController::class);
                    break;
            }
            if ($controllerClass instanceof Controller) {
                return $controllerClass->callAction('destroy', array('id' => $id));
            }
        })->middleware('auth');

        //Promotion
        Route::get('/admin/promotions/{promotion}', 'PromotionController@edit')
                ->middleware('auth');
        Route::put('/admin/promotions/{promotion}', 'PromotionController@update')
                ->middleware('auth');

        //Evénement
        Route::get('/admin/events/{event}', 'EventController@edit')->middleware('auth');
        Route::put('/admin/events/{event}', 'EventController@update')->middleware('auth');

        Route::get('/admin/create/{table_name}/{ajax?}', function($table_name, $ajax = null) {
            $controllerClass = null;

            switch ($table_name) {
                case Promotion::TABLENAME:
                    $controllerClass = App::make(PromotionController::class);
                    break;
                case Event::TABLENAME:
                    $controllerClass = App::make(EventController::class);
                    break;
                case BusinessCategory::TABLENAME:
                    $controllerClass = App::make(BusinessCategoryController::class);
                    break;
                case \App\Models\User::TABLENAME:
                    $controllerClass = App::make(UserAdminController::class);
                    break;
            }
            if ($controllerClass instanceof Controller) {
                $params = [];
                if ($ajax === 'ajax') {
                    $action = 'ajax';
                    switch ($table_name) {
                        case Promotion::TABLENAME:
                            $params['request'] = App::make(StorePromotion::class);
                            break;
                        case Event::TABLENAME:
                            $params['request'] = App::make(StoreEvent::class);
                            break;
                        case BusinessCategory::TABLENAME:
                            $params['request'] = App::make(\App\Http\Requests\StoreBusinessCategory::class);
                            break;
                        case \App\Models\User::TABLENAME:
                            $params['request'] = App::make(\App\Http\Requests\StoreUserAdmin::class);
                            break;
                    }
                } else {
                    $action = 'create';
                    if (Request::ajax()) {
                        $action .= 'Ajax';
                    }
                }
                return $controllerClass->callAction($action, $params);
            }
        })->middleware('auth');

        Route::get('/admin/edit/{table_name}/{id}', function($table_name, $id) {
            $controllerClass = null;

            switch ($table_name) {
                case \App\Models\BusinessType::TABLENAME:
                    $controllerClass = App::make(BusinessTypeController::class);
                    break;
                case \App\Models\PaymentMethod::TABLENAME:
                    $controllerClass = App::make(PaymentMethodController::class);
                    break;
            }
            if ($controllerClass instanceof Controller) {
                return $controllerClass->callAction('edit', array('id' => $id));
            }
        })->middleware('auth');

        Route::match(['put', 'post'], '/admin/update/'.\App\Models\BusinessType::TABLENAME.'/{businessType}', 'BusinessTypeController@update');
        Route::match(['put', 'post'], '/admin/update/'.\App\Models\PaymentMethod::TABLENAME.'/{paymentMethod}', 'PaymentMethodController@update');
//        Route::match(['put', 'post'], '/admin/update/{table_name}/{id}', function($table_name, $id) {
//            $controllerClass = null;
//            $params = ['id' => $id];
//
//            switch ($table_name) {
//                case \App\Models\BusinessType::TABLENAME:
//                    $controllerClass = App::make(BusinessTypeController::class);
//                    $params['request'] = Request::instance();
//                    break;
//            }
//            if ($controllerClass instanceof Controller) {
//                return $controllerClass->callAction('update', $params);
//            }
//        })->middleware('auth');
        
        Route::match(['put', 'post'], '/admin/create/{table_name}', function($table_name) {
            $controllerClass = null;

            switch ($table_name) {
                case Promotion::TABLENAME:
                    $controllerClass = App::make(PromotionController::class);
                    break;
                case Event::TABLENAME:
                    $controllerClass = App::make(EventController::class);
                    break;
                case BusinessCategory::TABLENAME:
                    $controllerClass = App::make(BusinessCategoryController::class);
                    break;
                case \App\Models\User::TABLENAME:
                    $controllerClass = App::make(UserAdminController::class);
                    break;
            }
            if ($controllerClass instanceof Controller) {
                $params = [];
                $action = 'store';
//        if(Request::ajax()){
//            $action .= 'Ajax';
//        }
                switch ($table_name) {
                    case Promotion::TABLENAME:
                        $params['request'] = App::make(StorePromotion::class);
                        break;
                    case Event::TABLENAME:
                        $params['request'] = App::make(StoreEvent::class);
                        break;
                    case BusinessCategory::TABLENAME:
                        $params['request'] = App::make(\App\Http\Requests\StoreBusinessCategory::class);
                        break;
                    case \App\Models\User::TABLENAME:
                        $params['request'] = App::make(\App\Http\Requests\StoreUserAdmin::class);
                        break;
                }
                return $controllerClass->callAction($action, $params);
            }
        })->middleware('auth');
        
        Route::match(['put', 'post'], '/admin/booking/calendarFeed', 'BookingController@calendarFeed')
        ->middleware('auth');

        // Pro User
        Route::get('/admin/user_pro/register', 'UserProController@create')
                ->middleware('auth');

        Route::get('/admin', 'AdminController@index');
        
        // Valid establishment
        Route::match(['post'], '/admin/valid_establishment/{establishment}', 'EstablishmentController@validateEstablishment')
        ->middleware('auth');
        // Unvalid establishment
        Route::match(['post'], '/admin/unvalid_establishment/{establishment}', 'EstablishmentController@unvalidateEstablishment')
        ->middleware('auth');
        
        // Preview
        Route::match(['get'], '/admin/preview_establishment/{establishment}/{page?}', 'EstablishmentController@preview')
        ->middleware('auth');
        
        // Moderate media
        Route::match(['get'], '/admin/media/moderate/{media}', 'MediaController@moderateMedia')
        ->middleware('auth');
        Route::match(['get'], '/admin/media/validate/{media}', 'MediaController@validateMedia')
        ->middleware('auth');
        Route::match(['get'], '/admin/media/deny/{media}', 'MediaController@denyMedia')
        ->middleware('auth');
        
        // Booking management
        Route::match(['get'], '/admin/booking/confirm/{booking}', 'BookingController@confirm');
        Route::match(['get'], '/admin/booking/deny/{booking}', 'BookingController@deny');
        Route::match(['get'], '/admin/booking/cancel/{booking}', 'BookingController@cancel');

        // IMPORT
        // upload file
        Route::get('/admin/establishment/import', 'ImportRestaurantController@index')
                ->middleware('auth');
        // import excel
        Route::post('/admin/establishment/import', 'ImportRestaurantController@import')
                ->middleware('auth');
    }

    public function index() {
        $view = null;
        switch(\Illuminate\Support\Facades\Auth::user()->getType()){
            case \App\Models\User::TYPE_USER_ADMIN_PRO:
                $view = $this->indexAdmin();
                break;
            case \App\Models\User::TYPE_USER_PRO:
                $view = $this->indexPro();
                break;
        }
        return $view;
    }
    
    private function indexAdmin(){
        $etsDatatableFeeder = DatatableController::buildDatatable(\App\Datatables\DtEstablishmentAdmin::DT_ID);
        
        $customerDatatable = DatatableController::buildDatatable(\App\Datatables\DtUserProAdmin::DT_ID);
        
        $bookingDatatableFeeder = DatatableController::buildDatatable(\App\Datatables\DtBookingAdmin::DT_ID);

        $businessCategoriesDatatableFeeder = DatatableController::buildDatatable(\App\Datatables\DtBusinessCategoryAdmin::DT_ID);
        
        $businessTypesDatatableFeeder = DatatableController::buildDatatable(\App\Datatables\DtBusinessTypeAdmin::DT_ID);

        $promotionsDatatableFeeder = DatatableController::buildDatatable(\App\Datatables\DtPromotionAdmin::DT_ID);

        $eventDatatableFeeder = DatatableController::buildDatatable(\App\Datatables\DtEventAdmin::DT_ID);
        
        $mediaModerationDatatable = DatatableController::buildDatatable(\App\Datatables\DtEstablishmentMediaModeration::DT_ID);
        
        $userDatatable = DatatableController::buildDatatable(\App\Datatables\DtUserAdmin::DT_ID);
        
        $paymentMethodDatatable = DatatableController::buildDatatable(\App\Datatables\DtPaymentMethodAdmin::DT_ID);
        
        $subscriptionDatatable = DatatableController::buildDatatable(\App\Datatables\DtSubscriptionAdmin::DT_ID);

        $view = View::make('admin.admin.dashboard')
                ->with($etsDatatableFeeder->getId(), $etsDatatableFeeder->getViewParamsArray())
                ->with($customerDatatable->getId(), $customerDatatable->getViewParamsArray())
                ->with($bookingDatatableFeeder->getId(), $bookingDatatableFeeder->getViewParamsArray())
                ->with($businessCategoriesDatatableFeeder->getId(), $businessCategoriesDatatableFeeder->getViewParamsArray())
                ->with($promotionsDatatableFeeder->getId(), $promotionsDatatableFeeder->getViewParamsArray())
                ->with($eventDatatableFeeder->getId(), $eventDatatableFeeder->getViewParamsArray())
                ->with($businessTypesDatatableFeeder->getId(), $businessTypesDatatableFeeder->getViewParamsArray())
                ->with($mediaModerationDatatable->getId(), $mediaModerationDatatable->getViewParamsArray())
                ->with($userDatatable->getId(), $userDatatable->getViewParamsArray())
                ->with($paymentMethodDatatable->getId(), $paymentMethodDatatable->getViewParamsArray())
                ->with($subscriptionDatatable->getId(), $subscriptionDatatable->getViewParamsArray())
        ;
        return $view;
    }
    
    private function indexPro(){
        $etsMessage = null;
        $establishmentIncomplete = true;
        $establishment = getCurrentEstablishment();
        if(checkModel($establishment)){
            switch($establishment->getBusinessStatus()){
                case 0:
                case 25:
                    $etsMessage = "Votre établissement n'a pas encore été renseigné. Pensez à saisir vos informations au plus vite en "
                                . "<a href='".url('/edit/establishment/'.$establishment->getUuid())."'>cliquant ici</a>.";
                    break;
                case 50:
                    $etsMessage = "Votre établissement ne dispose que des informations obligatoires. Pensez à renseigner davantage d'informations en "
                                . "<a href='".url('/edit/establishment/'.$establishment->getUuid())."'>cliquant ici</a>.";
                    break;
                case 75:
                    $etsMessage = "Votre établissement est presque complet. Pensez à renseigner les informations manquantes en "
                                . "<a href='".url('/edit/establishment/'.$establishment->getUuid())."'>cliquant ici</a>.";
                    break;
                case 100:
                    $establishmentIncomplete = false;
                    break;
            }
        }
        if($establishmentIncomplete){
            \Illuminate\Support\Facades\Request::session()->flash('error', $etsMessage);
        }
        
        $bookingDatatableFeeder = DatatableController::buildDatatable(\App\Datatables\DtBookingPro::DT_ID);

        $promotionsDatatableFeeder = DatatableController::buildDatatable(\App\Datatables\DtPromotionAdmin::DT_ID);

        $eventDatatableFeeder = DatatableController::buildDatatable(\App\Datatables\DtEventAdmin::DT_ID);

        $view = View::make('admin.pro.dashboard')
                ->with($bookingDatatableFeeder->getId(), $bookingDatatableFeeder->getViewParamsArray())
                ->with($promotionsDatatableFeeder->getId(), $promotionsDatatableFeeder->getViewParamsArray())
                ->with($eventDatatableFeeder->getId(), $eventDatatableFeeder->getViewParamsArray())
        ;
        return $view;
    }

}
