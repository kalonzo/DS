@extends('layouts.front')

@section('js_imports_head')
@endsection

@section('content')
<div id="map" style="width: 100%; height: 400px;"> </div>

<div id="search-container" class="container">
    <div class="main row">
        <div class="col-xs-12" id="search-results">
            @foreach($establishments as $establishment)
                <div class="no-gutter search-thumbnail">
                    <img class="col-xs-12 no-gutter" src="{{ $establishment['img'] }}" alt="Establishment picture"/>
                    <div class="thumbnail-text col-xs-12">
                        <div class="thumbnail-label col-xs-12">
                            {{ $establishment['name'] }}
                        </div>
                        <div class="thumbnail-info col-xs-12">
                            {{$establishment['type_category']}}, {{$establishment['city']}} - {{$establishment['country']}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $establishments->links() }}
    </div>
</div>
@endsection

@section('js_imports_footer')
<script src="/js/geolocation.js"></script>
<script src="/js/google-map.js"></script>
<script src="/js/search.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&callback=initGoogleAPI&libraries=places" type="text/javascript"></script>
@endsection