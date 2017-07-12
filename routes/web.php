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

Route::get('/', function(){
    return view ('front.home');
});
Route::get('/admin', function(){
    return view('admin.home');
});

Route::get('/search-autocomplete', function () {
    $terms = \Illuminate\Support\Facades\Request::get('term');
    $results = array(
                    array(
                        'label' => 'resto1',
                        'section' => 'Top Résultats',
                    ),
                    array(
                        'label' => 'resto2',
                        'section' => 'Top Résultats',
                    ),
                    array(
                        'label' => 'resto3',
                        'section' => 'Top Résultats',
                    ),
                    array(
                        'label' => 'resto2',
                        'section' => 'Nom',
                    ),
                    array(
                        'label' => 'resto3',
                        'section' => 'Nom',
                    ),
                    array(
                        'label' => 'Cuisine X',
                        'section' => 'Type de Cuisine',
                    ),
                );
    echo json_encode($results);
});

Route::get('/establishment/create',
		['as' => 'establishment', 'uses' => 'EstablishmentController@create']);
Route::post('/establishment',
		['as' => 'establishment_store', 'uses' => 'EstablishmentController@store']);
