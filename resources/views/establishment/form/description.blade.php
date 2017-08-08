<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading6">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse6" 
           aria-expanded="true" aria-controls="collapse6">
            <div class="container">
                <h4 class="panel-title">Description détaillée</h4>
            </div>
        </a>
    </div>
    <div id="collapse6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
        <div class="panel-body container">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::label('Description :') !!}
                    <div class="form-group">
                        {!! Form::textarea('description', old('description'), ['class' => 'form-control', 
                            'placeholder'=>'Mettez en valeur votre établissement (Paragraphe : Qui somme nous.)']) !!}  
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