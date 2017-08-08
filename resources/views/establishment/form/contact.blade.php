<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading2">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse2" 
           aria-expanded="true" aria-controls="collapse2">
            <div class="container">
                <h4 class="panel-title">Contacts</h4>
            </div>
        </a>
    </div>
    <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
        <div class="panel-body container">
            @php
            $callNumbersAvailable = [
                                        1 => '* Téléphone pour réservation',
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
                                        ['class' => 'form-control', 'placeholder' => 'Indicatif']) !!}
                        {!! Form::text('call_number['.$typeNumber.']', $selectedNumber, ['class' => 'form-control']) !!}
                    </div>
                </div>
            @endforeach
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