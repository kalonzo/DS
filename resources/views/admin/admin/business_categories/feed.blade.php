<?php
$ajaxUrl = null;
if(checkModel($businessCategory)){
    echo Form::model($businessCategory, ['url' => '/admin/business_categories/'.$businessCategory->getUuid(), 'method' => 'PUT']);
}else{
    $ajaxUrl = '/admin/create/business_categories/ajax';
    echo Form::open(['url'=>'/admin/create/business_categories', 'method' => 'PUT']);
}
?>
<div class="row">
    <div class="col-xs-12 col-md-5">
        <div class="col-xs-12 form-group">             
            {!! Form::label('type', 'Type') !!}
            {!! Form::select('type', $form_data['business_categories_types'], old('type'), ['class' => 'form-control select2']) !!}
        </div>
        <div class="col-xs-12 form-group"> 
            {!! Form::label('name', 'Label') !!}
            {!! Form::text('name', old('name'), ['class' => 'form-control'] ) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        {!! Form::button('Enregistrer', ['type' => 'button', 'class' => 'form-data-button btn btn-default pull-right']) !!}
    </div>
</div>
{!! form::close() !!}
