@extends('layouts.front')

@section('js_imports_head')
@endsection

@section('content')
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
                <div id="map" style="width: 100%; height: 500px;"> </div>

                <div class="links">
                    <a href="/admin">Admin</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_imports_footer')
    <script src="js/google-map.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&callback=initMap" type="text/javascript"></script>
@endsection