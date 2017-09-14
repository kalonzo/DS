@if(checkModel($businessCategory))
{!! Form::model($businessCategory, ['url' => '/admin/business_categories/'.$businessCategory->getUuid(), 'method' => 'PUT', 'files' => true]) !!}
@else
{!! Form::open(['url'=>'/establishment', 'method' => 'put', 'files' => true]) !!}
@endif

<div class="row">
    <div class="col-xs-12 col-md-5">
        <div class="col-xs-12 col-sm-6 form-group">                    
            {!! Form::select('type', $businessCategory->getLabelByType(), $businessCategory->getType(), ['class' => 'form-control select2']) !!}
        </div>
        <div class="col-xs-12 col-sm-6 form-group">
            {!! Form::text('name',$businessCategory->getName(), old('name'), ['class' => 'form-control'] ) !!}
            <h6> {!! Form::label('status',$status[0]) !!}</h6>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        {!! Form::submit('Enregistrer', ['type' => 'button', 'class' => 'form-data-button btn btn-default pull-right']) !!}
    </div>
</div>
{!! form::close() !!}
