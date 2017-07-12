var userPositionLat = null;
var userPositionLng = null;

function initGoogleAPI(){
    initGeolocation();
}

function initGeolocation(){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            userPositionLat = position.coords.latitude * 1;
            userPositionLng = position.coords.longitude * 1;
            $(document).trigger('googleGeolocReady');
            
            }, function () {
                console.log("Erreur lors de la géolocalisation");
            }
        );
    } else {
        console.log("Browser doesn't support Geolocation");
    }
}

$(document).on('googleGeolocReady', function(){
    var geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(userPositionLat, userPositionLng);
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
    
    var locationAutoCompleteInput = $('#search_location').get(0);
    if(!isEmpty(locationAutoCompleteInput)){
        var autocomplete = new google.maps.places.Autocomplete(locationAutoCompleteInput, {
            types: ['geocode']
        });
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            relocateUserPosition(place.geometry.location.lat(), place.geometry.location.lng());
        });
    }
});

$('#search_location').focus(function () {
    $(this).select();
});
    

function relocateUserPosition(lat, lng){
    userPositionLat = lat;
    userPositionLng = lng;
    var latLng = new google.maps.LatLng(userPositionLat, userPositionLng);
    if(!isEmpty(map)){
        markerPosition.setPosition(latLng);
        map.setCenter(latLng);
    }
}