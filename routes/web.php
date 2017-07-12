<?php
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
function String2Hex($string){
    $hex='';
    for ($i=0; $i < strlen($string); $i++){
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
}

Route::get ( '/', function () {
    return view ( 'front.home' );
} );
Route::get ( '/admin', function () {
	return view ( 'admin.home' );
} );



Route::get('/establishment/create',
		['as' => 'establishment', 'uses' => 'EstablishmentController@create']);
Route::post('/establishment',
		['as' => 'establishment_store', 'uses' => 'EstablishmentController@store']);
