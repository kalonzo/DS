<div class="main row">
    <div class="col-xs-12 no-gutter panel panel-default" id="search-results-filters">
        <div class="panel-heading">
            <div class="row form-inline">
                <div class="col-xs-12 col-sm-4 col-md-6">
                    Filtres
                </div>
                <div class="form-group col-xs-6 col-sm-4 col-md-3 text-right">
                    <label>Afficher</label>
                    <select class="form-control search-filter-input" name='display_by'>                     
                        @foreach($filter_labels['display_by'] as $value)
                        <option value="{{ $value }}" @if( $filter_values['display_by'] == $value) selected @endif >
                            {{ $value }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-xs-6 col-sm-4 col-md-3 text-right">
                    <label>Trier par</label>
                    <select class="form-control search-filter-input" name='order_by'>                     
                        @foreach($filter_labels['order_by'] as $value => $label)
                        <option value="{{ $value }}" @if( $filter_values['order_by'] == $value) selected @endif >
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
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
                <div class="thumbnail-top col-xs-12 no-gutter">
                    <img class="col-xs-12 no-gutter" src="{{ $establishment['img'] }}" alt="Establishment picture"/>
                    <div class="thumbnail-distance">
                        {{ $establishment['raw_distance'] }}
                    </div>
                </div>
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
