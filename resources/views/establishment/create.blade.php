@extends('layouts.front') 
@section('js_imports_head')

@endsection

@section('content')

@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

@if(count($errors))

<div class="alert alert-danger">
    <strong>Erreur!</strong> Les informations saisies ne sont pas correct.
    <br/>
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>

@endif
<div class="container">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    @if(isset($establishment))
    {{ Form::model($establishment, ['route' => 'establishment']) }}
    @else
    {!! Form::open(['route'=>'establishment.store']) !!}
    @endif

    <div class="row heading">  

        <div class="col-md-4">
            <img id="preview" src="placeholder.png" height="100px" width="100px" />

            {!! Form::file('id_logo', array(
            'class' => 'name',
            'onchange' => 'previewImage(this)'
            )) !!} 
        </div>
        <div class="col-md-8 {{ $errors->has('name') ? 'has-error' : '' }}">
            {!! Form::text('name', old('name'), [
            'class'=>'form-control',
            'placeholder'=>'Restaurant Nom de  votre restaurant',
            'id'=>'logo'
            ]) !!}

        </div>
    </div>    
    <div class="accordion" id="accordionid">
        <div class="accordion-group">

            <div class="row accordion-heading">
                <div class="accordion-inner">	
                            <img src="../../assets/images_form/position.png" alt=""/>
                        </div>
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionid" href="index.html#one">
                    <h5>Emplacement</h5>
                </a>
            </div>
            <div id="one" class="row">
                <div class="accordion-inner">
                    <!-- Saisie de l'adresse de l'établissemntnt-->
                    <div class="row">
                        <div class="col-md-8 accordion-inner">
                            {!! Form::label('* Addresse') !!}	
                            <div class="input-group {{ $errors->has('street') ? 'has-error' : '' }}">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                {!! Form::text('street', old('street'), [
                                'class'=>'form-control',
                                'placeholder'=>'',
                                'id'=>'street'
                                ]) !!}
                            </div>	
                        </div>

                        <div class="col-md-4  accordion-inner">
                            {!! Form::label('* N° Rue') !!}

                            <div class="input-group {{ $errors->has('street_number') ? 'has-error' : '' }}">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                {!! Form::text('street_number', old('street_number'), ['class'=>
                                'form-control', 
                                'placeholder'=>'',
                                'id'=>'street_number'
                                ]) !!}
                            </div>

                        </div>                   
                    </div>

                    <div class="row">
                        <div class="col-md-8  accordion-inner">
                            {!! Form::label('  Addresse 2') !!}

                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                {!! Form::text('address_additional', old('address_additional'), [
                                'class'=>'form-control',
                                'placeholder'=>'',
                                'id'=>'street'
                                ]) !!}
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4  accordion-inner">
                            {!! Form::label('* NPA') !!}

                            <div class="input-group {{ $errors->has('postal_code') ? 'has-error' : '' }}">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                {!! Form::text('postal_code', old('postal_code'), [
                                'class'=>'form-control', 
                                'placeholder'=>'',
                                'id'=>'postal_code'
                                ]) !!}
                            </div>

                        </div>
                        <div class="col-md-8  accordion-inner">
                            {!! Form::label('* Localité') !!}

                            <div class="input-group {{ $errors->has('city') ? 'has-error' : '' }}">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                {!! Form::text('city', old('city'), ['class'=>
                                'form-control',
                                'placeholder'=>'',
                                'id'=>'city'
                                ]) !!}
                            </div>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6  accordion-inner">
                            {!! Form::label('* Canton/Départements') !!}

                            <div class="input-group {{ $errors->has('country') ? 'has-error' : '' }}">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                {!! Form::text('canton', old('country'), [
                                'class'=>'form-control', 
                                'placeholder'=>'',
                                'id'=>'canton'
                                ]) !!}
                            </div>

                        </div>

                        <div class="col-md-6  accordion-inner">
                            {!! Form::label('* Pays') !!}

                            <div class="input-group {{ $errors->has('country') ? 'has-error' : '' }}">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                {!! Form::text('country', old('country'), [
                                'class'=>'form-control', 
                                'placeholder'=>'',
                                'id'=>'country'
                                ]) !!}
                                <p id="demo"></p>
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6  accordion-inner">
                            {!! Form::label('* Latitude') !!}

                            <div class="input-group {{ $errors->has('latitude') ? 'has-error' : '' }}">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                {!! Form::text('latitude', old('latitude'), [
                                'class'=>'form-control',
                                'placeholder'=>'',
                                'id'=> 'lat'
                                ]) !!}
                            </div>

                        </div>           
                        <div class="col-md-6  accordion-inner">
                            {!! Form::label('* Longitude') !!}

                            <div class="input-group {{ $errors->has('longitude') ? 'has-error' : '' }}">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                {!! Form::text('longitude', old('longitude'), ['class'=>
                                'form-control', 'placeholder'=>'',
                                'id'=>'lng'
                                ]) !!}
                            </div>
                            <div>
                                <input id="localize" type="button" value="Chercher la direction de mon restaurant"  onclick="getCoords()">
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            {!! Form::submit('Valiser votre position!', 
                            array('class'=>'btn btn-primary')) !!}
                        </div>

                    </div>
                </div>
            </div> 

            <div class="row accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionid" href="index.html#two">
                    <h5>Contacts</h5>
                </a>
            </div>
            <div id="two" class="row collapse">
                <div class="row accordion-inner">
                    <div class="row">
                        <div class="col-md-6  accordion-inner">
                            {!! Form::label('* Téléphone pour réservation') !!}
                            <div class="input-group {{ $errors->has('number') ? 'has-error' : '' }}">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                {!! Form::text('number', old('number'), [
                                'class'=>'form-control', 
                                'placeholder'=>'',
                                'id'=>'number'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-6  accordion-inner">
                            {!! Form::label('* Téléphone de contact') !!}

                            <div class="input-group {{ $errors->has('number') ? 'has-error' : '' }} " >
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                {!! Form::text('phone', old('number'), ['class'=>
                                'form-control',
                                'placeholder'=>'',
                                'id'=>'phone'
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6  accordion-inner">
                            {!! Form::label('* Fax') !!}
                            <div class="input-group ">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                {!! Form::text('fax', old('fax'), [
                                'class'=>'form-control', 
                                'placeholder'=>'',
                                'id'=>'fax'
                                ]) !!}

                            </div>
                        </div>
                        <div class="col-md-6  accordion-inner">
                            {!! Form::label('* Mobile') !!}

                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
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
            <div class="row accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionid" href="index.html#three">
                    <h5>www</h5>
                </a>
            </div>
            <div id="three" class="row collapse">
                <div class="col-md-12 accordion-inner">
                    <div class="row">
                        <div class="accordion-inner">
                            {!! Form::label('* e-mail') !!}
                            <div class="input-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>  
                                {!! Form::text('email', old('email'), [
                                'class'=>'form-control', 
                                'placeholder'=>''
                                ]) !!}
                            </div>
                        </div>          
                        <div class="accordion-inner">
                            {!! Form::label('* Site web de l établissement') !!}

                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>  
                                {!! Form::text('site_url', old('site_url'), ['class'=>
                                'form-control', 'placeholder'=>
                                'Enter Message']) !!}
                            </div>

                        </div>    
                    </div>

                </div>
            </div>
            <div class="row accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionid" href="index.html#fourth">
                    <h5>Types de cuisines</h5>
                </a>
            </div>
            <div id="fourth" class="row collapse">
                <div class="col-md-12  accordion-inner">
                    <section class="container-fluid">
                        <div>
                            <select id="leftValues" size="5" multiple>

                            </select>
                        </div>
                        <div>
                            <input type="button" id="btnRight" value="&gt;&gt;"/>
                            <input type="button" id="btnLeft" value="&lt;&lt;"/>
                        </div>
                        <div>
                            <select id="rightValues" size="4" multiple>
                                <option>Régional</option>
                                <option>Végétarienne</option>
                                <option>Grillade aux feu de bois</option>
                            </select>
                            <div>
                                <input type="text" id="txtRight" />
                            </div>
                        </div>
                    </section>   

                </div>
            </div>
            <div class="row accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionid" href="index.html#five">
                    <h5>Spécialité</h5>
                </a>
            </div>
            <div id="five" class="row collapse">
                <div class="col-md-12 accordion-inner">
                    <div class="col-md-12  accordion-inner">
                        {!! Form::label('* Vous pouvez enregistrer jusqu\'a 5 spécialité') !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                            {!! Form::text('specialiter', old('specialiter'), [
                            'class'=>'form-control', 
                            'placeholder'=>'',
                            'id'=>'specialiter'
                            ]) !!}<input type="button" class="btn" id="btnLeft" value="Enregistrer"/>
                        </div>

                    </div>
                </div>
            </div>  
            <div class="row accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionid" href="index.html#sixth">
                    <h5>Description détaillé</h5>
                </a>
            </div>
            <div id="sixth" class="row collapse">
                <div class="accordion-inner">
                    <div class="col-md-12  accordion-inner">
                        {!! Form::label('Description :') !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                            {!! Form::textarea('description', old('description'), ['class'=>
                            'form-control', 'placeholder'=>
                            'Enter Name']) !!}  
                        </div>
                    </div>
                </div>
            </div>  
            <div class="row accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionid" href="index.html#seven">
                    <h5>Services</h5>
                </a>
            </div>
            <div id="seven" class="row collapse">
                <div class="row accordion-inner">

                    <section class="col-md-12 container-fluid">
                        <div>
                            <select id="leftValues" size="5" multiple>

                            </select>
                        </div>
                        <div>
                            <input type="button" id="btnLeft" value="&lt;&lt;"/>
                            <input type="button" id="btnRight" value="&gt;&gt;"/>
                        </div>
                        <div>
                            <select id="rightValues" size="4" multiple>
                                <option>Poulet Masala</option>
                                <option>Pizza</option>
                                <option>Fondue</option>
                            </select>
                            <div>
                                <input type="text" id="txtRight" />
                            </div>
                        </div>
                    </section>          
                </div> 
            </div>
        </div>  
        <div class="row accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionid" href="index.html#eight">
                <h5>Cardre & Ambiance</h5>
            </a>
        </div>
        <div id="eight" class="row collapse">
            <div class="accordion-inner">
                <div class="form-group  accordion-inner">
                    {!! Form::label('Description :') !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                        {!! Form::textarea('description', old('description'), ['class'=>
                        'form-control', 'placeholder'=>
                        'Enter Name']) !!}  
                    </div>
                </div>
            </div>
        </div>  
    </div>
    {!! form::close() !!}
</div>

@endsection

<script>
    
    function getCoords() {

        var city = $('#city').val();
        var street = $('#street').val();
        var street_number = $('#street_number').val();
        var postal_code = $('#postal_code').val();
        var lat, lng;


        var geocoder = new google.maps.Geocoder();
        address = street + ' ' + street_number + ', ' + postal_code + ' ' + city;

        if (address !== '') {
            // Llamamos a la función geodecode pasandole la dirección que hemos introducido en la caja de texto.
            geocoder.geocode({
                'address': address
            }, function (results, status) {
                if (status === 'OK') {
                    lat = results[0].geometry.location.lat();
                    lng = results[0].geometry.location.lng();
                    // On affiche les données récuperer par l'addresse
                    $('#lat').val(lat);
                    $('#lng').val(lng);
                    //reverse geocoder
                    geocodeLatLng(geocoder, lat, lng);
                }
            });
        }
    }


    function geocodeLatLng(geocoder, lat, lng) {
        var adresse, lat1, lng1, adresse_location;

        var latlng = {
            lat: parseFloat(lat),
            lng: parseFloat(lng)
        };
        geocoder.geocode({
            'location': latlng
        }, function (results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    var result = results[0];
                    //look for locality tag and administrative_area_level_1
                    var city, street_number, street, country, postal_code, canton;

                    for (var i = 0, len = result.address_components.length; i < len; i++) {
                        var ac = result.address_components[i];
                        if (ac.types.indexOf("locality") >= 0)
                            city = ac.long_name;
                        if (ac.types.indexOf("street_number") >= 0)
                            street_number = ac.long_name;
                        if (ac.types.indexOf("route") >= 0)
                            street = ac.long_name;
                        if (ac.types.indexOf("country") >= 0)
                            country = ac.long_name;
                        if (ac.types.indexOf("postal_code") >= 0)
                            postal_code = ac.long_name;
                        if (ac.types.indexOf("administrative_area_level_1") >= 0)
                            canton = ac.long_name;
                    }

                    //  alert(city+country+street+street_number);
                    //on remplie les champs addresse avec les variable google 
                    $('#street').val(street);
                    $('#street_number').val(street_number);
                    $('#city').val(city);
                    $('#country').val(country);
                    $('#postal_code').val(postal_code);
                    $('#canton').val(canton);


                    //on récupére l'index location
                    // var locationindex ;
                    //   locationindex = country ' ' + city;
                    adresse_location = country + ' ' + city;
                    getLocationIndex(adresse_location);

                } else {
                    window.alert('No results found');
                }
            } else {
                window.alert('Geocoder failed due to: ' + status);
            }
        });

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


    function getLocationIndex(address) {

        var lat, lng;
        var geocoder = new google.maps.Geocoder();

        if (address !== '') {
            // Llamamos a la función geodecode pasandole la dirección que hemos introducido en la caja de texto.
            geocoder.geocode({
                'address': address
            }, function (results, status) {
                if (status === 'OK') {
                    lat = results[0].geometry.location.lat();
                    lng = results[0].geometry.location.lng();
                    //alert("Centrer localiser ");
                    //alert(lat + ' - ' + lng);
                    // On affiche  les données récuperer par l'addresse
                    $('#index_location_lat').val(lat);
                    $('#index_location_lng').val(lng);

                    // alert($('#index_location_lat').val());
                    // alert($('#index_location_lng').val());
                }
            });
        }
    }



</script>
<style type="text/css">    
    #logo{
        font-size: 30px;
        height: 40px;
        width: 100%;
    }    

    .heading{
        background-color:#fff;
        height: 160px;  
        width: 100%;
    }    

    .accordion-heading
    {
        background-color:#848484;
        height: 40px;
    }
    .accordion-heading:hover
    {
        background-color:#000;
        -webkit-transition: all 0.5s ease-in-out;
        -moz-transition: all 0.5s ease-in-out;
        -o-transition: all 0.5s ease-in-out;
        transition: all 0.5s ease-in-out;
    }
    .accordion-heading > a
    {
        color:#FFF; 
        text-decoration:none; 
        text-transform:uppercase;
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
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&libraries=places" type="text/javascript"></script>
@endsection