<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading13">
        <a role="button" data-toggle="collapse" data-parent="#pro_user_form_accordion" href="#collapse5" 
           aria-expanded="true" aria-controls="collapse5">
            <div class="container">
                <h4 class="panel-title">Saisissez vos informations de facturations</h4>
            </div>
        </a>
    </div>
    <div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
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
                    {!! Form::label('address[company_name]','Société / Etablissement') !!}
                    {!! Form::text('address[company_name]', old('company_name'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('address[firstname]','* Prénom') !!}
                    {!! Form::text('address[firstname]', old('address_additional'), ['class' => 'form-control']) !!}
                </div>
                <div class="col-sm-6 form-group">
                    {!! Form::label('address[lastname]','* Nom') !!}
                    {!! Form::text('address[lastname]', old('district'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8 col-sm-10 form-group">
                    {!! Form::label('address[street]','* Adresse') !!}	
                    {!! Form::text('address[street]', old('address[street]'),['class' => 'form-control']) !!}
                </div>
                <div class="col-xs-4 col-sm-2 form-group">
                    {!! Form::label('address[street_number]','* N° Rue') !!}
                    {!! Form::text('address[street_number]', old('address[street_number]'), ['class' => 'form-control']) !!}
                </div>  
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('address[po_box]',' P.O. BOX') !!}
                    {!! Form::text('address[po_box]', old('address[po_box]'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 form-group">
                    {!! Form::label('address[postal_code]','* NPA') !!}
                    {!! Form::text('address[postal_code]', old('address[postal_code]'), ['class' => 'form-control']) !!}
                </div>
                <div class="col-sm-8 form-group">
                    {!! Form::label('address[city]','* Localité') !!}
                    {!! Form::text('address[city]', old('address[city]'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('address[id_country]','* Pays') !!}
                    {!! Form::select('address[id_country]', $form_data['country_ids'], $form_values['id_country'], [
                        'class' => 'form-control select2 full-width']) !!}
                </div>
            </div>
            @php
            $callNumbersAvailable = [
                                        4 => '* Téléphone professionnel',
                                        5 => 'Téléphone',
                                        3 => 'Fax',
                                        2 => 'Mobile'
                                    ];
            @endphp
            <div class="row">
                @foreach($callNumbersAvailable as $typeNumber => $label)
                <div class="col-sm-6 phone-form-group">
                    {!! Form::label($label,$label) !!}
                    <div class="form-group form-inline">
                        @php
                        $selectedPrefix = old('id_country_prefix['.$typeNumber.']');
                        $selectedNumber = old('call_number['.$typeNumber.']');
                        if(isset($form_values['call_numbers'][$typeNumber]['number'])){
                        $selectedNumber = $form_values['call_numbers'][$typeNumber]['number'];
                        }
                        if(isset($form_values['call_numbers'][$typeNumber]['id_country_prefix'])){
                        $selectedPrefix = $form_values['call_numbers'][$typeNumber]['id_country_prefix'];
                        } else if(isset($form_values['id_country'])){
                        $selectedPrefix = $form_values['id_country'];
                        }
                        @endphp

                        {!! Form::select('id_country_prefix['.$typeNumber.']', $form_data['country_prefixes'], $selectedPrefix, 
                        ['class' => 'form-control select2', 'placeholder' => 'Indicatif']) !!}
                        {!! Form::text('call_number['.$typeNumber.']', $selectedNumber, ['class' => 'form-control']) !!}
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('email','* E-mail') !!}
                    {!! Form::text('address[email]', old('email'), ['class' => 'form-control']) !!}
                </div>    
            </div>
            <div class="row">
                <div class="col-sm-6">
                    * Champs obligatoires
                </div>
            </div>
        </div>
    </div>
</div>