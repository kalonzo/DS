<div class="no-gutter ets-thumbnail @if(isset($establishment['logo_img'])) with-logo @endif" 
     data-lat='{{ $establishment['latitude'] }}' data-lng='{{ $establishment['longitude'] }}' data-name="{{ $establishment['name'] }}">
    <a href="@if(isset($establishment['url'])) {{ $establishment['url'] }} @else javascript:void(0); @endif" @if(!isset($establishment['url'])) class="link-disabled" @endif>
        @if(isset($establishment['logo_img']))
        <div class="thumbnail-logo-corner" title="Cliquer ici pour afficher plus d'informations" data-title-toggle="Cliquer ici pour retourner à la vignette"> 
            <div class="thumbnail-logo">
                <div class="logo-picture" style="@if(isset($establishment['background_color'])) background-color: {{ $establishment['background_color'] }}; @endif">
                    <div class="logo-picture-cell">
                        <img src="{{ asset($establishment['logo_img']) }}" alt="Logo" class=""/>
                    </div>
                </div>
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
                    @if(isset($establishment['promo']))
                    <div class="thumbnail-promo-indicator" title='{{ $establishment['promo']['count'] }} promotions en cours'>
                        <img class="img-icon" src="/img/icons/discount-icon.png" alt="%"/>
                        <span>{{ $establishment['promo']['count'] }}</span>
                    </div>
                    @endif
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
                <div class="cleaner"></div>
            </div>
        </div>
       <div class="thumbnail-under-layer">
            <div class="logo-picture" style="@if(isset($establishment['background_color'])) background-color: {{ $establishment['background_color'] }}; @endif">
                <div class="logo-picture-cell">
                    <img src="{{ asset($establishment['logo_img']) }}" alt="Logo" class=""/>
                </div>
                @if(isset($establishment['promo']))
                <div class="thumbnail-promo-container">
                    <div class="thumbnail-promo">
                        {{ $establishment['promo']['label'] }}
                    </div>
                    @if($establishment['promo']['count'] > 1)
                    <div class="thumbnail-promo-count" title="{{ $establishment['promo']['count']-1 }} autres promotion(s) en cours">
                        +{{ $establishment['promo']['count']-1 }}
                    </div>
                    @endif
                </div>
                @endif
            </div>
            <div class="thumbnail-text col-xs-12">
                <div class="thumbnail-label col-xs-12 no-gutter" title="{{ $establishment['name'] }}">
                    {{ $establishment['name'] }}
                </div>
                <div class="thumbnail-text-extra">
                    @if(isset($establishment['full_address']))
                        <div class="thumbnail-full-address col-xs-12 no-gutter">
                        {!! $establishment['full_address'] !!}
                        </div>
                    @endif
                    @if(!isset($establishment['opening_info']))
                        <div class="thumbnail-info col-xs-12 no-gutter">
                            {{$establishment['biz_category_1']}}
                        </div>
                        <div class="thumbnail-location col-xs-12 no-gutter">
                            {{$establishment['city']}} - 
                            @if(isset($establishment['country_iso'])) {{$establishment['country_iso']}} @else {{$establishment['country']}} @endif
                        </div>
                    @else
                    <div class="thumbnail-opening col-xs-12 no-gutter">
                        <?php
                        $opened = $establishment['opening_info']['opened'];
                        $openDayIndex = $establishment['opening_info']['day_index'];
                        $relOpenDayIndex = $openDayIndex;
                        $timeslots = null;
                        if(isset($establishment['opening_info']['timeslots'])){
                            $timeslots = $establishment['opening_info']['timeslots'];
                        }
                        $deferedDate = null;
                        if(isset($establishment['opening_info']['defered_date'])){
                            $deferedDate = $establishment['opening_info']['defered_date'];
                        }
                        $today = new \DateTime();
                        $dayIndex = $today->format('N');
                        if($openDayIndex < $dayIndex){
                            $relOpenDayIndex = $openDayIndex + $dayIndex;
                        }
                        ?>
                        @if($opened)
                        <div class="ets-label-open">Ouvert</div>
                        @else
                            @if($openDayIndex == $dayIndex)
                            <div class="ets-label-open-soon">Ouvert aujourd'hui</div>
                            @else
                                <div class="ets-label-open-later">
                                    Fermé jusqu'
                                    @if(!empty($deferedDate))
                                    au {{ $deferedDate }}
                                    @else
                                        @if($openDayIndex == $dayIndex+1)
                                        à demain
                                        @else
                                            @if($relOpenDayIndex > $dayIndex+1 && $relOpenDayIndex < $dayIndex+7)
                                            à <?php echo \App\Utilities\DateTools::getDayLabelFromIndex($openDayIndex);?>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            @endif
                        @endif
                        @if(!empty($timeslots))
                            @foreach($timeslots as $timeslot)
                            <span>{{ $timeslot }}</span>
                            @if(!$loop->last) | @endif
                            @endforeach
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </a>
</div>