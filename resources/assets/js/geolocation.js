var userPositionLat = null;
var userPositionLng = null;
var autoCompleteGoogle = null;

function initGoogleAPI(){
    initGeolocation();
}

function initGeolocation(){
    var cookiePositionLat = dsGetCookie('userLat');
    var cookiePositionLng = dsGetCookie('userLng');
    
        console.log(cookiePositionLng);
    
    if(isEmpty(cookiePositionLat) || isEmpty(cookiePositionLng)){
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                    userPositionLat = position.coords.latitude * 1;
                    userPositionLng = position.coords.longitude * 1;
                    $(document).trigger('googleGeolocReady');
    //                saveNewPosition(userPositionLat, userPositionLng);
                    reloadPage({'userLat': userPositionLat, 'userLng': userPositionLng}, function(){
                        $(document).trigger('positionSaved');
                    });
                }, function () {
                    console.log("Erreur lors de la géolocalisation");
                }
            );
        } else {
            console.log("Browser doesn't support Geolocation");
        }
    } else {
        userPositionLat = cookiePositionLat * 1;
        userPositionLng = cookiePositionLng * 1;
        $(document).trigger('googleGeolocReady');
    }
//    saveNewPosition(userPositionLat, userPositionLng);
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
    if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                userPositionLat = position.coords.latitude * 1;
                userPositionLng = position.coords.longitude * 1;

                fillUserAddress(userPositionLat, userPositionLng);
                relocateUserPosition(userPositionLat, userPositionLng)
            }, function () {
                console.log("Erreur lors de la géolocalisation");
            }
        );
    } else {
        console.log("Browser doesn't support Geolocation");
    }
}