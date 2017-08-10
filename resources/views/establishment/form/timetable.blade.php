<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading10">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse12" 
           aria-expanded="true" aria-controls="collapse12">
            <div class="container">
                <h4 class="panel-title">Horaires</h4>
            </div>
        </a>
    </div>
    <div id="collapse12" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading12">
        <div class="panel-body container">
            <div class="row">
                <div class="col-xs-12 no-gutter">
                    <h5>Veuillez indiquer vos horaires d'ouverture</h5>
                </div>    
            </div>
            <div class="row">
                <div class="col-xs-5_5 col-sm-2">
                    &nbsp;
                </div> 
                <div class="col-xs-5_5 col-sm-4 text-center">
                    <h5>Déjeuner</h5>
                </div>    
                <div class="hidden-xs col-xs-5_5 col-sm-4 col-sm-offset-0_5 text-center">
                    <h5>Diner</h5>
                </div>    
            </div>
            <div id="timetable-grid">
                @foreach($form_data['days'] as $dayIndex => $dayLabel)
                    @php
                    $startTimeAmKey = 1;
                    $startTimeAm = old("openingHours[".$dayIndex."][1][start]");
                    if(isset($form_values['opening_hours'][$dayIndex][1]['start']['time'])){
                        $startTimeAm = $form_values['opening_hours'][$dayIndex][1]['start']['time'];
                    }
                    if(isset($form_values['opening_hours'][$dayIndex][1]['start']['key'])){
                        $startTimeAmKey = $form_values['opening_hours'][$dayIndex][1]['start']['key'];
                    }
                    $endTimeAmKey = 1;
                    $endTimeAm = old("openingHours[".$dayIndex."][1][end]");
                    if(isset($form_values['opening_hours'][$dayIndex][1]['end']['time'])){
                        $endTimeAm = $form_values['opening_hours'][$dayIndex][1]['end']['time'];
                    }
                    if(isset($form_values['opening_hours'][$dayIndex][1]['end']['key'])){
                        $endTimeAmKey = $form_values['opening_hours'][$dayIndex][1]['end']['key'];
                    }
                    
                    $startTimePmKey = 2;
                    $startTimePm = old("openingHours[".$dayIndex."][2][start]");
                    if(isset($form_values['opening_hours'][$dayIndex][2]['start']['time'])){
                        $startTimePm = $form_values['opening_hours'][$dayIndex][2]['start']['time'];
                    }
                    if(isset($form_values['opening_hours'][$dayIndex][2]['start']['key'])){
                        $startTimePmKey = $form_values['opening_hours'][$dayIndex][2]['start']['key'];
                    }
                    $endTimePmKey = 2;
                    $endTimePm = old("openingHours[".$dayIndex."][2][end]");
                    if(isset($form_values['opening_hours'][$dayIndex][2]['end']['time'])){
                        $endTimePm = $form_values['opening_hours'][$dayIndex][2]['end']['time'];
                    }
                    if(isset($form_values['opening_hours'][$dayIndex][2]['end']['key'])){
                        $endTimePmKey = $form_values['opening_hours'][$dayIndex][2]['end']['key'];
                    }
                    @endphp
                    <div class="row timetable-grid-row form-group">
                        <div class="col-xs-5_5 col-sm-2 timetable-day">
                            {{ $dayLabel }}
                        </div>    
                        <div class="col-xs-5_5 col-sm-4 col-xs-offset-0_5 col-sm-offset-0 col-sm-4 timetable-col timetable-col-am">
                            {!! Form::select("openingHours[".$dayIndex."][".$startTimeAmKey."][start]", $form_data['timetable'], $startTimeAm,['placeholder' => 'Début']) !!}
                            {!! Form::select("openingHours[".$dayIndex."][".$endTimeAmKey."][end]", $form_data['timetable'], $endTimeAm,['placeholder' => 'Fin']) !!}
                            <a class="col-xs-12 no-gutter close-timeslot" href="javascript:void(0);" onclick="closeTimeSlot(this);">Fermé</a>
                        </div>    
                        <div class="col-xs-5_5 hidden-sm hidden-md hidden-lg">
                            &nbsp;
                        </div>    
                        <div class="col-xs-5_5 col-sm-4 col-xs-offset-0_5 timetable-col timetable-col-pm">
                            {!! Form::select("openingHours[".$dayIndex."][".$startTimePmKey."][start]", $form_data['timetable'], $startTimePm,['placeholder' => 'Début']) !!}
                            {!! Form::select("openingHours[".$dayIndex."][".$endTimePmKey."][end]", $form_data['timetable'], $endTimePm,['placeholder' => 'Fin']) !!}
                            <a class="col-xs-12 no-gutter close-timeslot" href="javascript:void(0);" onclick="closeTimeSlot(this);">Fermé</a>
                        </div>    
                        <div class="col-sm-1_5 timetable-action">
                            @if($loop->iteration == 1)
                            <button type="button" role="button" class="btn btn-md text-uppercase" onclick="duplicateTimeSlots(this);">
                                Copier
                            </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="cleaner"></div>
            <div class="row">
                <div class="col-md-12">
                    <h5> Fermeture exceptionnelle</h5> 
                </div>      
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="button" role="button" class="btn btn-md pull-right text-uppercase" onclick="goToNextAccordion(this);">
                        Suivant
                    </button>
                </div>
            </div>
        </div> 
    </div>
</div>    