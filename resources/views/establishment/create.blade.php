@extends('layouts.front') 

@section('css_imports')
<link href="/css/establishment.css" rel="stylesheet">
@endsection

@section('js_imports_head')

@endsection

@section('content')

<div id="map"> </div>

@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

@if(count($errors))

<div class="alert alert-danger">
    <strong>Erreur!</strong> Les informations saisies ne sont pas correctes.
    <br/>
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>

@endif

@if(isset($establishment))
    {{ Form::model($establishment, ['route' => 'establishment.update']) }}
@else
    {!! Form::open(['route'=>'establishment.store']) !!}
@endif
    <input  type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="container-fluid no-gutter">
        <div id="ets-heading" class="row no-gutter"> 
            <div class="container">
                <img id="ets-logo" src="/img/images_ds/imagen-DS-1.jpg"/>
                {!! Form::file('url', array('class' => 'name', 'onchange' => 'previewImage(this)')) !!} 
                <div id="" class="form-inline form-group">
                    {!! Form::text('name', old('name'), ['class'=>'form-control', 'placeholder'=>'Nom de votre restaurant', 'id' => 'ets-name']) !!}
                    <!--<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>-->
                </div>
            </div>
        </div>  
        {!! Form::hidden('validationPhase', old('validationPhase'), ['placeholder'=>'1', 'id'=>'validationPhase']) !!}
        <div class="panel-group form-accordion" id="establishment_form_accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading1">
                    <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse1" 
                        aria-expanded="true" aria-controls="collapse1">
                        <div class="container">
                            <h4 class="panel-title">Emplacement</h4>
                        </div>
                    </a>
                </div>
                <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
                    <div class="panel-body container">
                        <!-- Saisie de l'adresse de l'établissement-->
                        <div class="row"> 
                            <div class="col-xs-8 col-sm-10 form-group {{ $errors->has('street') ? 'has-error' : '' }}">
                                {!! Form::label('* Adresse') !!}	
                                {!! Form::text('street', old('street'), [
                                'class'=>'form-control',
                                ]) !!}
                            </div>
                            <div class="col-xs-4 col-sm-2 form-group {{ $errors->has('street_number') ? 'has-error' : '' }}">
                                {!! Form::label('* N° Rue') !!}
                                {!! Form::text('street_number', old('street_number'), ['class'=>
                                'form-control', 
                                ]) !!}
                            </div>      
                        </div>

                        <div class="row">
                            <div class="col-xs-8 col-sm-10 form-group">
                                {!! Form::label('Complément d\'adresse') !!}
                                {!! Form::text('address_additional', old('address_additional'), [
                                'class'=>'form-control',
                                ]) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {!! Form::label('* NPA') !!}
                                <div class="form-group {{ $errors->has('postal_code') ? 'has-error' : '' }}">
                                    {!! Form::text('postal_code', old('postal_code'), [
                                    'class'=>'form-control', 
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-8">
                                {!! Form::label('* Localité') !!}
                                <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                                    {!! Form::text('city', old('city'), ['class'=>
                                    'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('* Canton/Départements') !!}
                                <div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
                                    {!! Form::text('canton', old('canton'), [
                                    'class'=>'form-control', 
                                    ]) !!}
                                    {!! Form::text('area', old('area'), ['class'=>'hidden']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                {!! Form::label('* Pays') !!}
                                <div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
                                    {!! Form::text('country', old('country'), [
                                    'class'=>'form-control', 
                                    ]) !!}
                                    <p id="demo"></p>
                                </div>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-4 form-group {{ $errors->has('latitude') ? 'has-error' : '' }}">
                                {!! Form::label('* Latitude') !!}
                                {!! Form::text('latitude', old('latitude'), [
                                'class'=>'form-control',
                                'readonly' => 'readonly'
                                ]) !!}
                            </div>           
                            <div class="col-xs-6 col-sm-4 form-group {{ $errors->has('longitude') ? 'has-error' : '' }}">
                                {!! Form::label('* Longitude') !!}
                                {!! Form::text('longitude', old('longitude'), ['class'=>
                                'form-control', 
                                'readonly' => 'readonly'
                                ]) !!}
                            </div>
                            <div class="col-xs-12 col-sm-4 form-group">
                                <label>&nbsp;</label>
                                <button role="button" class="btn btn-sm col-xs-12" onclick="getCoords(this); return false;">
                                    <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Géolocaliser mon établissement
                                </button>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading2">
                    <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse2" 
                        aria-expanded="true" aria-controls="collapse2">
                        <div class="container">
                            <h4 class="panel-title">Contacts</h4>
                        </div>
                    </a>
                </div>
                <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
                    <div class="panel-body container">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('* Téléphone pour réservation') !!}
                                <div class="form-group {{ $errors->has('numberReservation') ? 'has-error' : '' }}">
                                    {!!  Form::select('callNumberPrefixIdsByNameReservation',$form_data['country_prefixes'], ['class'=>
                                    'form-control',
                                    'placeholder'=>'',
                                    'id'=>'callNumberPrefixIdsByNameReservation'
                                    ]) !!}

                                    {!! Form::text('numberReservation', old('number'), [
                                    'class'=>'form-control', 
                                    'placeholder'=>'',
                                    'id'=>'number'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                {!! Form::label('* Téléphone de contact') !!}

                                <div class="form-group {{ $errors->has('contactNumber') ? 'has-error' : '' }} " >
                                    
                                    {!!  Form::select('callNumberPrefixIdsByNameContact',$form_data['country_prefixes'], ['class'=>
                                    'form-control',
                                    'placeholder'=>'',
                                    'id'=>'callNumberPrefixIdsByName'
                                    ]) !!}
                                    {!! Form::text('contactNumber', old('number'), ['class'=>
                                    'form-control',
                                    'placeholder'=>'',
                                    'id'=>'phone'
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('* Fax') !!}
                                <div class="form-group ">
                                    
                                    {!!  Form::select('callNumberPrefixIdsByNameFax',$form_data['country_prefixes'], ['class'=>
                                    'form-control',
                                    'placeholder'=>'',
                                    'id'=>'callNumberPrefixIdsByName'
                                    ]) !!}
                                    {!! Form::text('fax', old('fax'), [
                                    'class'=>'form-control', 
                                    'placeholder'=>'',
                                    'id'=>'fax'
                                    ]) !!}

                                </div>
                            </div>
                            <div class="col-md-6">
                                {!! Form::label('* Mobile') !!}

                                <div class="form-group">
                                    
                                    {!!  Form::select('callNumberPrefixIdsByNameMobile',$form_data['country_prefixes'], ['class'=>
                                    'form-control',
                                    'placeholder'=>'',
                                    'id'=>'callNumberPrefixIdsByName'
                                    ]) !!}
                                    {!! Form::text('mobile', old('mobile'), [
                                    'class'=>'form-control',
                                    'placeholder'=>'',
                                    'id'=> 'mobile'
                                    ]) !!}
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading3">
                    <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse3" 
                        aria-expanded="true" aria-controls="collapse3">
                        <div class="container">
                            <h4 class="panel-title">www</h4>
                        </div>
                    </a>
                </div>
                <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
                    <div class="panel-body container">
                        <div class="row">
                            <div class="col-md-12 accordion-inner">
                                {!! Form::label('* e-mail') !!}
                                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                    {!! Form::text('email', old('email'), [
                                    'class'=>'form-control', 
                                    'placeholder'=>''
                                    ]) !!}
                                </div>
                                {!! Form::label('* Site web de votre restaurant') !!}

                                <div class="form-group">
                                      
                                    {!! Form::text('site_url', old('site_url'), ['class'=>
                                    'form-control', 'placeholder'=>
                                    'Enter Message']) !!}
                                </div>

                            </div>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading4">
                    <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse4" 
                        aria-expanded="true" aria-controls="collapse4">
                        <div class="container">
                            <h4 class="panel-title">Types de cuisine</h4>
                        </div>
                    </a>
                </div>
                <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
                    <div class="panel-body container">
                        <div class="row">
                            <section class="col-md-12 container-fluid">
                                <div>
                                    <select id="leftValues" size="5" multiple>
                                        <option>Cuisines des saisons</option>
                                    </select>
                                </div>
                                <div>
                                    <input type="button" id="btnLeft" onclick="{
                                                addCookingType();
                                            }" value="&lt;&lt;"/>
                                    <input type="button" id="btnRight" onclick="{
                                                addCookingType();
                                            }" value="&gt;&gt;"/>
                                </div>
                                <div>
                                    {!! Form::select('cookingTypeSelection[]', $form_data['cooking_types'], 
                                                    null, array('multiple' => true, 'id'=>'rightValues')) !!}
                                    <div>
                                        <input type="text" id="txtRight" />
                                    </div>
                                </div>
                            </section>   
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading5">
                    <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse5" 
                        aria-expanded="true" aria-controls="collapse5">
                        <div class="container">
                            <h4 class="panel-title">Spécialités</h4>
                        </div>
                    </a>
                </div>
                <div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
                    <div class="panel-body container">
                        <div class="row">
                            <section class="col-md-12 container-fluid">
                                <div>
                                    <select id="leftValues" size="5" multiple>

                                    </select>
                                </div>
                                <div>
                                    <input type="button" id="btnLeft" onclick="{
                                                addCookingType();
                                            }" value="&lt;&lt;"/>
                                    <input type="button" id="btnRight" onclick="{
                                                addCookingType();
                                            }" value="&gt;&gt;"/>
                                </div>
                                <div>
                                    {!! Form::select('foodSpecialitieIdsByName[]', $form_data['food_specialities'], 
                                                    null, array('multiple' => true)) !!}
                                    <div>
                                        <input type="text" id="txtRight" />
                                    </div>
                                </div>
                            </section>   
                        </div>
                    </div>
                </div>  
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading6">
                    <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse6" 
                        aria-expanded="true" aria-controls="collapse6">
                        <div class="container">
                            <h4 class="panel-title">Description détaillée</h4>
                        </div>
                    </a>
                </div>
                <div id="collapse6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
                    <div class="panel-body container">
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::label('Description :') !!}
                                <div class="form-group">
                                    {!! Form::textarea('description', old('description'), ['class'=>
                                    'form-control', 'placeholder'=>
                                    'Enter Name']) !!}  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading7">
                    <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse7" 
                        aria-expanded="true" aria-controls="collapse7">
                        <div class="container">
                            <h4 class="panel-title">Services</h4>
                        </div>
                    </a>
                </div>
                <div id="collapse7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading7">
                    <div class="panel-body container">
                        <div class="row">
                            <section class="col-md-12 container-fluid">
                                <div>
                                    <select id="leftValues" size="5" multiple>

                                    </select>
                                </div>
                                <div>
                                    <input type="button" id="btnLeft" onclick="{
                                                addCookingType();
                                            }" value="&lt;&lt;"/>
                                    <input type="button" id="btnRight" onclick="{
                                                addCookingType();
                                            }" value="&gt;&gt;"/>
                                </div>
                                <div>
                                    {!! Form::select('servicIdsByName[]', $form_data['services'], null, array('multiple' => true)) !!}
                                    <div>
                                        <input type="text" id="txtRight" />
                                    </div>
                                </div>
                            </section>   
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading8">
                    <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse8" 
                        aria-expanded="true" aria-controls="collapse8">
                        <div class="container">
                            <h4 class="panel-title">Cadre & ambiance</h4>
                        </div>
                    </a>
                </div>
                <div id="collapse8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading8">
                    <div class="panel-body container">
                        <div class="row">
                            <section class="col-md-12 container-fluid">
                                <div>
                                    <select id="leftValues" size="5" multiple>
                                        <option>Salsa</option>
                                    </select>
                                </div>
                                <div>
                                    <input type="button" id="btnLeft" onclick="{
                                                addCookingType();
                                            }" value="&lt;&lt;"/>
                                    <input type="button" id="btnRight" onclick="{
                                                addCookingType();
                                            }" value="&gt;&gt;"/>
                                </div>
                                <div>
                                    {!! Form::select('restaurantAtmospherIdsByName[]',$form_data['atmospheres']
                                                    , null, array('multiple' => true)) !!}
                                    <div>
                                        <input type="text" id="txtRight" />
                                    </div>
                                </div>
                            </section>   
                        </div>
                    </div>
                </div> 
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading9">
                    <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse9" 
                        aria-expanded="true" aria-controls="collapse9">
                        <div class="container">
                            <h4 class="panel-title">Photos et galeries</h4>
                        </div>
                    </a>
                </div>
                <div id="collapse9" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading9">
                    <div class="panel-body container">

                    </div> 
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading10">
                    <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse10" 
                        aria-expanded="true" aria-controls="collapse10">
                        <div class="container">
                            <h4 class="panel-title">Horaires</h4>
                        </div>
                    </a>
                </div>
                <div id="collapse10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading10">
                    <div class="panel-body container">
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Veuillez indiquer vos horaire d'ouverture</h5>
                            </div>    
                            <div class="col-md-4">
                                <h5>Déjeuner</h5>
                            </div>    
                            <div class="col-md-4">
                                <h5>Diner</h5>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Lundi</h5>
                            </div>    
                            <div class="col-md-4">
                                {!! Form::select('startTimeAm1',$form_data['timetable'], null, array('multiple' => false)) !!}
                                {!! Form::select('endTimeAm1',$form_data['timetable'], null, array('multiple' => false)) !!}
                            </div>    
                            <div class="col-md-4">
                                {!! Form::select('startTimePm1',$form_data['timetable'], null, array('multiple' => false)) !!}
                                {!! Form::select('endTimePm1',$form_data['timetable'], null, array('multiple' => false)) !!}
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Mardi</h5>
                            </div>    
                            <div class="col-md-4">                       
                                {!! Form::select('startTimeAm2',$form_data['timetable'], null, array('multiple' => false)) !!}
                                {!! Form::select('endTimeAm2',$form_data['timetable'], null, array('multiple' => false)) !!}
                            </div>    
                            <div class="col-md-4">
                                {!! Form::select('startTimePm2',$form_data['timetable'], null, array('multiple' => false)) !!}
                                {!! Form::select('endTimePm2',$form_data['timetable'], null, array('multiple' => false)) !!}
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Mercredi</h5>
                            </div>    
                            <div class="col-md-4">
                                {!! Form::select('startTimeAm3',$form_data['timetable'], null, array('multiple' => false)) !!}
                                {!! Form::select('endTimeAm3',$form_data['timetable'], null, array('multiple' => false)) !!}
                            </div>    
                            <div class="col-md-4">
                                {!! Form::select('startTimePm3',$form_data['timetable'], null, array('multiple' => false)) !!}
                                {!! Form::select('endTimePm3',$form_data['timetable'], null, array('multiple' => false)) !!}
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Jeudi</h5>
                            </div>    
                            <div class="col-md-4">
                                {!! Form::select('startTimeAm4',$form_data['timetable'], null, array('multiple' => false)) !!}
                                {!! Form::select('endTimeAm4',$form_data['timetable'], null, array('multiple' => false)) !!}
                            </div>    
                            <div class="col-md-4">
                                {!! Form::select('startTimePm4',$form_data['timetable'], null, array('multiple' => false)) !!}
                                {!! Form::select('endTimePm4',$form_data['timetable'], null, array('multiple' => false)) !!}
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Vendredi</h5>
                            </div>    
                            <div class="col-md-4">
                                {!! Form::select('startTimeAm5',$form_data['timetable'], null, array('multiple' => false)) !!}
                                {!! Form::select('endTimeAm5',$form_data['timetable'], null, array('multiple' => false)) !!}
                            </div>    
                            <div class="col-md-4">
                                {!! Form::select('startTimePm5',$form_data['timetable'], null, array('multiple' => false)) !!}
                                {!! Form::select('endTimePm5',$form_data['timetable'], null, array('multiple' => false)) !!}
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Samedi</h5>
                            </div>    
                            <div class="col-md-4">
                                {!! Form::select('startTimeAm6',$form_data['timetable'], null, array('multiple' => false)) !!}
                                {!! Form::select('endTimeAm6',$form_data['timetable'], null, array('multiple' => false)) !!}
                            </div>    
                            <div class="col-md-4">
                                {!! Form::select('startTimePm6',$form_data['timetable'], null, array('multiple' => false)) !!}
                                {!! Form::select('endTimePm6',$form_data['timetable'], null, array('multiple' => false)) !!}
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Dimanche</h5>
                            </div>    
                            <div class="col-md-4">
                                {!! Form::select('startTimeAm7',$form_data['timetable'], null, array('multiple' => false)) !!}
                                {!! Form::select('endTimeAm7',$form_data['timetable'], null, array('multiple' => false)) !!}
                            </div>    
                            <div class="col-md-4">
                                {!! Form::select('startTimePm7',$form_data['timetable'], null, array('multiple' => false)) !!}
                                {!! Form::select('endTimePm7',$form_data['timetable'], null, array('multiple' => false)) !!}
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5> Fermeture exceptionnelle</h5> 
                            </div>      
                        </div>
                    </div> 
                </div>
            </div>    
        </div>
    </div>

    <div id="formControlBottomBand">
       {!! Form::submit('Valider', array('class'=>'btn btn-primary pull-right')) !!}
    </div>
{!! form::close() !!}
@endsection

<script type="text/javascript">

    function addCookingType() {
        var selectedItem = $("#rightValues option:selected").select();
        $("#leftValues").append(selectedItem);
    }


    function getCoords(triggerELement) {
        var $form = $(triggerELement).parentsInclude('form');
        var city = $form.find('input[name=city]').val();
        var street = $form.find('input[name=street]').val();
        var street_number = $form.find('input[name=street_number]').val();
        var postal_code = $form.find('input[name=postal_code]').val();
        var country = $form.find('input[name=country]').val();
        
        var address = street + ' ' + street_number + ', ' + postal_code + ' ' + city + ' ' + country;
        if (!isEmpty(address)) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                'address': address
            }, function (results, status) {
                if (status === 'OK') {
                    var lat = results[0].geometry.location.lat();
                    var lng = results[0].geometry.location.lng();
                    
                    $form.find('input[name=latitude]').val(lat);
                    $form.find('input[name=longitude]').val(lng);
    
                    if (results[0]) {
                        var result = results[0];
//                        console.log(result);
                        for (var i = 0; i < result.address_components.length; i++) {
                            var ac = result.address_components[i];
                            if(typeof ac.types[0] != 'undefined'){
                                switch(ac.types[0]){
                                    case 'locality':
                                        $form.find('input[name=city]').val(ac.long_name);
                                        break;
                                    case 'street_number':
                                        $form.find('input[name=street_number]').val(ac.long_name);
                                        break;
                                    case 'route':
                                        $form.find('input[name=street]').val(ac.long_name);
                                        break;
                                    case 'country':
                                        $form.find('input[name=country]').val(ac.long_name);
                                        break;
                                    case 'postal_code':
                                        $form.find('input[name=postal_code]').val(ac.long_name);
                                        break;
                                    case 'administrative_area_level_1':
                                        $form.find('input[name=canton]').val(ac.long_name);
                                        break;
                                    case 'administrative_area_level_2':
                                        $form.find('input[name=area]').val(ac.long_name);
                                        break;
                                    case 'sublocality_level_1':
                                        $form.find('input[name=city]').val(ac.long_name);
                                        break;
                                }
                            }
                        }
//                        adresse_location = country + ' ' + city;
//                        getLocationIndex(adresse_location);
                    } else {
                        window.alert('No results found');
                    }
                } else {
                    window.alert('Geocoder failed due to: ' + status);
                }
            });
        }
    }
    
    function getLocationIndex(address) {

        var lat, lng;
        var geocoder = new google.maps.Geocoder();

        if (address !== '') {
            geocoder.geocode({
                'address': address
            }, function (results, status) {
                if (status === 'OK') {
                    lat = results[0].geometry.location.lat();
                    lng = results[0].geometry.location.lng();
                    $('#index_location_lat').val(lat);
                    $('#index_location_lng').val(lng);
                }
            });
        }
    }

    function previewImage(input) {
        var preview = document.getElementById('preview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                preview.setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.setAttribute('src', 'placeholder.png');
        }
    }



</script>
<style type="text/css">    
    #resto_name{

        text-align:left;
        width: 400px;
        height: 40px;
        font-size: 30px;
        margin-top: 35px;
    }

    SELECT, INPUT[type="text"] {
        box-sizing: border-box;
    }
    SECTION {
        padding: 8px;
        background-color: #f0f0f0;
        overflow: auto;
    }
    SECTION > DIV {
        float: left;
        padding: 4px;
    }
    SECTION > DIV + DIV {
        width: 40px;
        text-align: center;
    }

</style>

@section('js_imports_footer')
<script src="/js/google-map.js"></script>
<script src="/js/search.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&callback=initGoogleAPI&libraries=places" type="text/javascript"></script>
@endsection