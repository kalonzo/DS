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
Route::get('/logout', 'Auth\LoginController@logout');

/* * **************************** FRONT **************************************** */
Route::get('/', 'HomeController@index');
Route::match(['get', 'post'], '/search', 'SearchController@search');

// PRO USER
// create 
Route::get('/establishment/register', 'UserProController@create');
// store
Route::put('/establishment/register', 'UserProController@store');


// ESTABLISHMENT
// create view
Route::get('/create/establishment', 'EstablishmentController@create');
// store process
Route::post('/create/establishment', 'EstablishmentController@store');
// edit view
Route::get('/edit/establishment/{establishment}', 'EstablishmentController@edit');
// update process
Route::post('/edit/establishment/{establishment}', 'EstablishmentController@update');
// ajax processes through update 
Route::post('/edit/establishment/{establishment}/ajax/', 'EstablishmentController@ajax');

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

Route::get('/test/email', function () {
    $mail = Illuminate\Support\Facades\Mail::to('nico.trendonline@gmail.com')
        ->send(new App\Mail\TestMail());
    print_r($mail); 
    echo "Mail sent";
    die();
});


/* * **************************** ADMIN **************************************** */

App\Http\Controllers\AdminController::routes();

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
