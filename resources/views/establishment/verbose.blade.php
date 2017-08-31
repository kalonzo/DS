@extends('layouts.admin') 

@section('css_imports')
<link href="/css/establishment.css" rel="stylesheet">
@endsection

@section('content')

    {!! Form::open(['url'=>'/admin/establishment/verbose', 'method' => 'post', 'files' => false]) !!}

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
        <div class="panel-group form-accordion" id="establishment_form_accordion" role="tablist" aria-multiselectable="true">

            
        </div>
    </div>
    <div id="formControlBottomBand">
        {!! Form::submit('Valider', array('class'=>'btn pull-right')) !!}
    </div>
    {!! form::close() !!}
@endsection

@section('js_imports_footer')
<script src="/libraries/bootstrap-fileinput/js/fileinput.min.js"></script>
@endsection
