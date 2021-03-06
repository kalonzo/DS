<div class="main row">
    <div class="col-xs-12 no-gutter panel panel-default" id="search-results-filters">
        <div class="panel-heading">
            <div class="row no-margin form-inline">
                <div class="col-xs-12 col-sm-4 col-md-6 no-gutter">
                    <a id="filter-collapse-control" data-toggle="collapse" href="#search-results-filters-body" aria-expanded="true" 
                       aria-controls="search-results-filters-body" class="@if (Cookie::get('searchFilterCollapsed') == 1) collapseEnabled @endif"
                       title="Afficher/masquer les filtres" onclick="$(this).dsToggleClass('collapseEnabled');">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    </a>
                    Affiner la recherche
                </div>
                <!-- NB RESULTS DISPLAYED FILTER -->
                <div class="form-group col-xs-6 col-sm-4 col-md-3 text-right">
                    <label>Afficher</label>
                    <select class="search-filter-input" name='display_by'>                     
                        @foreach($filter_labels['display_by'] as $value)
                        <option value="{{ $value }}" @if( $filter_values['display_by'] == $value) selected @endif >
                            {{ $value }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <!-- ORDER BY FILTER -->
                <div class="form-group col-xs-6 col-sm-4 col-md-3 text-right">
                    <label>Trier par</label>
                    <select class="search-filter-input" name='order_by'>                     
                        @foreach($filter_labels['order_by'] as $value => $label)
                        <option value="{{ $value }}" @if( $filter_values['order_by'] == $value) selected @endif >
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="panel-body collapse @if (Cookie::get('searchFilterCollapsed') != 1) in @endif" id="search-results-filters-body">
             <div class="col-md-3">
                 <!-- DISTANCE FILTER -->
                <div class="form-group">
                    <label>Rayon de recherche</label>
                    <div class="slider" id="distance-slider" data-value="{{ $filter_values['distance'] }}"></div>
                    <div class="text-right text-uppercase">
                        Distance de 0 à <span id="distance-slider-max">{{ $filter_values['distance'] }}</span> km
                    </div>
                </div>
                 <!-- LOCATION FILTER -->
                <div class="form-group">
                    <label>Localité</label>
                    @foreach($filter_labels['location_index'] as $id_location => $location_info)
                    <div class="checkbox @if( $loop->iteration > 5) item-overflow @endif">
                        <label>
                            <input type="checkbox" name="location_index[]" value="{{ $id_location }}" class="search-filter-input"
                                    @if(is_array($filter_values['location_index']) && in_array($id_location, $filter_values['location_index'])) checked @endif />
                            <?php
                            if(isset($location_info['district']) && !empty($location_info['district'])){
                                echo $location_info['district'].', ';
                            }
                            echo $location_info['city'];
                            if(isset($location_info['postal_code']) && !empty($location_info['postal_code'])){
                                echo ' ('.$location_info['postal_code'].')';
                            }
                            ?>
                            <span class="pull-right">({{ $location_info['count'] }})</span>
                        </label>
                    </div>
                    @endforeach
                    <a class="filter-list-see-more clickable @if( count($filter_labels['location_index']) <= 5) hidden @endif"
                       data-toggle="modal" data-target="#filterModal">
                        (+ de localités)
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <!-- COOKING TYPE FILTER -->
                <div class="form-group">
                    <label>Type de cuisine</label>
                    @foreach($filter_labels['biz_category_1'] as $id_type => $type_info)
                    <div class="checkbox @if( $loop->iteration > 8) item-overflow @endif">
                        <label>
                            <input type="checkbox" name="biz_category_1[]" value="{{ $id_type }}" class="search-filter-input"
                                    @if(is_array($filter_values['biz_category_1']) && in_array($id_type, $filter_values['biz_category_1'])) checked @endif />
                            {{ $type_info['type'] }}
                            <span class="pull-right">({{ $type_info['count'] }})</span>
                        </label>
                    </div>
                    @endforeach
                    <a class="filter-list-see-more clickable @if( count($filter_labels['biz_category_1']) <= 8) hidden @endif"
                       data-toggle="modal" data-target="#filterModal">
                        (+ de types de cuisine)
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <!-- ATMOSPHERE FILTER -->
                <div class="form-group">
                    <label>Cadre et ambiance</label>
                    @foreach($filter_labels['biz_category_2'] as $id_type => $type_info)
                    <div class="checkbox @if( $loop->iteration > 8) item-overflow @endif">
                        <label>
                            <input type="checkbox" name="biz_category_2[]" value="{{ $id_type }}" class="search-filter-input"
                                    @if(is_array($filter_values['biz_category_2']) && in_array($id_type, $filter_values['biz_category_2'])) checked @endif />
                            {{ $type_info['type'] }}
                            <span class="pull-right">({{ $type_info['count'] }})</span>
                        </label>
                    </div>
                    @endforeach
                    <a class="filter-list-see-more clickable @if( count($filter_labels['biz_category_2']) <= 8) hidden @endif"
                       data-toggle="modal" data-target="#filterModal">
                        (+ de types de cadres)
                    </a>
                </div>
            </div>
            <div class="col-md-3" style="margin-bottom: 15px;">
                 <!-- NAME FILTER -->
                <div class="form-group">
                    <label>Nom</label>
                    <input type="text" name="term" value="{{ $filter_values['term'] }}" class="search-filter-input form-control"/>
                </div>
                 <!-- PROMO FILTER -->
                <div class="form-group">
                    <label>Promos</label>
                    @foreach($filter_labels['promo_type'] as $id_promo_type => $promo_type_info)
                    <div class="checkbox @if( $loop->iteration > 4) item-overflow @endif">
                        <label>
                            <input type="checkbox" name="promo_type[]" value="{{ $id_promo_type }}" class="search-filter-input"
                                    @if(is_array($filter_values['promo_type']) && in_array($id_promo_type, $filter_values['promo_type'])) checked @endif />
                            {{ $promo_type_info['type'] }}
                            <span class="pull-right">({{ $promo_type_info['count'] }})</span>
                        </label>
                    </div>
                    @endforeach
                    <a class="filter-list-see-more clickable @if( count($filter_labels['promo_type']) <= 4) hidden @endif"
                       data-toggle="modal" data-target="#filterModal">
                        (+ de promos)
                    </a>
                </div>
                 <!-- PRICE FILTER -->
                <div class="form-group" @if( $filter_labels['max_price'] <= 0) hidden @endif>
                    <label>Prix</label>
                    <div class="slider" id="price-slider" data-value="{{ $filter_values['price'] }}" 
                         data-min="{{ $filter_labels['min_price'] }}" data-max="{{ $filter_labels['max_price'] }}"></div>
                    <div class="text-right text-uppercase">
                        De 0 à CHF <span id="price-slider-max">{{ $filter_values['price'] == 0 ? $filter_labels['max_price'] : $filter_values['price'] }}</span>.-
                    </div>
                </div>
            </div>
            <div class="col-md-3 filterResetTrigger no-gutter">
                <button role="button" class="btn btn-sm">
                    <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Réinitialiser les filtres
                </button>
            </div>
        </div>
    </div>
    <div class="col-xs-12 no-gutter" id="search-results">
        @foreach($establishments as $establishment)
            @component('components.establishment_thumbnail', ['establishment' => $establishment])

            @endcomponent
        @endforeach
    </div>
</div>
{{ $establishments->links() }}
<script type="text/javascript">
    var distance = {{ $filter_values['distance'] }};
    var maxDistance = 50;
    var minZoom = 9;
    var maxZoom = 13;
    var newZoom = Math.round((1 - (distance / maxDistance)) * (maxZoom - minZoom)) + minZoom;
    if(typeof resetMapZoom != 'undefined'){
        resetMapZoom(newZoom);
    }
    document.addEventListener("DOMContentLoaded", function(event) { 
        $(document).on('googleMapReady', function(){
            resetMapZoom(newZoom);
        });
    });
</script>
