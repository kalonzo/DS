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

/************************* AUTH ***********************************************/
Auth::routes();

/****************************** FRONT *****************************************/
Route::get('/', 'HomeController@index');
Route::match(['get', 'post'], '/search', 'SearchController@search');

// PRO USER
// create 
Route::get('/establishment/register', 'UserProController@create'); 
// store
Route::put('/establishment/register', 'UserProController@store'); 
//Route::put('/establishment/register', function(){
//    $userProController = Illuminate\Support\Facades\App::make(App\Http\Controllers\UserProController::class);
//    return $userProController->callAction('store');
//});                  

// BusinessCategory
Route::get('/admin/business_categories/{businessCategory}', 'BusinessCategoryController@edit');
Route::put('/admin/business_categories/{businessCategory}', 'BusinessCategoryController@update');
//destroy        
Route::get('/admin/delete/{table_name}/{id}', function($table_name, $id){
    $controllerClass = null;
   
    switch ($table_name){
        case App\Models\BusinessCategory::TABLENAME: 
            $controllerClass = Illuminate\Support\Facades\App::make(App\Http\Controllers\BusinessCategoryController::class); 
        break;
    }   
    if(!empty($controllerClass)){
        return $controllerClass->callAction('destroy',array('id' => $id));
    }
});

// ESTABLISHMENT
// create
Route::get('/establishment/create', 'EstablishmentController@create');          
// store
Route::put('/establishment', 'EstablishmentController@store');              
// edit
Route::get('/establishment/{establishment}','EstablishmentController@edit');    
// update
Route::put('/establishment/{establishment}','EstablishmentController@update');  
Route::post('/establishment/{establishment}/ajax/','EstablishmentController@ajax');  
// view
Route::get('/{type_ets}/{city}/{slug}/{url_id}/{page?}', function($typeEts, $city, $slug, $url_id, $page = null){                        
    $establishment = \App\Models\Establishment::where('slug', '=', $slug)->where('url_id', '=', $url_id)->first();
    
    $establishmentController = Illuminate\Support\Facades\App::make(App\Http\Controllers\EstablishmentController::class);
    return $establishmentController->callAction('show', array('establishment' => $establishment, 'page' => $page));
});

// store booking
Route::post('/establishment/booking/{establishment}','EstablishmentController@createBooking');
    
// MEDIA
Route::post('/delete/{media_type}/{id_media}', function($media_type, $id_media){
    $media = null;
    $mediaClass = App\Models\Media::getClassFromTablename($media_type);
    if($mediaClass !== null){
        $media = $mediaClass::find(\App\Utilities\UuidTools::getUuid($id_media));
    }
    $mediaController = Illuminate\Support\Facades\App::make(App\Http\Controllers\MediaController::class);
    return $mediaController->callAction('destroy', array('media' => $media));
});//->where('media_type', '[a-z_]*');//'_medias$');  

// CHECKOUT
//Route::post('/start_checkout', 'WalleeController@startCheckout');
Route::post('/create_order', 'WalleeController@createOrder');
Route::match(['get', 'post'], '/complete_order', 'WalleeController@completeOrder');

/******************************TEST ROUTE**************************************/
Route::get('/welcome/{locale}', function ($local) {
     Lang::setLocale($local);
     return view('dev.welcome');  
});


/****************************** ADMIN *****************************************/

Route::get('/admin', 'AdminController@index');

// IMPORT
// upload file
Route::get('/admin/establishment/import', 'ImportRestaurantController@index');  

/**************************** AJAX CALLS **************************************/

Route::get('/search-autocomplete', function () {
    $terms = Request::get('term');
    $results = App\Http\Controllers\SearchController::quickSearch($terms);
    echo json_encode($results);
});

Route::post('reload_datatable', function(){
    $jsonResponse = array('success' => 0);
    $id = Request::get('id');
    $dtFeeder = \App\Http\Controllers\DatatableController::buildDatatable($id);
    if(!empty($dtFeeder)){
        $dtFeeder->setReloaded(true);
        return Illuminate\Support\Facades\View::make('components.datatable')->with('tabledata', $dtFeeder->getViewParamsArray());
    } else {
        return $jsonResponse;
    }
});

Route::get('/ajax/{action}', function($action){
    $jsonResponse = array('success' => 0);
    $response = response();
    $cookies = array();
    switch($action){
        case 'save_position':
            $userLat = Request::get('lat');
            $userLng = Request::get('lng');
            if(!empty($userLat) && !empty($userLng)){
                App\Http\Controllers\SessionController::getInstance()->setUserLng($userLng);
                App\Http\Controllers\SessionController::getInstance()->setUserLat($userLat);
                $cookies[] = cookie('userLat', $userLat, 60*12, null, null, null, false);
                $cookies[] = cookie('userLng', $userLng, 60*12, null, null, null, false);
                $jsonResponse['success'] = 1;
            }
            break;
    }
    
    $responsePrepared = $response->json($jsonResponse);
    foreach($cookies as $cookie){
        $responsePrepared->withCookie($cookie);
    }
    return $responsePrepared;
});
