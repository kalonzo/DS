<!------------- RESTAURANT DETAILS ------------------------------------>
 @if(checkFlow($data, ['services', 'ambiences']) || $establishment->video()->exists() || !empty($establishment->getDescription()) )
<section class="container-fluid ets-details">
    <div class="container">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">
            <h1>Qui <strong>sommes-nous</strong></h1>
            @if($establishment->video()->exists())
            <video width="100%" controls controlsList="nodownload">
                <source src="{{ asset($establishment->video()->first()->getLocalPath()) }}" type="{{ $establishment->video()->first()->getMimeType() }}">
                @lang("Votre navigateur ne supporte pas l'affichage de vidéo au standard HTML5.")
            </video>
            @endif
            <p class="description">
                {{ $establishment->getDescription() }}
            </p>
            <!--
            VIDEO
            -->
            <div class="row">
                @if(isset($data['services']) && !empty($data['services']))
                <div class="col-sm-6">
                    <h2>Services</h2>
                    @foreach($data['services'] as $service)
                    <ul class="category-list">
                        <li>{{ $service }}</li>
                    </ul>                            
                    @endforeach
                </div>
                @endif
                @if(isset($data['ambiences']) && !empty($data['ambiences']))
                <div class="col-sm-6">
                    <h2>Cadre & ambiance</h2>
                    @foreach($data['ambiences'] as $ambience)
                    <ul class="category-list">
                        <li>{{ $ambience }}</li>
                    </ul>                            
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
 @endif
<!------------- RESTAURANT EVENTS & PROMO ----------------------------->
@if(isset($data['events']) || isset($data['promo']))
<section class="container-fluid ets-events" id="events">
    <div class="container">
        <h1>Nos <strong>événements</strong> et <strong>promotions</strong></h1>
        <div class="row">
            <div class="col-sm-4">
                <!--
                CALENDAR
                -->
            </div>
            <div class="col-sm-8">
                <!--
                EVENT INFO
                -->
            </div>
        </div>
    </div>
</section>
@endif
<!------------- RESTAURANT STAFF -------------------------------------->
@if(checkFlow($data, ['staff']))
<section class="container-fluid ets-staff">
    <div class="container">
        <h1>Notre <strong>équipe</strong></h1>
        <div class="row">
            @foreach($data['staff'] as $staff)
            <div class="col-xs-6 col-sm-4 thumbnail-item">
                <img src="{{ $staff['picture'] }}" alt="{{ $staff['name'] }} picture"/>
                <div class="thumbnail-name">
                    {{ $staff['name'] }}
                </div>
                <div class="thumbnail-description">
                    {{ $staff['position'] }}
                </div>
            </div>                    
            @endforeach
        </div>
    </div>
</section>
@endif
<!------------- RESTAURANT HISTORY -------------------------------------->
@if(checkFlow($data, ['story']))
<section class="container-fluid ets-story">
    <div class="container">
        <h1><strong>Notre</strong> histoire</h1>
        <div class="row">
            @component('components.timeline', ['items' => $data['story'] ])
                @foreach($data['story'] as $story)
                    @slot("content_".$story['id'])
                        <div class="timeline-content-image square-container">
                            <div class="crop">
                                <img src="{!! $story['picture'] !!}" alt="story illustration"/>
                            </div>
                        </div>
                        <div class="timeline-content-body">
                            <div class="timeline-content-title">
                                {!! $story['title'] !!}
                            </div>
                            <div class="timeline-content-text">
                            {!! $story['text'] !!}
                            </div>
                        </div>
                    @endslot
                @endforeach
            @endcomponent
            <br class="cleaner"/><br/>
        </div>
    </div>
</section>
@endif
<!------------- RESTAURANT TIMETABLE ---------------------------------->
@if(checkFlow($data, ['timetable', 'close_periods']))
<section class="container-fluid ets-timetable">
    <div class="container">
        <h1><strong>Horaires</strong> d'ouverture</h1>
        <div class="row">
            <div class="col-xs-5_5 col-sm-2_5">
                &nbsp;
            </div> 
            <div class="col-xs-5_5 col-sm-4_5 col-sm-offset-0_5 col-label">
                Déjeuner
            </div>    
            <div class="hidden-xs col-xs-5_5 col-sm-4_5 col-sm-offset-0 col-label">
                Diner
            </div>    
        </div>
        <div class="row timetable-show">
            @foreach($data['timetable'] as $dayLabel => $timeslot)
            <div class="row timetable-row">
                <div class="col-xs-5_5 col-sm-2_5 timetable-day">
                    {{ $dayLabel }}
                </div>    
                @if(isset($timeslot[1]['no_break']) && $timeslot[1]['no_break'] == true)
                    <div class="col-xs-6_5 col-sm-9 col-xs-offset-0_5 text-center timetable-col">
                        @if(isset($timeslot[1]['time']))
                            {{ $timeslot[1]['time'] }}
                        @endif
                    </div>
                @else
                    <div class="col-xs-5_5 col-xs-offset-0_5 col-sm-4_5 timetable-col timetable-col-am">
                        @if(isset($timeslot[1]['time']))
                            {{ $timeslot[1]['time'] }}
                        @endif
                    </div>    
                    <div class="col-xs-5_5 col-xs-offset-0_5 col-sm-4_5 col-sm-offset-0 timetable-col timetable-col-pm">
                        @if(isset($timeslot[2]['time']))
                            {{ $timeslot[2]['time'] }}
                        @endif
                    </div>  
                @endif
            </div>
            @endforeach
        </div>
        @if(isset($data['close_periods']))
        <br class="cleaner"/><br/>
        <div class="row close-show">
            <div class="col-xs-5_5 col-sm-2_5 text-right">
                <h2>Fermeture exceptionnelle</h2>
            </div>   
            <div class="col-xs-6_5 col-sm-9 col-sm-offset-0_5 period-label">
                @foreach($data['close_periods'] as $closePeriod)
                <div class="col-xs-6 col-sm-4 text-right">
                    {!! $closePeriod->getLabel() !!} :
                </div>
                <div class="col-xs-6 col-sm-8">
                    {!! formatDate($closePeriod->getStartDate(), IntlDateFormatter::SHORT) !!} - {!! formatDate($closePeriod->getEndDate(), IntlDateFormatter::SHORT) !!}
                </div>
                @endforeach
            </div>   
        </div>
        @endif
    </div>
</section>
@endif