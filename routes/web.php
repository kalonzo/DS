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
//Route::get('/define_password/{token}', '\App\Http\Controllers\Auth\RegisterController@definePassword');


/* * **************************** ADMIN **************************************** */

App\Http\Controllers\AdminController::routes();

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
Route::get('/create/establishment', 'EstablishmentController@create')
        ->middleware('auth');;
// store process
Route::post('/create/establishment', 'EstablishmentController@store')
        ->middleware('auth');;
// edit view
Route::get('/edit/establishment/{establishment}', 'EstablishmentController@edit')
        ->middleware('auth');;
// update process
Route::post('/edit/establishment/{establishment}', 'EstablishmentController@update')
        ->middleware('auth');;
// ajax processes through update 
Route::post('/edit/establishment/{establishment}/ajax/', 'EstablishmentController@ajax')
        ->middleware('auth');;
//ajax process on drag and drop rearrange orders
Route::match(['get', 'post'], '/edit/update_order', 'UpdateOrderController@changeOrder');


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
        $media = $mediaClass::findUuid(\App\Utilities\UuidTools::getUuid($id_media));
    }
    $mediaController = Illuminate\Support\Facades\App::make(App\Http\Controllers\MediaController::class);
    return $mediaController->callAction('destroy', array('media' => $media));
})->where('media_type', '[a-z_]*medias$');

// CHECKOUT
Route::post('/create_order', 'WalleeController@createOrder');
Route::match(['get', 'post'], '/transaction/success', 'WalleeController@transactionSucceed');
Route::match(['get', 'post'], '/transaction/failure', 'WalleeController@transactionFailed');
Route::match(['get', 'post'], '/establishment/register/success', 'WalleeController@subscriptionSucceed');
Route::match(['get', 'post'], '/establishment/register/failure', 'WalleeController@subscriptionFailed');


/* * ****************************TEST ROUTE************************************* */
if(envDev()){
    Route::get('/welcome/{locale}', function ($local) {
        Lang::setLocale($local);
        return view('dev.welcome');
    });

    Route::get('/testdev', function () {
        $user = \App\Models\User::whereNotNull('email')->first();
        var_dump($user->getEmail());
        $token = app('auth.password.broker')->createToken($user);
        print_r($token);
        die();
    });

    Route::get('/test/email', function () {
        $booking = App\Models\Booking::latest();
        $user = $booking->user()->first();
        $ets = $booking->establishment()->first();
        $user->notify(new \App\Notifications\BookingConfirmedUser($user, $booking, $ets, null));
        die();
    });
}
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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/aktiv8me/verify/{token}', '\App\Http\Controllers\Auth\RegisterController@verify')->name('register.verify');
Route::get('/aktiv8me/resend', '\App\Http\Controllers\Auth\RegisterController@getResend');
Route::post('/aktiv8me/resend', '\App\Http\Controllers\Auth\RegisterController@postResend')->name('register.resend');

/**
 * Sentry route test, to run after sentry install to check install is correct
 */

Route::get("/test", function() {
    throw new \Illuminate\Database\Eloquent\MassAssignmentException;
});

Route::get("/test500", function() {
    throw new \Symfony\Component\Debug\Exception\FatalErrorException;
});
