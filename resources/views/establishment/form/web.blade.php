<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading3">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse3" 
           aria-expanded="true" aria-controls="collapse3">
            <div class="container">
                <h4 class="panel-title">www</h4>
            </div>
        </a>
    </div>
    <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
        <div class="panel-body container">
            <div class="row">
                <div class="col-md-12 accordion-inner">
                    {!! Form::label('email',' e-mail') !!}
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
                    </div>
                    {!! Form::label('site_url',' Site web de votre restaurant') !!}
                    <div class="form-group">
                        {!! Form::text('site_url', old('site_url'), ['class' => 'form-control', 'placeholder' => 'Enter Message']) !!}
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