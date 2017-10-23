<?php
$ajaxUrl = null;
if(checkModel($user)){
    echo Form::model($user, ['url' => '/admin/users/'.$user->getUuid(), 'method' => 'PUT']);
}else{
    $ajaxUrl = '/admin/create/users/ajax';
    echo Form::open(['url'=>'/admin/create/users', 'method' => 'PUT']);
}
?>
{!! Form::hidden('type', $form_data['type']) !!}
<div class="row">
    <div class="col-xs-12 form-group">
        {!! Form::label('lastname','* Nom') !!}	
        {!! Form::text('lastname', old('lastname'),['class' => 'form-control', 'required', 'autofocus']) !!}
    </div>

    <div class="col-xs-12 form-group">
        {!! Form::label('firstname','* Prénom') !!}	
        {!! Form::text('firstname', old('firstname'),['class' => 'form-control', 'required', 'autofocus']) !!}
    </div>

    <div class="col-xs-12 form-group">
        {!! Form::label('email','* Email') !!}	
        {!! Form::email('email', old('email'),['class' => 'form-control', 'required']) !!}
    </div>

    <div class="col-xs-12 form-group">
        {!! Form::label('password','* Mot de passe') !!}	
        {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
    </div>

    <div class="col-xs-12 form-group">
        {!! Form::label('password_confirmation','* Confirmer votre mot de passe') !!}	
        {!! Form::password('password_confirmation', ['class' => 'form-control', 'required']) !!}
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        {!! Form::button('Enregistrer', ['type' => 'button', 'class' => 'form-data-button btn btn-default pull-right']) !!}
    </div>
</div>
{!! Form::close() !!}
