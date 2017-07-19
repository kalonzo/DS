<div class="main row">
    <div class="col-xs-12 no-gutter panel panel-default" id="search-results-filters">
        <div class="panel-heading">Filtres</div>
        <div class="panel-body">
             <div class="col-md-3">
                <div class="form-group">
                    <label>Rayon de recherche</label>
                    <div class="slider" id="distance-slider" data-value="{{ $filter_values['distance'] }}"></div>
                    <div class="text-right">
                        Distance de 0 à <span id="distance-slider-max">{{ $filter_values['distance'] }}</span> km
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 no-gutter" id="search-results">
        @foreach($establishments as $establishment)
            <div class="no-gutter search-thumbnail">
                <img class="col-xs-12 no-gutter" src="{{ $establishment['img'] }}" alt="Establishment picture"/>
                <div class="thumbnail-text col-xs-12">
                    <div class="thumbnail-label col-xs-12 no-gutter">
                        {{ $establishment['name'] }}
                    </div>
                    <div class="thumbnail-info col-xs-12 no-gutter">
                        {{$establishment['type_category']}}, {{$establishment['city']}} - {{$establishment['country']}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
{{ $establishments->links() }}
