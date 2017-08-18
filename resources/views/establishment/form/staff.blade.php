<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading13">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse13" 
           aria-expanded="true" aria-controls="collapse7">
            <div class="container">
                <h4 class="panel-title">Notre équipe</h4>
            </div>
        </a>
    </div>
    <div id="collapse13" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading13">
        <div class="panel-body container">
            <div class="row"> 
                <div class="col-xs-12 col-sm-12 form-group">
                    {!! Form::label('Veuillez télécharger les informations de votre équipe') !!}	
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row"> 
                        <div class="col-xs-6 col-sm-10 form-group ">
                            {!! Form::label('Ajouter votre image') !!}	
                            {!! Form::file('logo', old('logo'),['class' => 'form-control bootstrap-file-input file-input-single']) !!}
                        </div>
                        <div class="col-xs-6 col-sm-2 form-group ">
                            {!! Form::label('Nom / Prénom') !!}
                            {!! Form::text('complete_name', old('complete_name'), ['class' => 'form-control']) !!}
                        </div>      
                    </div>
                    <div class="row"> 
                        <div class="col-xs-6 col-sm-10 form-group ">
                            <div class="row">
                                <div class="col-xs-6 col-sm-10 form-group ">
                                    {!! Form::radio('job_title', old('job_type'), ['class' => 'form-control']) !!}
                                    {!! Form::label('Chef de cuisine') !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-10 form-group ">
                                    {!! Form::radio('job_title', old('job_type'), ['class' => 'form-control']) !!}
                                    {!! Form::label('Commis') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-2 form-group ">
                            {!! Form::label('Titre') !!}
                            {!! Form::text('position', old('position'), ['class' => 'form-control']) !!}
                        </div>      
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-md pull-right text-uppercase">
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </div>
            </div> 

            <!-- composant vignettee -->
            <div class="row">
                <div class="col-md-4 form-group">
                    <img src="" width="30" height="30"/>
                    Pablo Callejo
                    Chef de cuisine
                </div>
                <div class="col-md-4 form-group">
                    <img src="" width="30" height="30"/>
                    Kenny Alonzo
                    Staff
                </div>
                <div class="col-md-4 form-group">
                    <img src="" width="30" height="30"/>
                    Alexine Brutin
                    Staff
                </div>
            </div>
            <div class="row form-group">
                <div class="col-xs-12">
                    <button type="button" role="button" class="btn btn-md pull-right text-uppercase" onclick="goToNextAccordion(this);">
                        Suivant
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>