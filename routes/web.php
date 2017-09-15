<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 */

/* * *********************** AUTH ********************************************** */
Auth::routes();

/* * **************************** FRONT **************************************** */
Route::get('/', 'HomeController@index');
Route::match(['get', 'post'], '/search', 'SearchController@search');

// PRO USER
// create 
Route::get('/establishment/register', 'UserProController@create');
// store
Route::put('/establishment/register', 'UserProController@store');

// BusinessCategory
Route::get('/admin/business_categories/{businessCategory}', 'BusinessCategoryController@edit');
Route::put('/admin/business_categories/{businessCategory}', 'BusinessCategoryController@update');
//destroy        
Route::get('/admin/delete/{table_name}/{id}', function($table_name, $id) {
    $controllerClass = null;

    switch ($table_name) {
        case App\Models\BusinessCategory::TABLENAME:
            $controllerClass = Illuminate\Support\Facades\App::make(App\Http\Controllers\BusinessCategoryController::class);
            break;
    }
    if ($controllerClass instanceof \App\Http\Controllers\Controller) {
        return $controllerClass->callAction('destroy', array('id' => $id));
    }
});

//Promotion
Route::get('/admin/promotions/{promotion}', 'PromtionController@edit');
Route::put('/admin/promotions/{promotion}', 'PromtionController@update');

//Evénement
Route::get('/admin/events/{event}', 'EventController@edit');
Route::put('/admin/events/{event}', 'EventController@update');

