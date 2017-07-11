<?php

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('front.home');
});
Route::get('/admin', function () {
    return view('admin.home');
});

Route::get('getdata', function(){
    $term = Str::lower(Input::get('term'));
    $data = array(
        'R' => 'Red',
        'O' => 'Orange',
        'Y' => 'Yellow',
        'G' => 'Green',
        'B' => 'Blue',
        'I' => 'Indigo',
        'V' => 'Violet',
    );
    $return_array = array();

    foreach ($data as $k => $v){
        if (strpos(Str::lower($v), $term) !== FALSE) {
            $return_array[] = array('value' => $v, 'id' =>$k);
        }
    }
    return Response::json($return_array);
});