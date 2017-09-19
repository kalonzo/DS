<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading1">
        <a role="button" data-toggle="collapse" data-parent="#pro_user_form_accordion" href="#collapse1" 
           aria-expanded="true" aria-controls="collapse1">
            <div class="container">
                <h4 class="panel-title">Créer votre compte client</h4>
            </div>
        </a>
    </div>
    <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
        <div class="panel-body container">
            <div class="row">
                <div class="col-xs-12 form-group text-center">
                    <label class="radio-inline">
                        {!! Form::radio('gender', 0) !!}
                        Société
                    </label>
                    <label class="radio-inline">
                        {!! Form::radio('gender', 1) !!}
                        Madame
                    </label>
                    <label class="radio-inline">
                        {!! Form::radio('gender', 2) !!}
                        Monsieur
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('company[name]','Société / Etablissement') !!}
                    {!! Form::text('company[name]', old('company[name]'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('firstname','* Prénom') !!}
                    {!! Form::text('firstname', old('firstname'), ['class' => 'form-control']) !!}
                </div>
                <div class="col-sm-6 form-group">
                    {!! Form::label('lastname','* Nom') !!}
                    {!! Form::text('lastname', old('lastname'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('email','* E-mail') !!}
                    {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
                </div>       
                <div class="col-sm-6 phone-form-group">
                    {!! Form::label('phone','* Téléphone / Mobile') !!}
                    <div class="form-group form-inline">         
                        @php
                        $selectedPrefix = old('phoneNumber[prefix]');
                        if(isset($form_values['id_country'])){
                            $selectedPrefix = $form_values['id_country'];
                        }
                        @endphp
                        {!! Form::select('phoneNumber[prefix]', $form_data['country_prefixes'], $selectedPrefix, ['class' => 'form-control select2', 'placeholder' => 'Indicatif']) !!}
                        {!! Form::text('phoneNumber[number]', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>     
            <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('password','* Mot de passe') !!}
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>
                <div class="col-sm-6 form-group">
                    {!! Form::label('password-confirm','* Confirmation mot de passe') !!}
                    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    * Champs obligatoires
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