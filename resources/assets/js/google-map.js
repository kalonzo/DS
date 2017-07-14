var map = null;
var markerPosition = null;

$(document).on('googleGeolocReady', function(){
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

    if (!isEmpty(userPositionLat) && !isEmpty(userPositionLng)) {
        var pos = {
            lat: userPositionLat,
            lng: userPositionLng
        };

        markerPosition = new google.maps.Marker({
            position: {lat: userPositionLat, lng: userPositionLng},
            map: map,
            title: 'Ma position'
        });
        map.setCenter(pos);
    }
    var locationMarkers = new Array();
    $(map).on('locationsUpdated', function(event, data){
        $.each(locationMarkers, function (index, marker) {
            marker.setMap(null);
        });
        if(!isEmpty(data.items)){
            $.each(data.items, function (index, item) {
                var lat = item.lat*1;
                var lng = item.lng*1;
                var markerEts = new google.maps.Marker({
                    position: {lat: lat, lng: lng},
                    map: map,
                    title: item.label,
//                    icon: iconDest,
                });
                var etsInfoWindow = new google.maps.InfoWindow({
                    content: item.label
                });
                markerEts.addListener('click', function () {
                    etsInfoWindow.open(map, markerEts);
                });
                locationMarkers.push(markerEts);
            });
        }
    });
});

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
}

function getDestinationInfoLabel(lat, lng){
    return 'Destination : (' + lat + ', ' + lng + ')';
}
