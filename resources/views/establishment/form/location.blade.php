<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading1">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse1" 
           aria-expanded="true" aria-controls="collapse1">
            <div class="container">
                <h4 class="panel-title">Emplacement</h4>
            </div>
        </a>
    </div>
    <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
        <div class="panel-body container">
            <!-- Saisie de l'adresse de l'établissement-->
            <div class="row"> 
                <div class="col-xs-8 col-sm-10 form-group {{ $errors->has('street') ? 'has-error' : '' }}">
                    {!! Form::label('* Adresse') !!}	
                    {!! Form::text('street', old('street'), [
                    'class'=>'form-control',
                    ]) !!}
                </div>
                <div class="col-xs-4 col-sm-2 form-group {{ $errors->has('street_number') ? 'has-error' : '' }}">
                    {!! Form::label('* N° Rue') !!}
                    {!! Form::text('street_number', old('street_number'), ['class'=>
                    'form-control', 
                    ]) !!}
                </div>      
            </div>

            <div class="row">
                <div class="col-xs-8 col-sm-10 form-group">
                    {!! Form::label('Complément d\'adresse') !!}
                    {!! Form::text('address_additional', old('address_additional'), [
                    'class'=>'form-control',
                    ]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    {!! Form::label('* NPA') !!}
                    <div class="form-group {{ $errors->has('postal_code') ? 'has-error' : '' }}">
                        {!! Form::text('postal_code', old('postal_code'), [
                        'class'=>'form-control', 
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-8">
                    {!! Form::label('* Localité') !!}
                    <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                        {!! Form::text('city', old('city'), ['class'=>
                        'form-control',
                        ]) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    {!! Form::label('* Canton/Départements') !!}
                    <div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
                        {!! Form::text('canton', old('canton'), [
                        'class'=>'form-control', 
                        ]) !!}
                        {!! Form::text('area', old('area'), ['class'=>'hidden']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    {!! Form::label('* Pays') !!}
                    <div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
                        {!! Form::text('country', old('country'), [
                        'class'=>'form-control', 
                        ]) !!}
                        <p id="demo"></p>
                    </div>

                </div>

            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-4 form-group {{ $errors->has('latitude') ? 'has-error' : '' }}">
                    {!! Form::label('* Latitude') !!}
                    {!! Form::text('latitude', old('latitude'), [
                    'class'=>'form-control',
                    'readonly' => 'readonly'
                    ]) !!}
                </div>           
                <div class="col-xs-6 col-sm-4 form-group {{ $errors->has('longitude') ? 'has-error' : '' }}">
                    {!! Form::label('* Longitude') !!}
                    {!! Form::text('longitude', old('longitude'), ['class'=>
                    'form-control', 
                    'readonly' => 'readonly'
                    ]) !!}
                </div>
                <div class="col-xs-12 col-sm-4 form-group">
                    <label>&nbsp;</label>
                    <button type="button" role="button" class="btn btn-sm col-xs-12" onclick="getCoords(this);">
                        <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Géolocaliser mon établissement
                    </button>
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