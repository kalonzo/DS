@extends('layouts.front') 

@section('css_imports')
<link href="/css/establishment.css" rel="stylesheet">
<link href="/libraries/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div id="map"> </div>
<?php
$geocoded = false;
if(checkModel($establishment)){
    echo Form::model($establishment, ['id'=>'feed-establishment', 'url' => '/edit/establishment/'.$establishment->getUuid(), 'files' => true]);
    $address = $establishment->address()->first();
    if(checkModel($address) && $address->getGeocoded()){
        $geocoded = true;
    }
} else {
    echo Form::open(['id'=>'feed-establishment', 'url'=>'/create/establishment', 'files' => true]);
}
?>
    {!! Form::hidden('address[geocoded]', $geocoded, ['id'=>'addressGeocoded']) !!}
    <div class="container-fluid no-gutter">
        <div id="ets-heading" class="row no-gutter no-margin"> 
            <div class="container">
                @if(checkModel($establishment))
                <img id="ets-logo" src="{{ asset($establishment->getDefaultPicture(false)) }}" />
                @else
                <img id="ets-logo" src="<?php echo \App\Utilities\MediaTools::getRandomDsThumbnailPath();?>"/>
                @endif
                <div id="" class="form-inline form-group">
                    {!! Form::text('name', old('name'), ['class'=>'form-control', 'placeholder'=>'Nom de votre restaurant', 'id' => 'ets-name']) !!}
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
            @component('establishment.restaurant.feed.location', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
            @endcomponent
            
            @component('establishment.restaurant.feed.contact', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
            @endcomponent
            
            @component('establishment.restaurant.feed.web', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
            @endcomponent
            
            @component('establishment.restaurant.feed.cooking', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
            @endcomponent
            
            @component('establishment.restaurant.feed.food_specialties', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
            @endcomponent
            
            @component('establishment.restaurant.feed.description', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
            @endcomponent
            
            @component('establishment.restaurant.feed.services', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
            @endcomponent
            
            @component('establishment.restaurant.feed.ambiences', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
            @endcomponent
            
            @component('establishment.restaurant.feed.photos', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
            @endcomponent
            
            @component('establishment.restaurant.feed.videos', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
            @endcomponent
            
            @component('establishment.restaurant.feed.menus', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
            @endcomponent
            
            @component('establishment.restaurant.feed.timetable', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
            @endcomponent
            
            @component('establishment.restaurant.feed.staff', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
            @endcomponent
            
            @component('establishment.restaurant.feed.story', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
            @endcomponent
        </div>
    </div>
    <div id="formControlBottomBand" class="panel">
        <div class="panel-heading" role="tab" id="headingBottomBand">
            <div id="formAjaxFeedback">
                <a role="button" data-toggle="collapse" data-parent="#feed-establishment" href="#form-panel-errors" aria-expanded="false" aria-controls="form-panel-errors">
                    <div id="form-ajax-alert" class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
                        <span class="alert-message">Attention!</span>
                    </div>
                </a>
                <div id="form-ajax-confirm" class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
                    <span class="alert-message">Vos informations ont bien été enregistrées.</span>
                </div>
                <div id="form-ajax-loading" class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <span class="glyphicon glyphicon-repeat normal-right-spinner" aria-hidden="true"></span>
                    <span class="alert-message">Envoi...</span>
                </div>
            </div>
            <div id="formActions" class="pull-right">
                <a class="btn" href="/admin">
                    Retour au dashboard
                </a>
                <?php
                if(isAdmin() && checkModel($establishment)){
                    ?>
                    <button class="btn" id="validSheet" type="button" disabled="disabled">
                        Valider la fiche
                    </button>
                    <?php
                }
                ?>
                {!! Form::button('Enregistrer les modifications', ['class' => 'btn form-data-button', 'type' => 'button']) !!}
            </div>
        </div>
        <div id='form-panel-errors' class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingBottomBand">
            <ul class="panel-body container" id='form-list-errors'>
                
            </ul>
        </div>
    </div>
{!! form::close() !!}
@endsection

<script type="text/javascript">
    function isGeocoded(){
        return $('#addressGeocoded').val();
    }
    
    function setGeocoded(geocoded){
        $('#addressGeocoded').val(geocoded);
    }
    
    function geocodeAddress(triggerELement) {
        var $form = $(triggerELement).parentsInclude('form');
        var city = $form.find('input[name="address[city]"]').val();
        var street = $form.find('input[name="address[street]"]').val();
        var street_number = $form.find('input[name="address[street_number]"]').val();
        var postal_code = $form.find('input[name="address[postal_code]"]').val();
        var country = $form.find('select[name="address[country]"]').children('option:selected').text();
        
        var address = street + ' ' + street_number + ', ' + postal_code + ' ' + city + ' ' + country;
        if (!isEmpty(address)) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                'address': address
            }, function (results, status) {
                if (status === 'OK') {
                    setGeocoded(true);
                    var lat = results[0].geometry.location.lat();
                    var lng = results[0].geometry.location.lng();
                    
                    $form.find('input[name=latitude]').val(lat);
                    $form.find('input[name=longitude]').val(lng);
                    if(!isEmpty(lat) && !isEmpty(lng)){
                        relocateMapPosition(lat, lng);
                    }
    
                    if (results[0]) {
                        var result = results[0];
//                        console.log(results);
                        for (var i = 0; i < result.address_components.length; i++) {
                            var ac = result.address_components[i];
                            if(typeof ac.types[0] != 'undefined'){
                                switch(ac.types[0]){
                                    case 'locality':
                                        $form.find('input[name="address[city]"]').val(ac.long_name);
                                        break;
                                    case 'street_number':
                                        $form.find('input[name="address[street_number]"]').val(ac.long_name);
                                        break;
                                    case 'route':
                                        $form.find('input[name="address[street]"]').val(ac.long_name);
                                        break;
                                    case 'country':
                                        $form.find('input[name="address[country]"]').val(ac.long_name);
                                        break;
                                    case 'postal_code':
                                        $form.find('input[name="address[postal_code]"]').val(ac.long_name);
                                        break;
                                    case 'administrative_area_level_1':
                                        $form.find('input[name="address[region]"]').val(ac.long_name);
                                        break;
                                    case 'administrative_area_level_2':
//                                        $form.find('input[name="address[district]"]').val(ac.long_name);
                                        break;
                                    case 'sublocality_level_1':
                                        $form.find('input[name="address[city]"]').val(ac.long_name);
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
    
    function relocateMapPosition(lat, lng){
        var latLng = new google.maps.LatLng(lat, lng);
        if(typeof map !== 'undefined'){
            markerPosition.setPosition(latLng);
            map.setCenter(latLng);
        }
    }
    
    function closeTimeSlot(triggerElement){
        $(triggerElement).parentsInclude('.timetable-col').find('select').val(-1);
    }
    
    function toggleNoBreak(triggerElement){
        var checked = $(triggerElement).is(':checked');
        var $column = $(triggerElement).parentsInclude('.timetable-col');
        if(checked){
            $column.find('select').attr('disabled', 'disabled');
            $column.find('a.close-timeslot').addClass('disabled');
        } else {
            $column.find('select').removeAttr('disabled');
            $column.find('a.close-timeslot').removeClass('disabled');
        }
    }
    
    function duplicateTimeSlots(triggerElement){
        var $timetableGrid = $(triggerElement).parentsInclude('#timetable-grid');
        var startTimeAmRef = $timetableGrid.find('select[name="openingHours[1][1][start]"]').val();
        var endTimeAmRef = $timetableGrid.find('select[name="openingHours[1][1][end]"]').val();

        var startTimePmRef = $timetableGrid.find('select[name="openingHours[1][2][start]"]').val();
        var endTimePmRef = $timetableGrid.find('select[name="openingHours[1][2][end]"]').val();

        var hasNoBreakRef = $timetableGrid.find('input[name="openingHours[1][1][no_break]"]').is(':checked');
        
        for(var $i=2; $i<=7; $i++){
            $timetableGrid.find('select[name="openingHours['+$i+'][1][start]"]').val(startTimeAmRef);
            $timetableGrid.find('select[name="openingHours['+$i+'][1][end]"]').val(endTimeAmRef);
        
            $timetableGrid.find('select[name="openingHours['+$i+'][2][start]"]').val(startTimePmRef);
            $timetableGrid.find('select[name="openingHours['+$i+'][2][end]"]').val(endTimePmRef);
            
            var currentHasNoBreak = $timetableGrid.find('input[name="openingHours['+$i+'][1][no_break]"]').is(':checked');
            if(currentHasNoBreak !== hasNoBreakRef){
                $timetableGrid.find('input[name="openingHours['+$i+'][1][no_break]"]').click();
            }
        }
    }

    var autoCompleteArea;
    document.addEventListener("DOMContentLoaded", function(event) { 
        $(document).on('googleGeolocReady', function(){
            var $form = $('#feed-establishment');
            if(checkExist($form)){
                var lat = $form.find('[name=latitude]').val()*1;
                var lng = $form.find('[name=longitude]').val()*1;
                if(!isNaN(lat) && !isNaN(lng)){
                    relocateMapPosition(lat, lng);
                } else {
                    relocateMapPosition(46.204549, 6.144775);
                }
            }
                        
            var $areaAutoCompleteInput = $('[name="address[district]"]');
            if(!isEmpty($areaAutoCompleteInput)){
                var service = new google.maps.places.AutocompleteService();
                var placeIds = [];
                var sourceArray = [];
                $areaAutoCompleteInput.autocomplete({
                    source: function(request, response){
                        sourceArray = [];
                        placeIds = [];
                        var city = $areaAutoCompleteInput.parentsInclude('form').find('[name="address[city]"]').val();
                        var country = $areaAutoCompleteInput.parentsInclude('form').find('select[name="address[country]"]').children('option:selected').text()
                        var lat = $areaAutoCompleteInput.parentsInclude('form').find('[name=latitude]').val()*1;
                        var lng = $areaAutoCompleteInput.parentsInclude('form').find('[name=longitude]').val()*1;
                        var inputValue = city+' '+country + ' ' + request.term;
                        var options = { 
                                input: inputValue, 
                                types: ['geocode'], 
                            };
                        service.getQueryPredictions(options, function(predictions, status) {
                            if (status != google.maps.places.PlacesServiceStatus.OK) {
                                console.log(status);
                            } else {
                                predictions.forEach(function(prediction) {
                                    if(typeof prediction.types != 'undefined' && typeof prediction.types[0] != 'undefined'){
                                        var type = prediction.types[0];
                                        switch(type){
                                            case 'neighborhood':
                                            case 'colloquial_area':
                                            case 'sublocality_level_1':
                                            case 'sublocality_level_2':
                                            case 'sublocality_level_3':
                                            case 'sublocality_level_4':
                                            case 'sublocality_level_5':
                                                var placeId = prediction.place_id;
                                                if(typeof placeIds[placeId] == 'undefined'){
                                                    placeIds[placeId] = placeId;
                                                    sourceArray.push(prediction.structured_formatting.main_text);
                                                }
                                            break;
                                        }
                                    }
                                });
                            }
                            if(sourceArray.length === 0){
                                sourceArray.push("Aucune correspondance trouvée pour la ville et le pays sélectionnés");
                            }
                            response(sourceArray);
                        });
                    },
                    minLength: 2,
                    delay: 0,
                }).autocomplete("instance")._create = function() {
                    this._super();
                    this.widget().menu({
                        items: ".ui-menu-item" 
                    });
                }._renderMenu = function (ul, items) {
                    var that = this;
                    $(ul).attr('id', 'searchAreaDropdown');
                    $.each(items, function (index, item) {
                        that._renderItemData(ul, item);
                    });
                };
            }
        });
        
        $('body').on('click', 'form#feed-establishment .form-data-button', function(e){
            $('#form-list-errors').empty();
            $('#form-panel-errors').collapse('hide');

            var $form = $('form#feed-establishment');
            $form.find('#form-ajax-confirm').hide();
            $form.find('#form-ajax-alert').hide();
            $form.find('#form-ajax-loading').show();
            
            if(!isGeocoded()){
                var callbacks = $.Callbacks();
                callbacks.add(
                    geocodeAddress($form.children().get(0))
                );
                callbacks.fire();
            }
        });
        
        $('body').on('ajaxFormFailed', 'form#feed-establishment', function(e, data){
            var errors = data.responseJSON;
            
            $(this).find('#form-ajax-loading').hide();
            $(this).find('#form-ajax-confirm').hide();
            
            var $formListErrors = $('#form-list-errors');
            $formListErrors.empty();
            if(!errors.error){
                var nbInputErrors = Object.keys(errors).length;
                var message = "Veuillez corriger votre saisie, nous avons détecté " + nbInputErrors + " erreur(s).";
                var $alert = $(this).find('#form-ajax-alert');
                $alert.find('.alert-message').empty().html(message);
                $alert.show();
                $.each(errors, function (input, messages) {
                    $.each(messages, function (key, message) {
                        $formListErrors.append('<li>'+message+'</li>');
                    });
                });
            }
        });
        $('body').on('click', '#form-ajax-alert .close', function(e){
            e.stopPropagation();
            $('#form-ajax-alert').hide();
        });
        
        $('body').on('change', '#ets-location input, #ets-location select', function(e){
            setGeocoded(false);
        });
        
        $('body').on('ajaxFormSubmitted', 'form#feed-establishment', function(e, data){
            $(this).find('#form-ajax-loading').hide();
            $(this).find('#form-ajax-alert').hide();
            $(this).find('#form-ajax-confirm').show();
        });
        
        <?php
        if(isAdmin() && checkModel($establishment)){
            ?>
            $('body').on('click', '#validSheet', function(e){
                var confirmValid = confirm("Veuillez confirmer la validation de la fiche.");
                if(confirmValid){
                    $('#form-list-errors').empty();
                    $('#form-panel-errors').collapse('hide');

                    var $form = $('form#feed-establishment');
                    $form.find('#form-ajax-confirm').hide();
                    $form.find('#form-ajax-alert').hide();
                    $form.find('#form-ajax-loading').show();
                    
                    var ajaxParams = {};
                    $.ajax({
                        url: '/admin/valid_establishment/{!!$establishment->getUuid()!!}',
                        data: ajaxParams,
                        dataType: 'json',
                        method: 'POST',
                        success: function( data ) {
                            if(data.success){
                                $form.find('#form-ajax-loading').hide();
                                $form.find('#form-ajax-alert').hide();
                                $form.find('#form-ajax-confirm').show();
                            } else {
                                $form.find('#form-ajax-loading').hide();
                                $form.find('#form-ajax-confirm').hide();
                                
                                if(data.error){
                                    var $formListErrors = $('#form-list-errors');
                                    $formListErrors.empty();
                                    var $alert = $form.find('#form-ajax-alert');
                                    $alert.find('.alert-message').empty().html(data.error);
                                    $alert.show();
                                }
                            }
                        },
                        error: function( data ) {
                            $form.find('#form-ajax-loading').hide();
                            $form.find('#form-ajax-confirm').hide();

                            var $formListErrors = $('#form-list-errors');
                            $formListErrors.empty();
                            var $alert = $('form#feed-establishment').find('#form-ajax-alert');
                            $alert.find('.alert-message').empty().html(data);
                            $alert.show();
                        },
                    });
                }
            });
            
            $(window).on("scroll", function() {
                var clientHeight = document.body.clientHeight;
                var documentHeight = $(document).height();
                var scrollPosition = $(window).scrollTop();
                if (scrollPosition === (documentHeight - clientHeight)) {
                    $('#validSheet').removeAttr('disabled');
                } else {
                    if(!$('#validSheet').is(':disabled')){
                        $('#validSheet').attr('disabled', 'disabled');
                    }
                }
            });
            <?php
        }
         ?>   
    });
    
    function addCollectionItem(triggerButton, callback){
        var $form = $(triggerButton).parentsInclude('form');
        var $container = $(triggerButton).parentsInclude('.subform-collection');
        var $reloader = $($container.attr('data-subform-reloader'));

        if(checkExist($reloader)){
            var fd = new FormData();
            $container.find('input').each(function(){
                if($(this).attr('type') === 'file'){
                    var fileInputName = $(this).attr('name');
                    $.each($(this)[0].files, function(i, file) {
                        fd.append(fileInputName, file);
                    });
                } else {
                    fd.append($(this).attr('name'), $(this).val());
                }
            });
            fd.append('action', $container.attr('data-subform-action'));
            $.ajax({
                url: $form.attr('action') + "/ajax",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    if(data.success){
                        $reloader.empty().append(data.content);
                    }
                    if(typeof callback == 'function'){
                        callback(data);
                    }
                },
                error: function (data) {
                    console.log(data);
                    if(typeof callback == 'function'){
                        callback(data);
                    }
                }
            });
        }
    }

    function removeCollectionItem(triggerButton, idItem, action){
        var $form = $(triggerButton).parentsInclude('form');
        var $reloader = $($(triggerButton).attr('data-subform-reloader'));

        if(checkExist($reloader)){
            $.ajax({
                url: $form.attr('action') + "/ajax",
                method: "POST",
                data: {
                    action: action, 
                    id_item: idItem, 
                },
                success: function (data) {
                    if(data.success){
                        $reloader.empty().append(data.content);
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    }
</script>
<script src="/js/consoleJqueryDevTest.js"></script>
@section('js_imports_footer')
<script src="/js/google-map.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&callback=initGoogleAPI&libraries=places" type="text/javascript"></script>
<script src="/libraries/bootstrap-fileinput/js/plugins/sortable.min.js"></script>

<script src="/libraries/bootstrap-fileinput/js/fileinput.min.js"></script>
<script src="/libraries/ckeditor/ckeditor.js"></script>
@endsection
