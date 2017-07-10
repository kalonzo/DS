var userPositionLat = null;
var userPositionLng = null;
var markerPosition = null;
var map = null;


function initMap() {
    
    $('#search_location').each(function () {
        $(this).focus(function(){
            console.log('focus');
            $(this).select();
        });
        var autocomplete = new google.maps.places.Autocomplete(this, {
            types: ['geocode']
        });
        autocomplete.addListener('place_changed', function(){
            var place = autocomplete.getPlace();
            relocateUserPosition(place.geometry.location.lat(), place.geometry.location.lng());
        });
    });

    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: 15,
        streetViewControl: false,
        styles: [{      
            featureType: 'poi.business',
                  stylers: [{
                visibility: 'off'
            }]     
        },     {      
            featureType: 'transit',
                  elementType: 'labels.icon',
                  stylers: [{
                visibility: 'off'
            }]     
        }]
    });
    var infoWindow = new google.maps.InfoWindow({map: map});

    var destinationLat = 46.417087;
    var destinationLng = 6.276002;
    var iconDest = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
    var markerDestination = new google.maps.Marker({
        position: {lat: destinationLat, lng: destinationLng},
        map: map,
        title: 'Destination',
        icon: iconDest,
        draggable:true
    });
    var markerInfoWindow = new google.maps.InfoWindow({
        content: getDestinationInfoLabel(markerDestination.getPosition().lat(), markerDestination.getPosition().lng())
    });
    markerDestination.addListener('click', function () {
        markerInfoWindow.open(map, markerDestination);
    });
    markerDestination.addListener('dragend', function () {
        markerInfoWindow.open(map, markerDestination);
        $('#inputLatitude').val(markerDestination.getPosition().lat());
        $('#inputLongitude').val(markerDestination.getPosition().lng());
    });
    $('#inputLatitude').val(destinationLat);
    $('#inputLongitude').val(destinationLng);

    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            userPositionLat = position.coords.latitude * 1;
            userPositionLng = position.coords.longitude * 1;
            
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

            markerPosition = new google.maps.Marker({
                position: {lat: userPositionLat, lng: userPositionLng},
                map: map,
                title: 'Ma position'
            });
            map.setCenter(pos);
        }, function () {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }
}

function relocateUserPosition(lat, lng){
    userPositionLat = lat;
    userPositionLng = lng;
    var latLng = new google.maps.LatLng(userPositionLat, userPositionLng);
    markerPosition.setPosition(latLng);
    if(!isEmpty(map)){
        map.setCenter(latLng);
    }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
}

function getDestinationInfoLabel(lat, lng){
    return 'Destination : (' + lat + ', ' + lng + ')';
}