Route::get('/admin/create/{table_name}/{ajax?}', function($table_name, $ajax = null) {
    $controllerClass = null;

    switch ($table_name) {
        case App\Models\Promotion::TABLENAME:
            $controllerClass = Illuminate\Support\Facades\App::make(App\Http\Controllers\PromotionController::class);
            break;
        case App\Models\Event::TABLENAME:
            $controllerClass = Illuminate\Support\Facades\App::make(App\Http\Controllers\EventController::class);
            break;
    }
    if ($controllerClass instanceof \App\Http\Controllers\Controller) {
        $params = [];
        if ($ajax === 'ajax') {
            $action = 'ajax';
            switch ($table_name) {
                case App\Models\Promotion::TABLENAME:
                    $params['request'] = Illuminate\Support\Facades\App::make(App\Http\Requests\StorePromotion::class);
                    break;
                case App\Models\Event::TABLENAME:
                    $params['request'] = Illuminate\Support\Facades\App::make(App\Http\Requests\StoreEvent::class);
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
});
Route::match(['put', 'post'], '/admin/create/{table_name}', function($table_name) {
    $controllerClass = null;

    switch ($table_name) {
        case App\Models\Promotion::TABLENAME:
            $controllerClass = Illuminate\Support\Facades\App::make(App\Http\Controllers\PromotionController::class);
            break;
        case App\Models\Event::TABLENAME:
            $controllerClass = Illuminate\Support\Facades\App::make(App\Http\Controllers\EventController::class);
            break;
    }
    if ($controllerClass instanceof \App\Http\Controllers\Controller) {
        $params = [];
        $action = 'store';
//        if(Request::ajax()){
//            $action .= 'Ajax';
//        }
        switch ($table_name) {
            case App\Models\Promotion::TABLENAME:
                $params['request'] = Illuminate\Support\Facades\App::make(App\Http\Requests\StorePromotion::class);
                break;
            case App\Models\Event::TABLENAME:
                $params['request'] = Illuminate\Support\Facades\App::make(App\Http\Requests\StoreEvent::class);
                break;
        }
        return $controllerClass->callAction($action, $params);
    }
});

// ESTABLISHMENT
// create
Route::get('/establishment/create', 'EstablishmentController@create');
// store
Route::put('/establishment', 'EstablishmentController@store');
// edit
Route::get('/establishment/{establishment}', 'EstablishmentController@edit');
// update
Route::put('/establishment/{establishment}', 'EstablishmentController@update');
Route::post('/establishment/{establishment}/ajax/', 'EstablishmentController@ajax');

// store booking
Route::post('/establishment/booking/{establishment}', 'EstablishmentController@createBooking');
Route::match(['get', 'post'], '/establishment/booking/{establishment}/ajax/', 'EstablishmentController@createBookingAjax');

// view
Route::match(['get', 'post'], '/{type_ets}/{city}/{slug}/{url_id}/{page?}', function($typeEts, $city, $slug, $url_id, $page = null) {
    $establishment = \App\Models\Establishment::where('slug', '=', $slug)->where('url_id', '=', $url_id)->first();

    $establishmentController = Illuminate\Support\Facades\App::make(App\Http\Controllers\EstablishmentController::class);
    $controllerRes = null;
    if (Request::ajax()) {
        $controllerRes = $establishmentController->callAction('showAjax', array('request' => Request::instance(), 'establishment' => $establishment, 'page' => $page));
    } else {
        $controllerRes = $establishmentController->callAction('show', array('establishment' => $establishment, 'page' => $page));
    }
    return $controllerRes;
});

// MEDIA
Route::post('/delete/{media_type}/{id_media}', function($media_type, $id_media) {
    $media = null;
    $mediaClass = App\Models\Media::getClassFromTablename($media_type);
    if ($mediaClass !== null) {
        $media = $mediaClass::find(\App\Utilities\UuidTools::getUuid($id_media));
    }
    $mediaController = Illuminate\Support\Facades\App::make(App\Http\Controllers\MediaController::class);
    return $mediaController->callAction('destroy', array('media' => $media));
})->where('media_type', '[a-z_]*medias$');

// CHECKOUT
//Route::post('/start_checkout', 'WalleeController@startCheckout');
Route::post('/create_order', 'WalleeController@createOrder');
Route::match(['get', 'post'], '/complete_order', 'WalleeController@completeOrder');

/* * ****************************TEST ROUTE************************************* */
Route::get('/welcome/{locale}', function ($local) {
    Lang::setLocale($local);
    return view('dev.welcome');
});


/* * **************************** ADMIN **************************************** */

Route::get('/admin', 'AdminController@index');

// IMPORT
// upload file
Route::get('/admin/establishment/import', 'ImportRestaurantController@index');
// import excel
Route::post('/admin/establishment/import', 'ImportRestaurantController@import');

/* * ************************** AJAX CALLS ************************************* */

Route::get('/search-autocomplete', function () {
    $terms = Request::get('term');
    $results = App\Http\Controllers\SearchController::quickSearch($terms);
    echo json_encode($results);
});

Route::post('reload_datatable', function() {
    $jsonResponse = array('success' => 0);
    $id = Request::get('id');
    $dtFeeder = \App\Http\Controllers\DatatableController::buildDatatable($id);
    if (!empty($dtFeeder)) {
        $dtFeeder->setReloaded(true);
        return Illuminate\Support\Facades\View::make('components.datatable')->with('tabledata', $dtFeeder->getViewParamsArray());
    } else {
        return $jsonResponse;
    }
});

Route::get('/ajax/{action}', function($action) {
    $jsonResponse = array('success' => 0);
    $response = response();
    $cookies = array();
    switch ($action) {
        case 'save_position':
            $userLat = Request::get('lat');
            $userLng = Request::get('lng');
            if (!empty($userLat) && !empty($userLng)) {
                App\Http\Controllers\SessionController::getInstance()->setUserLng($userLng);
                App\Http\Controllers\SessionController::getInstance()->setUserLat($userLat);
                $cookies[] = cookie('userLat', $userLat, 60 * 12, null, null, null, false);
                $cookies[] = cookie('userLng', $userLng, 60 * 12, null, null, null, false);
                $jsonResponse['success'] = 1;
            }
            break;
    }

    $responsePrepared = $response->json($jsonResponse);
    foreach ($cookies as $cookie) {
        $responsePrepared->withCookie($cookie);
    }
    return $responsePrepared;
});
