<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading1">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse1" 
           aria-expanded="true" aria-controls="collapse1">
            <div class="container">
                <h4 class="panel-title">Créer votre compte client</h4>
            </div>
        </a>
    </div>
    <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
        <div class="panel-body container">
            <!-- Saisie de l'adresse de l'établissement-->
            <div class="row">
                <div class="col-sm-4 form-group">
                    {!! Form::label('Madame') !!}
                    {!! Form::radio('gender', old('company_name'), ['class' => 'form-control']) !!}
                </div>
                <div class="col-sm-4 form-group">
                    {!! Form::label('Monsieur') !!}
                    {!! Form::radio('gender', old('company_name'), ['class' => 'form-control']) !!}
                </div>
                <div class="col-sm-4 form-group">
                    {!! Form::label('Société') !!}
                    {!! Form::radio('gender', old('company_name'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('* Société / Etablissement') !!}
                    {!! Form::text('address[company_name]', old('company_name'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('* Prénom') !!}
                    {!! Form::text('firstname', old('firstname'), ['class' => 'form-control']) !!}
                </div>
                <div class="col-sm-6 form-group">
                    {!! Form::label('* Nom') !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    {!! Form::label('* e-mail') !!}
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
                    </div>
                </div>       
                <div class="col-md-6">
                    {!! Form::label('* Téléphone / Mobile') !!}
                    <div class="form-group form-inline {{ $errors->has('call_number[contact_number]') ? 'has-error' : '' }}">                        
                            {!! Form::select('prefix', $form_data['country_prefixes'], null, 
                                        ['class' => 'form-control select2', 'placeholder' => 'Indicatif']) !!}
                        {!! Form::text('pro_phone', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>     
            <div class="row">
                <div class="col-md-6">
                    <label for="password" class="col-md-4 control-label">* Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-md-6">
                    <label for="password-confirm" class="col-md-4 control-label">* Confirm Password</label>                   
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h5 class="panel-title">* Champs obligatoires</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <button type="button" role="button" class="btn btn-md pull-right text-uppercase" onclick="goToNextAccordion(this);">
                        Suivant
                    </button>
                </div>
            </div>
        </div>
    </div> 
</div>