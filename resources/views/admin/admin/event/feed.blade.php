<?php
$ajaxUrl = null;
if(checkModel($event)){
//    $ajaxUrl = '/admin/create/event/ajax';
    echo Form::model($event, ['url' => '/admin/events/'.$event->getUuid(), 'method' => 'PUT', 'files' => true]);
}else{
    $ajaxUrl = '/admin/create/events/ajax';
    echo Form::open(['url'=>'/admin/create/events', 'method' => 'PUT', 'files' => true]);
}
?>
<div class="row">
    <div class="col-xs-12 col-md-5">
        <div class="col-xs-12">
            {!! Form::label('id_establishment','Etablissement') !!}
            <div class="form-group">
                {!! Form::select('id_establishment', [], null, ['class' => 'form-control select2', 'data-ajax-action' => 'feed-establishment-list',
                                                            'data-ajax-url' => $ajaxUrl]) !!}
            </div>
        </div>
        <div class="col-xs-12 form-group">
            {!! Form::label('name',"Titre de l'évenements") !!}
            {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
        </div>
        <div class="col-xs-12 form-group">
            {!! Form::label('id_event_type',"Type de l'événement") !!}
            {!! Form::text('type_event', old('event_type'), ['class' => 'form-control']) !!}
        </div>
        <div class="col-xs-12 form-group">
            {!! Form::label('description',"Description de l'événement") !!}
            {!! Form::textarea('description', old('description'), ['class' => 'form-control']) !!}  
        </div>
        <div class="col-xs-12 col-sm-6 form-group">
            {!! Form::label('start_date','Date de début') !!}
            {!! Form::date('start_date', old('start_date'), ['class' => 'form-control']) !!}  
        </div>
        <div class="col-xs-12 col-sm-6 form-group">
            {!! Form::label('end_date',"Date d'expiration") !!}
            {!! Form::date('end_date', old('end_date'), ['class' => 'form-control']) !!}  
        </div>
        <div class="col-xs-12 col-sm-6 form-group">
            {!! Form::label('start_hour','Heure') !!}
            {!! Form::time('start_hour', old('start_hour'), ['class' => 'form-control']) !!}  
        </div>
        <div class="col-xs-12 col-sm-6 form-group">
            {!! Form::label('end_hour','Heure') !!}
            {!! Form::time('end_hour', old('end_hour'), ['class' => 'form-control']) !!}  
        </div>
    </div>
    <div class="col-xs-12 col-md-7">
        <?php
        $medias = null;
        if(checkModel($event) && $event->medias()->exists()){
            $medias = [$event->medias()->first()];
        }
        ?>
        {!! Form::label('media', "Image/Vidéo") !!}
        @component('components.file-input', 
                            ['name' => 'media',
                            'class' => 'form-control',
                            'medias' => $medias,
                            'fileType' => ['image', 'video']
                            ])

        @endcomponent
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        {!! Form::button('Enregistrer', ['type' => 'button', 'class' => 'form-data-button btn btn-default pull-right']) !!}
    </div>
</div>
{!! form::close() !!}
