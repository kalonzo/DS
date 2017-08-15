@extends('layouts.front') 

@section('css_imports')
<link href="/css/establishment.css" rel="stylesheet">
<link href="/libraries/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div id="map"> </div>
@if(checkModel($establishment))
{!! Form::model($establishment, ['id'=>'feed-establishment', 'url' => '/establishment/'.$establishment->getUuid(), 'method' => 'PUT', 'files' => true]) !!}
@else
{!! Form::open(['id'=>'feed-establishment', 'url'=>'/establishment', 'method' => 'put', 'files' => true]) !!}
@endif
<div class="container-fluid no-gutter">
    <div id="ets-heading" class="row no-gutter no-margin"> 

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
        @component('establishment.form.credentials', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
        @endcomponent   

        @component('establishment.form.business_categories', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
        @endcomponent   

        @component('establishment.form.subscription', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
        @endcomponent   

        @component('establishment.form.mode_payment', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
        @endcomponent   

        @component('establishment.form.info_bill', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
        @endcomponent   

    </div>
</div>
<div id="formControlBottomBand">
    {!! Form::submit('Valider', array('class'=>'btn pull-right')) !!}
</div>
{!! form::close() !!}
@endsection

<script type="text/javascript">
    addressGeocoded = false;

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
                    addressGeocoded = true;
                    var lat = results[0].geometry.location.lat();
                    var lng = results[0].geometry.location.lng();

                    $form.find('input[name=latitude]').val(lat);
                    $form.find('input[name=longitude]').val(lng);
                    if (!isEmpty(lat) && !isEmpty(lng)) {
                        relocateMapPosition(lat, lng);
                    }

                    if (results[0]) {
                        var result = results[0];
//                        console.log(results);
                        for (var i = 0; i < result.address_components.length; i++) {
                            var ac = result.address_components[i];
                            if (typeof ac.types[0] != 'undefined') {
                                switch (ac.types[0]) {
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

    function goToNextAccordion(triggerElement) {
        var $currentPanel = $(triggerElement).parentsInclude('.panel');
        if (checkExist($currentPanel)) {
            $currentPanel.next('.panel').find('a[data-toggle=collapse]').click();
        }
    }

    function relocateMapPosition(lat, lng) {
        var latLng = new google.maps.LatLng(lat, lng);
        if (typeof map !== 'undefined') {
            markerPosition.setPosition(latLng);
            map.setCenter(latLng);
        }
    }


    var autoCompleteArea;
    document.addEventListener("DOMContentLoaded", function (event) {
        $(document).on('googleGeolocReady', function () {
            var $form = $('#feed-establishment');
            if (checkExist($form)) {
                var lat = $form.find('[name=latitude]').val() * 1;
                var lng = $form.find('[name=longitude]').val() * 1;
                if (!isEmpty(lat) && !isEmpty(lng)) {
                    addressGeocoded = true;
                    relocateMapPosition(lat, lng);
                }
            }

            $form.on('change', 'input, select', function () {
                addressGeocoded = false;
            });

            $form.on('submit', function () {
                if (!addressGeocoded) {
                    var callbacks = $.Callbacks();
                    callbacks.add(
                            geocodeAddress($form.children().get(0))
                            );
                    callbacks.add(function () {
                        if (!addressGeocoded) {
                            return false;
                        } else {
                            $form.submit();
                        }
                    });
                    callbacks.fire();
                }
                return true;
            });

            var $areaAutoCompleteInput = $('[name="address[district]"]');
            if (!isEmpty($areaAutoCompleteInput)) {
                var service = new google.maps.places.AutocompleteService();
                var placeIds = [];
                var sourceArray = [];
                $areaAutoCompleteInput.autocomplete({
                    source: function (request, response) {
                        sourceArray = [];
                        placeIds = [];
                        var city = $areaAutoCompleteInput.parentsInclude('form').find('[name="address[city]"]').val();
                        var country = $areaAutoCompleteInput.parentsInclude('form').find('select[name="address[country]"]').children('option:selected').text()
                        var lat = $areaAutoCompleteInput.parentsInclude('form').find('[name=latitude]').val() * 1;
                        var lng = $areaAutoCompleteInput.parentsInclude('form').find('[name=longitude]').val() * 1;
                        var inputValue = city + ' ' + country + ' ' + request.term;
                        var options = {
                            input: inputValue,
                            types: ['geocode'],
                        };
                        service.getQueryPredictions(options, function (predictions, status) {
//                            console.log(predictions);
                            if (status != google.maps.places.PlacesServiceStatus.OK) {
                                console.log(status);
                            } else {
                                predictions.forEach(function (prediction) {
                                    if (typeof prediction.types != 'undefined' && typeof prediction.types[0] != 'undefined') {
                                        var type = prediction.types[0];
                                        switch (type) {
                                            case 'neighborhood':
                                            case 'colloquial_area':
                                            case 'sublocality_level_1':
                                            case 'sublocality_level_2':
                                            case 'sublocality_level_3':
                                            case 'sublocality_level_4':
                                            case 'sublocality_level_5':
                                                var placeId = prediction.place_id;
                                                if (typeof placeIds[placeId] == 'undefined') {
                                                    placeIds[placeId] = placeId;
                                                    sourceArray.push(prediction.structured_formatting.main_text);
                                                }
                                                break;
                                        }
                                    }
                                });
                            }
                            if (sourceArray.length === 0) {
                                sourceArray.push("Aucune correspondance trouvée pour la ville et le pays sélectionnés");
                            }
                            response(sourceArray);
                        });
                    },
                    minLength: 2,
                    delay: 0,
                }).autocomplete("instance")._create = function () {
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
    });
</script>

@section('js_imports_footer')
<script src="/js/google-map.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&callback=initGoogleAPI&libraries=places" type="text/javascript"></script>
<script src="/libraries/bootstrap-fileinput/js/fileinput.min.js"></script>
@endsection
