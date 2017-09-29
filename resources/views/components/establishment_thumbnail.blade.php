<div class="no-gutter ets-thumbnail @if(isset($establishment['promo_name'])) with-promo @endif" 
     data-lat='{{ $establishment['latitude'] }}' data-lng='{{ $establishment['longitude'] }}' data-name="{{ $establishment['name'] }}">
    <a href="@if(isset($establishment['url'])) {{ $establishment['url'] }} @else javascript:void(0); @endif" @if(!isset($establishment['url'])) class="link-disabled" @endif>
        <div class="thumbnail-top col-xs-12 no-gutter">
            <div class="thumbnail-picture" style="background-image: url('{{ $establishment['img'] }}');">
                <img src="/img/square-pattern.png" alt="square pattern" class="square-pattern"/>
            </div>
            <!--<img class="col-xs-12 no-gutter" src="{{ $establishment['img'] }}" alt="Establishment picture"/>-->
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
            @if(isset($establishment['promo_name']))
            <div class="thumbnail-promo col-xs-12 no-gutter">
                {{$establishment['promo_name']}}
            </div>
            @endif
        </div>
    </a>
</div>