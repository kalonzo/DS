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


// ESTABLISHMENT
Route::get('/establishment/create', 'EstablishmentController@create');          // create
Route::put('/establishment', 'EstablishmentController@store');                  // store

Route::get('/establishment/register', 'UserProController@create');          // register
//Route::put('/establishment', 'UserProController@store');                  // store

Route::get('/establishment/{establishment}','EstablishmentController@edit');    // edit
Route::put('/establishment/{establishment}','EstablishmentController@update');  // update

Route::get('/{type_ets}/{city}/{slug}/{url_id}', function($typeEts, $city, $slug, $url_id){                        // view
    $establishment = \App\Models\Establishment::where('slug', '=', $slug)->where('url_id', '=', $url_id)->first();
    
    $app = app();
    $establishmentController = $app->make(App\Http\Controllers\EstablishmentController::class);
    return $establishmentController->callAction('show', array('establishment' => $establishment));
});

/******************************TEST ROUTE**************************************/
Route::get('welcome/{locale}', function ($local) {
     Lang::setLocale($local);
     return view('dev.welcome');  
});

/****************************** ADMIN *****************************************/

Route::get('/admin', 'AdminController@index');


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
