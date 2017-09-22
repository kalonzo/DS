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
        Route::get('/admin/business_categories/{businessCategory}', 'BusinessCategoryController@edit')
                ->middleware('auth');
        Route::put('/admin/business_categories/{businessCategory}', 'BusinessCategoryController@update')
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
        Route::get('/admin/promotions/{promotion}', 'PromtionController@edit')
                ->middleware('auth');
        Route::put('/admin/promotions/{promotion}', 'PromtionController@update')
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
        
        Route::match(['put', 'post'], '/admin/create/{table_name}', function($table_name) {
            $controllerClass = null;

            switch ($table_name) {
                case Promotion::TABLENAME:
                    $controllerClass = App::make(PromotionController::class);
                    break;
                case Event::TABLENAME:
                    $controllerClass = App::make(EventController::class);
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
                }
                return $controllerClass->callAction($action, $params);
            }
        })->middleware('auth');
        
        Route::match(['put', 'post'], '/admin/booking/calendarFeed', 'BookingController@calendarFeed')
        ->middleware('auth');


        Route::get('/admin', 'AdminController@index');

        // IMPORT
        // upload file
        Route::get('/admin/establishment/import', 'ImportRestaurantController@index')
                ->middleware('auth');
        // import excel
        Route::post('/admin/establishment/import', 'ImportRestaurantController@import')
                ->middleware('auth');
    }

    public function index() {
        $etsDatatableFeeder = DatatableController::buildDatatable(DatatableController::ESTABLISHMENT_DATATABLE);

        $bookingDatatableFeeder = DatatableController::buildDatatable(DatatableController::BOOKING_DATATABLE);

        $businessCategoriesDatatableFeeder = DatatableController::buildDatatable(DatatableController::BUSINESS_CATEGORIES_DATATABLE);

        $promotionsDatatableFeeder = DatatableController::buildDatatable(DatatableController::PROMOTION_DATATABLE);

        $eventDatatableFeeder = DatatableController::buildDatatable(DatatableController::EVENT_DATATABLE);

        $view = View::make('admin.home')
                ->with($etsDatatableFeeder->getId(), $etsDatatableFeeder->getViewParamsArray())
                ->with($bookingDatatableFeeder->getId(), $bookingDatatableFeeder->getViewParamsArray())
                ->with($businessCategoriesDatatableFeeder->getId(), $businessCategoriesDatatableFeeder->getViewParamsArray())
                ->with($promotionsDatatableFeeder->getId(), $promotionsDatatableFeeder->getViewParamsArray())
                ->with($eventDatatableFeeder->getId(), $eventDatatableFeeder->getViewParamsArray())
        ;
        return $view;
    }

}
