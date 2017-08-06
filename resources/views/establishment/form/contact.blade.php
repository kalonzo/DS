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
            <div class="row">
                <div class="col-md-6">
                    {!! Form::label('* Téléphone pour réservation') !!}
                    <div class="form-group {{ $errors->has('numberReservation') ? 'has-error' : '' }}">
                        {!!  Form::select('callNumberPrefixIdsByNameReservation',$form_data['country_prefixes'], ['class'=>
                        'form-control',
                        ]) !!}
                        {!! Form::text('numberReservation', old('number'), [
                        'class'=>'form-control', 
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    {!! Form::label('* Téléphone de contact') !!}
                    <div class="form-group {{ $errors->has('contactNumber') ? 'has-error' : '' }} " >

                        {!!  Form::select('callNumberPrefixIdsByNameContact',$form_data['country_prefixes'], ['class'=>
                        'form-control',
                        ]) !!}
                        {!! Form::text('contactNumber', old('number'), ['class'=>
                        'form-control',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    {!! Form::label('  Fax') !!}
                    <div class="form-group ">

                        {!!  Form::select('callNumberPrefixIdsByNameFax',$form_data['country_prefixes'], ['class'=>
                        'form-control',
                        ]) !!}
                        {!! Form::text('fax', old('fax'), [
                        'class'=>'form-control', 
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    {!! Form::label('  Mobile') !!}
                    <div class="form-group">
                        {!!  Form::select('callNumberPrefixIdsByNameMobile',$form_data['country_prefixes'], ['class'=>
                        'form-control',
                        ]) !!}
                        {!! Form::text('mobile', old('mobile'), [
                        'class'=>'form-control',
                        ]) !!}
                    </div>
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