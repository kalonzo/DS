@extends('layouts.front') 

@section('css_imports')
<link href="/css/establishment.css" rel="stylesheet">
<link href="/libraries/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="container">
    {!! Form::open(['url'=>'/admin/', 'method' => 'put', 'files' => true]) !!}
    <div class="row">
        <div class="col-md-6 form-group">
            <div class="row">
                <div class="col-md-6">
                    Import xlsx
                </div>
                <div class="col-md-6">
                     Types d'imports
                </div>
            </div>
        </div> 
        <div class="col-md-6 form-group">
            <div class="row">
                <div class="col-md-6">
                   {!! Form::file('file', old('file'),['class' => 'form-control bootstrap-file-input file-input-single']) !!}
                </div>
                <div class="col-md-6">
                    {!! Form::text('type', old('type'),['class' => 'form-control']) !!}
                </div>
            </div>
        </div> 
    </div>

    <div class="row">

    </div>

    <div class="row">

    </div>
    <div class="row">

    </div>
    <div id="formControlBottomBand">
        {!! Form::submit('Valider', array('class'=>'btn pull-right')) !!}
    </div>
    {!! form::close() !!}
   
</div>
@endsection

@section('js_imports_footer')
<script src="/libraries/bootstrap-fileinput/js/fileinput.min.js"></script>
@endsection