@extends('layouts.front')

@section('js_imports_head')
@endsection

@section('content')
<div id="map" style="width: 100%; height: 500px;"> </div>

<div class="container-fluid">
    <div class="main row">
        <div class="col-xs-12">
            @if (Route::has('login'))
            <div class="top-right links">
                @if (Auth::check())
                <a href="{{ url('/admin') }}">Home</a>
                @else
                <a href="{{ url('/login') }}">Login</a>
                <a href="{{ url('/register') }}">Register</a>
                @endif
            </div>
            @endif

            <div class="content">
                <div class="form-inline row">
                    <!--
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="inputLatitude" placeholder="Latitude">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="inputLongitude" placeholder="Longitude">
                        </div>
                        <button type="submit" class="btn btn-default" onclick="calculateDistance(); calculateRouteDistance();">Valider</button>
                    </div>
                    <div class=" col-sm-6 text-right">
                        <div class="form-group">
                            <label for="distanceOutput" class="control-label">Distance brute</label>
                            <input type="text" class="form-control" id="distanceOutput" placeholder="Distance" readonly>
                        </div>
                        <div class="form-group">
                            <label for="distanceRouteOutput" class="control-label">Distance route</label>
                            <input type="text" class="form-control" id="distanceRouteOutput" placeholder="Distance" readonly>
                        </div>
                    </div>
                    -->
                </div>
                <br/>

                <div class="links">
                    <a href="/admin">Admin</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script type="text/javascript">
    var searchRadius = 500;

    function calculateDistance() {
        var destinationPositionLat = $('#inputLatitude').val() * 1;
        var destinationPositionLng = $('#inputLongitude').val() * 1;
        if (userPositionLng !== null && userPositionLat !== null && destinationPositionLng !== null && destinationPositionLat !== null) {
            var earth_radius = 6378137;   // Terre = sphère de 6378km de rayon
            var rlo1 = Math.radians(userPositionLng);
            var rla1 = Math.radians(userPositionLat);
            var rlo2 = Math.radians(destinationPositionLng);
            var rla2 = Math.radians(destinationPositionLat);
            var dlo = (rlo2 - rlo1) / 2;
            var dla = (rla2 - rla1) / 2;
            var a = (Math.sin(dla) * Math.sin(dla)) + Math.cos(rla1) * Math.cos(rla2) * (Math.sin(dlo) * Math.sin(dlo));
            var d = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var distance = earth_radius * d;

            $('#distanceOutput').val(Math.round(distance));
        }
    }

    function calculateRouteDistance() {
        var service = new google.maps.DistanceMatrixService();
        service.getDistanceMatrix({
            origins: [userPositionLat + "," + userPositionLng],
            destinations: [$('#inputLatitude').val() + "," + $('#inputLongitude').val()],
            travelMode: google.maps.TravelMode.DRIVING,
            avoidHighways: false,
            avoidTolls: false
        }, function (response, status) {
            if (status != google.maps.DistanceMatrixStatus.OK) {
                console.log(err);
            } else {
                var origin = response.originAddresses[0];
                var destination = response.destinationAddresses[0];
                if (response.rows[0].elements[0].status === "ZERO_RESULTS") {
                    console.log("Better get on a plane. There are no roads between " + origin + " and " + destination);
                } else {
                    var distance = response.rows[0].elements[0].distance;
                    var distance_value = distance.value;
                    var distance_text = distance.text;
                    var miles = distance_text.substring(0, distance_text.length - 3);
                    $('#distanceRouteOutput').val(distance_value);
                }
            }
        }
        );
    }
</script>

@section('js_imports_footer')
<script src="/js/geolocation.js"></script>
<script src="/js/google-map.js"></script>
<script src="/js/search.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&callback=initGoogleAPI&libraries=places" type="text/javascript"></script>
@endsection