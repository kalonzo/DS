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
        $uuid_address = hex2bin($address->getUuid());
        
        $request->merge([
            'id_location_index' => 0,
            'id_user_owner' => 0,
            'id_address' => $uuid_address,
            'id_business_type' => \App\Models\Restaurant::TYPE_BUSINESS_RESTAURANT,
            'id_logo' => 0
        ]);
        $establishment = \App\Models\Establishment::create($request->all());
        $uuid_establishment = $establishment->getId();
        return back()->with($uuid_establishment);
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
}
