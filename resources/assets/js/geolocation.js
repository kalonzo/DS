var userPositionLat = null;
var userPositionLng = null;
var autoCompleteGoogle = null;

function initGoogleAPI(){
    initGeolocation();
}

function initGeolocation(){
    var cookiePositionLat = dsGetCookie('userLat');
    var cookiePositionLng = dsGetCookie('userLng');
    
    if(isEmpty(cookiePositionLat) || isEmpty(cookiePositionLng)){
        var popoverError = null;
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                    userPositionLat = position.coords.latitude * 1;
                    userPositionLng = position.coords.longitude * 1;
                    $(document).trigger('googleGeolocReady');
                    reloadPage({'userLat': userPositionLat, 'userLng': userPositionLng}, function(){
                        $(document).trigger('positionSaved');
                    });
                }, function () {
                    popoverError = "Votre navigateur n'autorise pas la géolocalisation. Veuillez activer les cookies et la géolocalisation pour profiter d'une"
                        +" expérience complète.";
                    alertGeolocationError(popoverError, $('#search_location'));
                }
            );
        } else {
            popoverError = "Votre navigateur ne supporte pas la fonctionnalité de géolocalisation. Veuillez mettre à jour votre navigateur ou en utiliser un"
                        + " autre pour profiter d'une expérience complète.";
            alertGeolocationError(popoverError, $('#search_location'));
        }
    } else {
        userPositionLat = cookiePositionLat * 1;
        userPositionLng = cookiePositionLng * 1;
        $(document).trigger('googleGeolocReady');
    }
}

$(document).on('googleGeolocReady', function(){
    fillUserAddress(userPositionLat, userPositionLng);
    
    var locationAutoCompleteInput = $('#search_location').get(0);
    if(!isEmpty(locationAutoCompleteInput)){
        autoCompleteGoogle = new google.maps.places.Autocomplete(locationAutoCompleteInput, {
            types: ['geocode']
        });
        autoCompleteGoogle.addListener('place_changed', function () {
            var place = autoCompleteGoogle.getPlace();
            relocateUserPosition(place.geometry.location.lat(), place.geometry.location.lng());
        });
    }
});

$('#search_location').focus(function () {
    $(this).select();
});
    
function fillUserAddress(lat, lng){
    var geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function (results, status) {
        switch(status){
            case google.maps.GeocoderStatus.OK:
                var address = results[0].formatted_address;
                $('#search_location').val(address);
                break;
            default:
                console.log(status);
                break;
        }
    });
}

function relocateUserPosition(lat, lng){
    userPositionLat = lat;
    userPositionLng = lng;
    if(typeof map !== 'undefined'){
        var latLng = new google.maps.LatLng(userPositionLat, userPositionLng);
        markerPosition.setPosition(latLng);
        map.setCenter(latLng);
    }
    reloadPage({'userLat': lat, 'userLng': lng}, function(){
        $(document).trigger('positionSaved');
    });
//    saveNewPosition(userPositionLat, userPositionLng);
}

function saveNewPosition(lat, lng){
    $.ajax({
        url: '/ajax/save_position',
        data: {'lat': lat, 'lng': lng}
    })
    .done(function( data ) {
        $(document).trigger('positionSaved');
    });
}

function geolocateMe(){
    var popoverError = null;
    if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                userPositionLat = position.coords.latitude * 1;
                userPositionLng = position.coords.longitude * 1;

                fillUserAddress(userPositionLat, userPositionLng);
                relocateUserPosition(userPositionLat, userPositionLng)
            }, function () {
                    popoverError = "Votre navigateur n'autorise pas la géolocalisation. Veuillez activer les cookies et la géolocalisation pour profiter d'une"
                        +" expérience complète.";
                    alertGeolocationError(popoverError, $('#search_location'));
            }
        );
    } else {
        popoverError = "Votre navigateur ne supporte pas la fonctionnalité de géolocalisation. Veuillez mettre à jour votre navigateur ou en utiliser un"
                    + " autre pour profiter d'une expérience complète.";
        alertGeolocationError(popoverError, $('#search_location'));
    }
}

function alertGeolocationError(error, element){
    $(element).popover({
        container: 'nav',
        title: 'Géolocalisation impossible',
        content: error,
        placement: 'bottom',
        trigger: 'manual',
        toggle: true,
        template: '<div class="popover popover-toggle" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
    }).popover("show")
    ;
}