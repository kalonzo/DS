@extends('layouts.front')

@section('js_imports_head')
@endsection

@section('content')
<div class="content">
    <div class="row">
        @foreach($slider_ets as $establishment)
        <div class="col-xs-12 no-gutter" style="height: 450px; background: url('{{ $establishment->getDefaultPicture() }}'); position: relative;">
            <div class="col-xs-10" style="background: rgba(0,0,0, 0.4); color: white; font-size: 3.5em; height: 60px; position: absolute; right: 0px; bottom: 1.5em;">
                {{ $establishment->getName() }}
            </div>
        </div>
        @endforeach
    </div>
    <br/>
    <!--
    <div class="links">
        <a href="/admin">Admin</a>
    </div>
    -->
</div>

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

        </div>
    </div>
</div>
@endsection

@section('js_imports_footer')
<script src="/js/geolocation.js"></script>
<script src="/js/search.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&callback=initGoogleAPI&libraries=places" type="text/javascript"></script>
@endsection