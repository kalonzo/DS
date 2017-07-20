var map = null;
var markerPosition = null;

$(document).on('googleGeolocReady', function(){
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: 15,
        streetViewControl: false,
        scrollwheel: false,
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
    $(document).trigger('googleMapReady');
    
    if (!isEmpty(userPositionLat) && !isEmpty(userPositionLng)) {
        var pos = {
            lat: userPositionLat,
            lng: userPositionLng
        };

        markerPosition = new google.maps.Marker({
            position: {lat: userPositionLat, lng: userPositionLng},
            map: map,
            title: 'Ma position',
            icon: '/img/you_are_here.png',
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
                    icon: '/img/marker_ds.png',
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

var resultMarkers = new Array();
$(document).on('searchUpdated googleMapReady', function(event, data){
    $.each(resultMarkers, function (index, marker) {
        marker.setMap(null);
    });
    $('#search-results').find('.search-thumbnail').each(function(){
        var name = $(this).attr('data-name');
        var lat = $(this).attr('data-lat')*1;
        var lng = $(this).attr('data-lng')*1;

        var markerEts = new google.maps.Marker({
            position: {lat: lat, lng: lng},
            map: map,
            title: name,
            icon: '/img/marker_ds.png',
        });
        var etsInfoWindow = new google.maps.InfoWindow({
            content: name
        });
        markerEts.addListener('click', function () {
            etsInfoWindow.open(map, markerEts);
        });
        resultMarkers.push(markerEts);
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
