<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading9">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse9" 
           aria-expanded="true" aria-controls="collapse9">
            <div class="container">
                <h4 class="panel-title">Photos et galeries</h4>
            </div>
        </a>
    </div>
    <div id="collapse9" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading9">
        <div class="panel-body container">
            <div class="row">
                <div class="col-xs-12 form-group">
                    @if($establishment->logo()->exists())
                    <img src="{{ asset($establishment->logo()->first()->getLocalPath()) }}" style="width: 50px;" />
                    @endif
                    {{ Form::label('Sélectionnez votre logo') }}
                    {!! Form::file('logo', ['class'=>'form-control bootstrap-file-input file-input-single']) !!}
                </div>
            </div>
            <br/><br/>
            <div class="row">
                <div class="col-xs-12 form-group">
                    Ajoutez les photos les plus représentatives de votre restaurant (format JPEG, PNG) en haute résolution.<br/>
                    Les photos seront affichées dans la page d\'accueil
                    <br/><br/>
                    {{ Form::label('Images page d\'accueil') }}
                    {!! Form::file('home_pictures', ['class'=>'form-control bootstrap-file-input file-input-multiple']) !!}
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