@if(!isset($reloaded) || !$reloaded)
@extends('layouts.front')

@section('js_imports_head')
@endsection

@section('content')
<div id="map"> </div>

<div id="search-container" class="container mainPageReloadContainer">
@endif
    @component('components.search_results', ['establishments' => $establishments, 'filter_values' => $filter_values, 'filter_labels' => $filter_labels])

    @endcomponent
    
@if(!isset($reloaded) || !$reloaded)
</div>
<!-- Modal -->
<div id="filterModal" class="modal fade" role="dialog">
   <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Filtres</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
   </div>
</div>
@endsection

@section('js_imports_footer')
<script src="/js/ets-thumbnails.js"></script>
<script src="/js/geolocation.js"></script>
<script src="/js/google-map.js"></script>
<script src="/js/search.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&callback=initGoogleAPI&libraries=places" type="text/javascript"></script>
@endsection

@endif