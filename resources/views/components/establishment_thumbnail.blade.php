<?php

?>
<div class="no-gutter ets-thumbnail @if(isset($establishment['promo_name'])) with-promo @endif @if(isset($establishment['logo_img'])) with-logo @endif" 
     data-lat='{{ $establishment['latitude'] }}' data-lng='{{ $establishment['longitude'] }}' data-name="{{ $establishment['name'] }}">
    <a href="@if(isset($establishment['url'])) {{ $establishment['url'] }} @else javascript:void(0); @endif" @if(!isset($establishment['url'])) class="link-disabled" @endif>
        @if(isset($establishment['logo_img']))
        <div class="thumbnail-logo-corner" title="Cliquer ici pour afficher plus d'informations" data-title-toggle="Cliquer ici pour retourner à la vignette"> 
            <div class="thumbnail-logo" style="@if(isset($establishment['background_color'])) background-color: {{ $establishment['background_color'] }}; @endif
                 background-image: url('{{ asset($establishment['logo_img']) }}');">
            </div>
            <div class="thumbnail-corner"></div>
        </div>
        <div class="thumbnail-logo-corner-shadow"></div>
        @endif
       <div class="thumbnail-top-layer">
            <div class="thumbnail-top col-xs-12 no-gutter">
                <div class="thumbnail-picture square-container">
                    <div class="thumbnail-image crop crop-fit">
                        <img src="/img/square-pattern.png" alt="square pattern" class="square-pattern"/>
                        @if(isset($establishment['thumbnail_img']) && !empty($establishment['thumbnail_img']))
                            <img src="{{ asset($establishment['thumbnail_img']) }}" alt="Thumbnail"/>   
                        @else
                            <img src="{{ asset("/img/DS-LOGO-BLANC.svg") }}" class="default-bg-ds" alt="Thumbnail"/>   
                        @endif
                    </div>
                    <div class="thumbnail-distance @if(!isset($establishment['thumbnail_img']) || empty($establishment['thumbnail_img'])) bordered @endif">
                        {{ $establishment['raw_distance'] }}
                    </div>
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
        </div>
       <div class="thumbnail-under-layer">
            <div class="logo-picture" style="@if(isset($establishment['background_color'])) background-color: {{ $establishment['background_color'] }}; @endif">
                <img src="{{ asset($establishment['logo_img']) }}" alt="Logo" class=""/>
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
        </div>
    </a>
</div>