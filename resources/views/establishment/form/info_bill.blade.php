<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading13">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse5" 
           aria-expanded="true" aria-controls="collapse5">
            <div class="container">
                <h4 class="panel-title">Saisissez vos informations de facturations</h4>
            </div>
        </a>
    </div>
    <div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
        <div class="panel-body container">
            <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('* Société / Etablissement') !!}
                    {!! Form::text('address[company_name]', old('company_name'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('* Prénom') !!}
                    {!! Form::text('bills[prename]', old('address_additional'), ['class' => 'form-control']) !!}
                </div>
                <div class="col-sm-6 form-group">
                    {!! Form::label('* Nom') !!}
                    {!! Form::text('bills[name]', old('district'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8 col-sm-10 form-group {{ $errors->has('street') ? 'has-error' : '' }}">
                    {!! Form::label('* Adresse') !!}	
                    {!! Form::text('address[street]', old('street'),['class' => 'form-control',]) !!}
                </div>
                <div class="col-xs-4 col-sm-2 form-group {{ $errors->has('street_number') ? 'has-error' : '' }}">
                    {!! Form::label('* N° Rue') !!}
                    {!! Form::text('address[street_number]', old('street_number'), ['class' => 'form-control']) !!}
                </div>  
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    {!! Form::label('* P.O. BOX') !!}
                    {!! Form::text('address[po_box]', old('district'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    {!! Form::label('* NPA') !!}
                    <div class="form-group {{ $errors->has('postal_code') ? 'has-error' : '' }}">
                        {!! Form::text('address[postal_code]', old('postal_code'), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-8">
                    {!! Form::label('* Localité') !!}
                    <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                        {!! Form::text('address[city]', old('city'), ['class' => 'form-control',]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    {!! Form::label('* Pays') !!}
                    <div class="form-group {{ $errors->has('id_country') ? 'has-error' : '' }}">
                        {!! Form::select('address[id_country]', $form_data['country_ids'], $form_values['id_country'], ['class' => 'form-control select2']) !!}
                    </div>
                </div>
            </div>
            @php
            $callNumbersAvailable = [
            5 => '* Téléphone pro',
            4 => '* Téléphone de contact',                            
            3 => 'Fax',
            2 => 'Mobile'
            ];
            @endphp
            <div class="row">
                @foreach($callNumbersAvailable as $typeNumber => $label)
                <div class="col-md-6">
                    {!! Form::label($label) !!}
                    <div class="form-group form-inline {{ $errors->has('call_number['.$typeNumber.']') ? 'has-error' : '' }}">
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
                <div class="col-md-12 accordion-inner">
                    {!! Form::label(' e-mail') !!}
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
                    </div>
                </div>    
            </div>
            <div class="row">
                <div class="col-md-1">
                    <button type="button" role="button" class="btn btn-md pull-right text-uppercase" onclick="goToNextAccordion(this);">
                        Suivant
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>