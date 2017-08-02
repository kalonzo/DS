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
Auth::routes();

Route::get('/', 'HomeController@index');
//Route::post('logout', ['as' => 'logout', 'uses' => 'HomeController@index']);

Route::get('/admin', 'AdminController@index');

Route::get('/search-autocomplete', function () {
    $terms = Request::get('term');
    $results = App\Http\Controllers\SearchController::quickSearch($terms);
    echo json_encode($results);
});

Route::match(['get', 'post'], '/search', 'SearchController@search');

Route::get('/establishment/create', 'EstablishmentController@create');
Route::put('/establishment', 'EstablishmentController@store');

Route::post('reload_datatable', function(){
    $jsonResponse = array('success' => 0);
    $id = Request::get('id');
    $dtFeeder = \App\Http\Controllers\DatatableController::buildDatatable($id);
    if(!empty($dtFeeder)){
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
