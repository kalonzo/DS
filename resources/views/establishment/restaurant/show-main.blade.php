@php
$loadDelay = 0.6
@endphp

<!------------- RESTAURANT DETAILS ------------------------------------>
    <?php
$video = null;
$videoQuery = $establishment->video()->where('status', '=', \App\Models\EstablishmentMedia::STATUS_VALIDATED);
if($videoQuery->exists()){
    $video = $videoQuery->first();
}
?>
 @if(checkFlow($data, ['services', 'ambiences']) || checkModel($video) || !empty($establishment->getDescription()) )
<section class="container-fluid ets-details">
    <div class="section-bg"></div>
    <div class="container">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">
            <h1 class="wow fadeInRight" data-wow-delay="{{$loadDelay}}s">Qui <strong>sommes-nous</strong></h1>
            <?php
            if(checkModel($video)){
                $localPath = $video->getLocalPath();
                $mineType = $video->getMimeType();
                ?>
                <video class="wow fadeInRight" data-wow-delay="{{$loadDelay}}s" width="100%" controls controlsList="nodownload" >
                    <source src="{{ asset($localPath) }}" type="{{ $mineType }}">
                    @lang("Votre navigateur ne supporte pas l'affichage de vidéo au standard HTML5.")
                </video>
                <?php
            }
            ?>
            <p class="description wow fadeInLeft" data-wow-delay="{{$loadDelay}}s">
                {{ $establishment->getDescription() }}
            </p>
            <!--
            VIDEO
            -->
            <div class="row">
                @if(isset($data['services']) && !empty($data['services']))
                <div class="col-sm-6 wow fadeInLeft" data-wow-delay="{{$loadDelay}}s">
                    <h2>Services</h2>
                    @foreach($data['services'] as $service)
                    <ul class="category-list">
                        <li>{{ $service }}</li>
                    </ul>                            
                    @endforeach
                </div>
                @endif
                @if(isset($data['ambiences']) && !empty($data['ambiences']))
                <div class="col-sm-6 wow fadeInRight" data-wow-delay="{{$loadDelay}}s">
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
@if(checkFlow($data, ['promo_events']))
<section class="container-fluid ets-events" id="ets-show-events">
    <div class="section-bg"></div>
    <div class="container">
        <h1 class="wow fadeInLeft" data-wow-delay="{{$loadDelay}}s">Nos <strong>événements</strong> et <strong>promotions</strong></h1>
        <br/><br/>
        <div class="row">
            <div class="col-sm-4_5 wow fadeInLeft" data-wow-delay="{{$loadDelay}}s">
                <?php
                $dates = array();
                foreach($data['promo_events'] as $promoEvent){
                    $dates[] = array($promoEvent['start_date'], $promoEvent['end_date'], $promoEvent['type']);
                }
                ?>
                <div class="" id="mini-event-calendar">     
                    {!! Form::hidden('datetime_reservation', '', ['class' => '']) !!}
                </div>
                <script type="text/javascript">
                    document.addEventListener("DOMContentLoaded", function(event) { 
                        var eventsDataJson = JSON.parse('{!! json_encode($dates) !!}');
                        var eventsData = new Array();
                        $.each(eventsDataJson, function (key, value) {
                            var startDate = new Date(value[0]);
                            var endDate = new Date(value[1]);
                            eventsData.push([startDate, endDate, value[2]]);
                        });
                        $('#mini-event-calendar').each(function(){
                            $.datepicker.setDefaults({dayNamesMin: <?php echo json_encode(App\Utilities\DateTools::getDaysFirstLetterArray(7));?>});
                            var $input = $(this).find('input[type=hidden]');
                            
                            if(checkExist($input)){
                                var options = {
                                    dateFormat: "dd/mm/yy",
                                    defaultDate: $input.val(),
                                    showOtherMonths: true,
                                    selectOtherMonths: true,
                                    minDate: 0,
                                    onSelect: function(dateText, inst){
                                        var dateSplit = dateText.split('/');
                                        var timestp = dateSplit[2] + dateSplit[1] + dateSplit[0];
                                        
                                        var $selectedItems = [];
                                        var mediaDisplayed = false;
                                        $('#event-items-list .event-item').hide().each(function(){
                                            var start = $(this).attr('data-start').slice(0, 8);
                                            var end = $(this).attr('data-end').slice(0, 8);
                                            if(timestp >= start && timestp <= end){
                                                var $mediaElement = $(this).find('.event-picture');
                                                $(this).show();
                                                $selectedItems.push(this);
                                                if(!mediaDisplayed && checkExist($mediaElement)){
                                                    $mediaElement.show();
                                                    mediaDisplayed = true;
                                                } else {
                                                    $mediaElement.hide();
                                                }
                                            }
                                        });
                                        $.each($selectedItems, function(key, element){
                                            if($selectedItems.length === 1){
                                                $(element).find('.panel-collapse').addClass('in');
                                                $(element).find('.panel').removeClass('collapsible');
                                                $(element).find('.panel-heading > a').attr('aria-expanded', true);
                                            } else {
                                                $(element).find('.panel-collapse').removeClass('in');
                                                $(element).find('.panel').addClass('collapsible');
                                                $(element).find('.panel-heading > a').attr('aria-expanded', false);

                                            }
                                        });
                                    },
                                    beforeShowDay: function(date){
                                        var selectable = false;
                                        var classes = '';
                                        var datePlusOne = new Date(date);
                                        datePlusOne.setDate(date.getDate()+1);
                                        $.each(eventsData, function (key, value) {
                                            var startEvent = value[0];
                                            var endEvent = value[1];
                                            var eventType = value[2];
                                            
                                            if(date >= startEvent && datePlusOne <= endEvent){
                                                classes += ' ' + eventType + ' ';
                                                selectable = true;
                                            }
                                            if(date <= startEvent && datePlusOne > startEvent){
                                                classes += ' ' + eventType +' start ';
                                                selectable = true;
                                            } 
                                            if(date <= endEvent && datePlusOne > endEvent){
                                                classes += ' ' + eventType +' end ';
                                                selectable = true;
                                            }
                                        });
                                        return [selectable, classes, ''];
                                    }
                                };
                                $(this).datepicker(options);
                            }
                        });
                        $('#event-items-list .event-item .panel').each(function(){
                            $(this).on('hide.bs.collapse', function (e) {
                                if(!$(this).hasClass('collapsible')){
                                    e.stopPropagation();
                                    e.preventDefault();
                                    return false;
                                }
                            });
                        });
                        var nbInitialItems = $('#event-items-list .event-item.first').length;
                        if(nbInitialItems > 1){
                            var $firstItems = $('#event-items-list .event-item.first');
                            $firstItems.find('.panel').addClass('collapsible');
                            $firstItems.find('.panel-collapse').removeClass('in');
                            $firstItems.find('.panel-heading > a').attr('aria-expanded', false);
                            var mediaDisplayed = false;
                            $firstItems.each(function(){
                                var $mediaElement = $(this).find('.event-picture');
                                if(!mediaDisplayed && checkExist($mediaElement)){
                                    $mediaElement.show();
                                    mediaDisplayed = true;
                                } else {
                                    $mediaElement.hide();
                                }
                            });
                        }
                    });
                </script>
            </div>
            <div class="col-sm-7 col-sm-offset-0_5 wow fadeInRight" data-wow-delay="{{$loadDelay}}s" id="event-items-list">
                <?php
                $minTimestp = null;
                if(isset($data['promo_events'][0])){
                    $minTimestp = $data['promo_events'][0]['start_timestp'];
                }
                ?>
                @foreach($data['promo_events'] as $promo)
                <div class="event-item {{ $promo['type'] }} @if((!empty($minTimestp) && $promo['start_timestp'] === $minTimestp) || $loop->iteration === 1) first @endif" 
                     data-start="{{ $promo['start_timestp'] }}" data-end="{{ $promo['end_timestp'] }}">
                    @if(isset($promo['picture']))
                    <div class="event-picture gallery-box">
                        <a class="" href="{{ $promo['picture'] }}">
                            <div class="square-container">
                                <div class="crop">
                                    <img src="{{ $promo['picture'] }}" alt="{{ $promo['name'] }} picture"/>   
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading{!! $loop->iteration !!}">
                            <a role="button" data-parent="#event-items-list" aria-expanded="true" aria-controls="collapse{!! $loop->iteration !!}" data-toggle="collapse"
                               href="#collapse{!! $loop->iteration !!}">
                                <div class="container-fluid no-gutter">
                                    <div class="icon-container">
                                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                    </div>
                                    <div class="title-container">
                                        <h4 class="panel-title">{{ $promo['name'] }}</h4>
                                        <div class="event-date">
                                            <?php
                                            echo formatDate($promo['start_date'], IntlDateFormatter::LONG);
                                            if(!empty($promo['end_date'])){
                                                echo ' - '.formatDate($promo['end_date'], IntlDateFormatter::LONG);
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div id="collapse{!! $loop->iteration !!}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading{!! $loop->iteration !!}">
                            <div class="panel-body container-fluid">
                                <div class="row"> 
                                    <div class="col-xs-12">
                                        {{ $promo['description'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <br class="cleaner"/><br/><br/>
    </div>
</section>
@endif
<!------------- RESTAURANT STAFF -------------------------------------->
@if(checkFlow($data, ['staff']))
<section class="container-fluid ets-staff">
    <div class="section-bg"></div>
    <div class="container">
        <h1 class="wow fadeInLeft" data-wow-delay="{{$loadDelay}}s">Notre <strong>équipe</strong></h1>
        <div class="row">
            @foreach($data['staff'] as $staff)
            <div class="col-xs-6 col-sm-4 thumbnail-item wow fadeInRight" data-wow-delay="{{$loadDelay}}s">
                <div class="thumbnail-picture" style="background-image: url('{{ asset($staff['picture']) }}');">
                    <img src="/img/square-pattern.png" alt="square pattern" class="square-pattern"/>
                </div>
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
    <div class="section-bg"></div>
    <div class="container">
        <h1 class="wow fadeInLeft" data-wow-delay="{{$loadDelay}}s"><strong>Notre</strong> histoire</h1>
        <div class="row wow fadeInRight" data-wow-delay="{{$loadDelay}}s">
            @component('components.timeline', ['items' => $data['story'] ])
                @foreach($data['story'] as $story)
                    @slot("content_".$story['id'])
                        <div class="timeline-content-image square-container">
                            <div class="crop crop-fit">
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
    <div class="section-bg"></div>
    <div class="container">
        <h1 class="wow fadeInLeft" data-wow-delay="{{$loadDelay}}ss"><strong>Horaires</strong> de service</h1>
        <div class="row wow fadeInRight" data-wow-delay="{{$loadDelay}}ss">
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
        <div class="row timetable-show wow fadeInLeft" data-wow-delay="{{$loadDelay}}ss">
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
                        &nbsp;
                    </div>    
                    <div class="col-xs-5_5 col-xs-offset-0_5 col-sm-4_5 col-sm-offset-0 timetable-col timetable-col-pm">
                        @if(isset($timeslot[2]['time']))
                            {{ $timeslot[2]['time'] }}
                        @endif
                        &nbsp;
                    </div>  
                @endif
            </div>
            @endforeach
        </div>
        @if(checkFlow($data, ['close_periods']))
        <br class="cleaner"/><br/>
        <div class="row close-show wow fadeInRight" data-wow-delay="{{$loadDelay}}ss">
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