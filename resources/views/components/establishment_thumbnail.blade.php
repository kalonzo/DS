<div class="no-gutter ets-thumbnail" 
     data-lat='{{ $establishment['latitude'] }}' data-lng='{{ $establishment['longitude'] }}' data-name="{{ $establishment['name'] }}">
    <a href="{{ $establishment['url'] }}">
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
                {{$establishment['biz_category_1']}}, {{$establishment['city']}} - {{$establishment['country']}}
            </div>
        </div>
    </a>
</div>