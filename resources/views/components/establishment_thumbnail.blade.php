<div class="no-gutter ets-thumbnail @if(isset($establishment['promo_name'])) with-promo @endif" 
     data-lat='{{ $establishment['latitude'] }}' data-lng='{{ $establishment['longitude'] }}' data-name="{{ $establishment['name'] }}">
    <a href="@if(isset($establishment['url'])) {{ $establishment['url'] }} @else javascript:void(0); @endif" @if(!isset($establishment['url'])) class="link-disabled" @endif>
        <div class="thumbnail-top col-xs-12 no-gutter">
            <?php
            if(isset($establishment['thumbnail_img'])){
                ?>
                <div class="thumbnail-picture square-container">
                    <div class="crop">
                        <img src="/img/square-pattern.png" alt="square pattern" class="square-pattern"/>
                        <img src="{{ asset($establishment['thumbnail_img']) }}" alt="Thumbnail"/>   
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="logo-picture" style="background-image: url('{{ asset($establishment['logo_img']) }}');">
                    <img src="/img/square-pattern.png" alt="square pattern" class="square-pattern"/>
                </div>
                <?php
            }
            ?>
            <div class="thumbnail-distance">
                {{ $establishment['raw_distance'] }}
            </div>
        </div>
        <div class="thumbnail-text col-xs-12">
            <div class="thumbnail-label col-xs-12 no-gutter" title="{{ $establishment['name'] }}">
                {{ $establishment['name'] }}
            </div>
            <div class="thumbnail-info col-xs-12 no-gutter">
                {{$establishment['biz_category_1']}}
            </div>
            <div class="thumbnail-location col-xs-12 no-gutter">
                {{$establishment['city']}} - 
                @if(isset($establishment['country_iso'])) {{$establishment['country_iso']}} @else {{$establishment['country']}} @endif
            </div>
            @if(isset($establishment['promo_name']))
            <div class="thumbnail-promo col-xs-12 no-gutter">
                {{$establishment['promo_name']}}
            </div>
            @endif
        </div>
    </a>
</div>