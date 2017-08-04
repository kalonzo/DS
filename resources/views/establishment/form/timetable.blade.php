<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading10">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse10" 
           aria-expanded="true" aria-controls="collapse10">
            <div class="container">
                <h4 class="panel-title">Horaires</h4>
            </div>
        </a>
    </div>
    <div id="collapse10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading10">
        <div class="panel-body container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Veuillez indiquer vos horaire d'ouverture</h5>
                </div>    
                <div class="col-md-4">
                    <h5>Déjeuner</h5>
                </div>    
                <div class="col-md-4">
                    <h5>Diner</h5>
                </div>    
            </div>
            @foreach($form_data['days'] as $dayIndex => $dayLabel)
            <div class="row">
                <div class="col-md-4">
                    <h5>{{ $dayLabel }}</h5>
                </div>    
                <div class="col-md-4">
                    {!! Form::select('startTimeAm'.$dayIndex, $form_data['timetable'],['placeholder' => '08:00'], array('multiple' => false)) !!}
                    {!! Form::select('endTimeAm'.$dayIndex, $form_data['timetable'], null,['placeholder' => '12:00'], array('multiple' => false)) !!}
                </div>    
                <div class="col-md-4">
                    {!! Form::select('startTimePm'.$dayIndex, $form_data['timetable'], null,['placeholder' => '13:00'], array('multiple' => false)) !!}
                    {!! Form::select('endTimePm'.$dayIndex, $form_data['timetable'], null,['placeholder' => '22:00'], array('multiple' => false)) !!}
                </div>    
            </div>
            @endforeach
            <div class="row">
                <div class="col-md-12">
                    <h5> Fermeture exceptionnelle</h5> 
                </div>      
            </div>
        </div> 
    </div>
</div>    