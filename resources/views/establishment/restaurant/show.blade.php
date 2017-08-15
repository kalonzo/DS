@extends('layouts.front') 

@section('css_imports')
<link href="/css/establishment.css" rel="stylesheet">
@endsection

@section('content')
    @php
    print_r($data);
    @endphp
    <div class="content">
        <section class="container-fluid">
            <h1>{{ $establishment->getName() }}<h1>
            <h2>{{ $data['cooking_type'] }}<h2>
            @if(isset($data['specialties']))
            <h3>
                @foreach($data['specialties'] as $specialty)
                {{ $specialty }}
                @endforeach
            </h3>
            @endif
        </section>
    </div>
@endsection

@section('js_imports_footer')
<script src="/js/google-map.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&callback=initGoogleAPI&libraries=places" type="text/javascript"></script>
@endsection
