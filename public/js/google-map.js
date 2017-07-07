var userPositionLat = null;
var userPositionLng = null;

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: 13
    });
    var infoWindow = new google.maps.InfoWindow({map: map});

    var destinationLat = 46.417087;
    var destinationLng = 6.276002;
    var iconDest = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
    var markerDestination = new google.maps.Marker({
        position: {lat: destinationLat, lng: destinationLng},
        map: map,
        title: 'Migros Gland',
        icon: iconDest
    });
    var markerInfoWindow = new google.maps.InfoWindow({
        content: 'Migros Gland : (' + markerDestination.getPosition().lat() + ', ' + markerDestination.getPosition().lng() + ')'
    });
    markerDestination.addListener('click', function () {
        markerInfoWindow.open(map, markerDestination);
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

            var markerPosition = new google.maps.Marker({
                position: {lat: userPositionLat, lng: userPositionLng},
                map: map,
                title: 'Ma position'
            });
            var markerInfoWindow = new google.maps.InfoWindow({
                content: 'Ma position : (' + userPositionLat + ', ' + userPositionLng + ')'
            });
            markerPosition.addListener('click', function () {
                markerInfoWindow.open(map, markerPosition);
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

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
}