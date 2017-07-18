<?php

namespace App\Http\Controllers;

use App\php;
use Illuminate\Http\Request; 

class EstablishmentController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('establishment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
             $request->merge([
            'id_location_index' => 0
        ]);
           
         $address = \App\Models\Address::create($request->all()); 
         
         
         
         $id = $address->country;
         
         var_dump($id);
         
         
         die();
         
        /**  
          $name = $address->city;
         $id_address = $address->getUuid();
         var_dump($name);
             $request->merge([
            'id_location_index' => 0,
                 'id_logo'=> 0,
                 'id_user_owner' => 0,
                 'id_business_type' =>0
        ]);         
             
        \App\Models\Establishment::create($request->all()); 
         die();3**/
         
        return back();
    }


    
    /**
     * Display the specified resource.
     *
     * @param  \App\php  $php
     * @return \Illuminate\Http\Response
     */
    public function show(php $php) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\php  $php
     * @return \Illuminate\Http\Response
     */
    public function edit(php $php) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\php  $php
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, php $php) {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\php  $php
     * @return \Illuminate\Http\Response
     */
    public function destroy(php $php) {
        //
    }
    
    public function store_address(Request $request,$id_address){

        $request->merge([
            'id' => $id_address,
            'id_location_index' => 0
        ]);
             
         $address = \App\Models\Address::create($request->all());
         
         
        $id =  $id_address;
        var_dump($id);
         
        
        
      return $id;  
        
    }

}
