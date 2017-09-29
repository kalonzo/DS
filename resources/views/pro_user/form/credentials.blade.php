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
                        {!! Form::radio('user[gender]', 0) !!}
                        Société
                    </label>
                    <label class="radio-inline">
                        {!! Form::radio('user[gender]', 1) !!}
                        Madame
                    </label>
                    <label class="radio-inline">
                        {!! Form::radio('user[gender]', 2) !!}
                        Monsieur
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('user[company]','Société / Etablissement') !!}
                    {!! Form::text('user[company]', old('user[company]'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('user[firstname]','* Prénom') !!}
                    {!! Form::text('user[firstname]', old('user[firstname]'), ['class' => 'form-control']) !!}
                </div>
                <div class="col-sm-6 form-group">
                    {!! Form::label('user[lastname]','* Nom') !!}
                    {!! Form::text('user[lastname]', old('user[lastname]'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('user[email]','* E-mail') !!}
                    {!! Form::text('user[email]', old('user[email]'), ['class' => 'form-control']) !!}
                </div>       
                <div class="col-sm-6 phone-form-group">
                    <?php echo Form::label('user[call_number]['.\App\Models\CallNumber::TYPE_PHONE_CONTACT.']','* Téléphone / Mobile');?>
                    <div class="form-group form-inline">         
                        <?php
                        $selectedPrefix = old('user[id_country_prefix]['.\App\Models\CallNumber::TYPE_PHONE_CONTACT.']');
                        if(isset($form_values['id_country'])){
                            $selectedPrefix = $form_values['id_country'];
                        }
                        echo Form::select('user[id_country_prefix]['.\App\Models\CallNumber::TYPE_PHONE_CONTACT.']', $form_data['country_prefixes'], $selectedPrefix, 
                                                            ['class' => 'form-control select2', 'placeholder' => 'Indicatif']);
                        echo Form::text('user[call_number]['.\App\Models\CallNumber::TYPE_PHONE_CONTACT.']', null, ['class' => 'form-control']);
                        ?>
                    </div>
                </div>
            </div>     
            <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('user[password]','* Mot de passe') !!}
                    {!! Form::password('user[password]', ['class' => 'form-control']) !!}
                </div>
                <div class="col-sm-6 form-group">
                    {!! Form::label('user[password_confirmation]','* Confirmation mot de passe') !!}
                    {!! Form::password('user[password_confirmation]', ['class' => 'form-control']) !!}
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