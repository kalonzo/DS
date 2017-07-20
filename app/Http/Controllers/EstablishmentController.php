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

    public function validateForm(Request $request) {

        $this->validate($request, [
            'name' => 'required|min:2|max:255',
            'street' => 'required|min:3|max:255',
            'street_number' => 'required|max:45',
            'postal_code' => 'required|max:11',
            'city' => 'required|max:255',
            'country' => 'required|max:255',
            'latitude' => 'required',
            'longitude' => 'required',
            //'number' => 'required|regex:/(01)[0-9]{9}/',
            'email' => 'required|email|max:255'
                ], [
            'name.required' => ' Vous devez spécifier un nom pour votre établissement.',
            'name.min' => ' Le nom de votre restaurant dois contenir au minimum 2 caractères.',
            'name.max' => ' Le nom du restaurant ne dois pas dépasser 255 caractères',
            'street.required' => 'Vous devez spécifiez une rue pour votre établissement',
            'street.min' => 'Le nom de rue dois contenir au minimum 3 caractères',
            'street_number.required' => ' Vous devez spécifiez un numéro de rue pour votre établissement.',
            'postal_code.required' => 'Vous devez spécifier un code postal',
            //'postal_code.number' => 'Le code postal ne dois pas contenir de caractère.',
            'city.required' => ' Vous devez spécifiez une ville pour votre établissement.',
            'country.required' => ' Vous devez spécifiez le pays de votre établissement.',
            'email.required' => ' Un email de contact pour le restaurant est requis.',
            'email.email' => 'Format d\'addresse mail incorrecte.',
            'latitude.required' => 'Veuillez cliquer sur le bouton localisation de mon restaurant.',
            'longitude.required' => 'Veuillez cliquer sur le bouton localisation de mon restaurant.',
                //'number.required' => 'Veuillez cliquer sur le bouton localisation de mon restaurant.'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        EstablishmentController::validateForm($request);

        //on assigne le nom de l'utilisateur par défaut pour le restaurant 
        $username = $request->get('name');

        $request->merge([
            'id_location_index' => 0
        ]);
        $address = \App\Models\Address::create($request->all());

        $uuid_address = $address->getId();

        //die($username);
        //on insére un utilisateur pour le restaurant
        $request->merge([
            'type' => \App\Models\User::TYPE_USER_ADMIN_PRO,
            'gender' => \App\Models\User::TYPE_GENDER_SOCITY,
            'id_address' => $uuid_address,
            'id_inbox' => 0,
            'id_company' => 0,
                //'name' => $username
        ]);

        $user = \App\Models\User::create($request->all());
        //die($username . '-' . $request->get('name'));

        $uuid_user = $user->getId();

        $request->merge([
            'id_location_index' => 0,
            'id_user_owner' => $uuid_user,
            'id_address' => $uuid_address,
            'id_business_type' => \App\Models\Restaurant::TYPE_BUSINESS_RESTAURANT,
            'id_logo' => 0
        ]);

        $establishment = \App\Models\Establishment::create($request->all());
        //$uuid_establishment = $establishment->getId();
        // return back()->with('msg','error');

        $msg = 'Veuillez passez à l\'étape de saisie des contact';

        //Session::flash('message', "Special message goes here");
        return back()->with('message', $msg);
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
