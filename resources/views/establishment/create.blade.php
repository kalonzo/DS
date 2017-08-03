@extends('layouts.front') 

@section('css_imports')
<link href="/css/establishment.css" rel="stylesheet">
@endsection

@section('js_imports_head')

@endsection

@section('content')

<div id="map"> </div>

@if(isset($establishment))
    //{!! Form::model($establishment) !!}
    {!! Form::model(array($establishment,'action' => 'EstablishmentController@update')) !!}
@else
    {!! Form::open(['url'=>'/establishment', 'method' => 'put']) !!}
@endif
    <input  type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="container-fluid no-gutter">
        <div id="ets-heading" class="row no-gutter no-margin"> 
            <div class="container">
                <img id="ets-logo" src="/img/images_ds/imagen-DS-1.jpg"/>
                {!! Form::file('url', array('class' => 'name', 'onchange' => 'previewImage(this)')) !!} 
                <div id="" class="form-inline form-group">
                    {!! Form::text('establishment[name]', old('name'), ['class'=>'form-control', 'placeholder'=>'Nom de votre restaurant', 'id' => 'ets-name']) !!}
                    <!--<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>-->
                </div>
            </div>
        </div>  
        
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

        <div class="panel-group form-accordion" id="establishment_form_accordion" role="tablist" aria-multiselectable="true">
            @component('establishment.form.location', ['form_data' => $form_data])
            @endcomponent
            
            @component('establishment.form.contact', ['form_data' => $form_data])
            @endcomponent
            
            @component('establishment.form.web', ['form_data' => $form_data])
            @endcomponent
            
            @component('establishment.form.cooking', ['form_data' => $form_data])
            @endcomponent
            
            @component('establishment.form.food_specialties', ['form_data' => $form_data])
            @endcomponent
            
            @component('establishment.form.description', ['form_data' => $form_data])
            @endcomponent
            
            @component('establishment.form.services', ['form_data' => $form_data])
            @endcomponent
            
            @component('establishment.form.ambiences', ['form_data' => $form_data])
            @endcomponent
            
            @component('establishment.form.galleries', ['form_data' => $form_data])
            @endcomponent
            
            @component('establishment.form.videos', ['form_data' => $form_data])
            @endcomponent
            
            @component('establishment.form.menus', ['form_data' => $form_data])
            @endcomponent
            
            @component('establishment.form.timetable', ['form_data' => $form_data])
            @endcomponent
            
            @component('establishment.form.staff', ['form_data' => $form_data])
            @endcomponent
            
            @component('establishment.form.story', ['form_data' => $form_data])
            @endcomponent
        </div>
    </div>

    <div id="formControlBottomBand">
       {!! Form::submit('Valider', array('class'=>'btn pull-right')) !!}
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
                    
                    // TEST pour recherche de quartier
                    geocoder.geocode({'location': {lat: lat, lng: lng}}, function(deepResults, deepStatus) {
                        if (deepStatus === 'OK') {
                            console.log(deepResults);
                        }
                    });
    
                    if (results[0]) {
                        var result = results[0];
//                        console.log(results);
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
                    } else {
                        window.alert('No results found');
                    }
                } else {
                    window.alert('Geocoder failed due to: ' + status);
                }
            });
        }
    }
    
    function goToNextAccordion(triggerElement){
        var $currentPanel = $(triggerElement).parentsInclude('.panel');
        if(checkExist($currentPanel)){
            $currentPanel.next('.panel').find('a[data-toggle=collapse]').click();
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

@section('js_imports_footer')
<script src="/js/google-map.js"></script>
<script src="/js/search.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&callback=initGoogleAPI&libraries=places" type="text/javascript"></script>
@endsection