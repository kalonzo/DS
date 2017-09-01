@extends('layouts.front') 

@section('css_imports')
<link href="/css/establishment.css" rel="stylesheet">
<link href="/libraries/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div id="map"> </div>
@if(checkModel($businessCategory))
{!! Form::model($businessCategory, ['url' => '/admin/business_categories/'.$businessCategory->getUuid(), 'method' => 'PUT', 'files' => true]) !!}
@else
{!! Form::open(['url'=>'/establishment', 'method' => 'put', 'files' => true]) !!}
@endif
<div class="container-fluid no-gutter">

    @if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    @if(count($errors))
    <div class="alert alert-danger">
        <strong>Erreur!</strong> Les informations saisies ne sont pas correctes.
        <br/>
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <div class="panel-group form-accordion"  role="tablist" >
        <div class="panel-body container">
            <div class="row">
                <div class='col-md-12 form-group'>
                    {!! Form::select('type', $businessCategory->getLabelByType(), $businessCategory->getType(), ['class' => 'form-control select2']) !!}
                </div>
            </div>
            <div class="row">
                <div class='col-md-12 form-group'>
                    {!! Form::text('name',$businessCategory->getName(), old('name'), ['class' => 'form-control'] ) !!}
                </div>
            </div>
            <div class="row">
                <div class='col-md-12'>
                    <h6> {!! Form::label('status',$status[0]) !!}</h6>
                </div>
            </div>
            <div class="row">
                <div class='col-md-12 form-group'>
                    <input type="submit" value="Corriger / Valider" />
                </div>
            </div>
        </div>
    </div>
</div>
<div id="formControlBottomBand">
    {!! Form::submit('Valider', array('class'=>'btn pull-right')) !!}
</div>
{!! form::close() !!}
@endsection

@section('js_imports_footer')

@endsection
