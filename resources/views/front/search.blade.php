@extends('layouts.front')

@section('js_imports_head')
@endsection

@section('content')
<div id="map" style="width: 100%; height: 400px;"> </div>

<div class="container-fluid">
    <div class="main row">
        <div class="col-xs-12">
            
        </div>
    </div>
</div>
@endsection

@section('js_imports_footer')
<script src="/js/geolocation.js"></script>
<script src="/js/google-map.js"></script>
<script src="/js/search.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&callback=initGoogleAPI&libraries=places" type="text/javascript"></script>
@endsection