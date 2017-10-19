var map = null;
var markerPosition = null;
var mapZoom = 15;

$(document).on('googleGeolocReady', function(){
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: mapZoom,
        streetViewControl: false,
//        scrollwheel: false,
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
            zIndex: 1
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
var resultInfoWindows = new Array();
$(document).on('searchUpdated googleMapReady', function(event, data){
    $.each(resultMarkers, function (index, marker) {
        marker.setMap(null);
    });
    $('#search-results').find('.ets-thumbnail').each(function(){
        var content = '<div class="infoWindowEts">' + $(this).prop('outerHTML') + '</div>';
        var name = $(this).attr('data-name');
        var lat = $(this).attr('data-lat')*1;
        var lng = $(this).attr('data-lng')*1;

        var markerEts = new google.maps.Marker({
            position: {lat: lat, lng: lng},
            map: map,
            title: name,
            icon: '/img/marker_ds.png',
            zIndex: 2
        });
        var etsInfoWindow = new google.maps.InfoWindow({
            content: content,
            maxWidth: 145
        });
        customizeInfoWindow(etsInfoWindow);
        markerEts.addListener('click', function () {
            $.each(resultInfoWindows, function (index, infoWindow) {
                infoWindow.close();
            });
            etsInfoWindow.open(map, markerEts);
        });
        
        resultMarkers.push(markerEts);
        resultInfoWindows.push(etsInfoWindow);
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

function customizeInfoWindow(infowindow){
    google.maps.event.addListener(infowindow, 'domready', function() {
        var iwOuter = $('.gm-style-iw');
        
        var iwBackground = iwOuter.prev();
        $(iwBackground).addClass('gm-style-iw-bg');
        
        var iwCloseBtn = iwOuter.next();
        $(iwCloseBtn).addClass('gm-style-iw-close-btn');
        
        var iw = iwOuter.parent().parent();
        $(iw).addClass('gm-style-iw-container');
    });
}

resetMapZoom = function(zoom){
    mapZoom = zoom;
    if(typeof map !== 'undefined'){
        map.setZoom(mapZoom);
    }
}