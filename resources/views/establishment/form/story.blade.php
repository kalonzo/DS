<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading13">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse14" 
           aria-expanded="true" aria-controls="collapse14">
            <div class="container">
                <h4 class="panel-title">Notre histoire</h4>
            </div>
        </a>
    </div>
    <div id="collapse14" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading14">
        <div class="panel-body container">
            <div class="row"> 
                Veuillez insérer une brief histoire sur votre établissement
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 form-group">
                        {!! Form::file('logo', ['class' => 'form-control bootstrap-file-input file-input-single']) !!}
                    </div>
                    <div class="col-md-8 form-group">
                        {!! Form::label('Titre') !!}
                        {!! Form::text('title') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        {!! Form::selectYear('year', 1800, 2018); !!} 
                    </div>
                    <div class="col-md-4 form-group">
                        {!! Form::label('Description :') !!}
                        {!! Form::textarea('content', old('content'), ['class' => 'form-control', 
                        'placeholder' => 'Mettez en valeur l\'historique de votre établissement (Ouverture/fermeture/Ajout du restaureant dans le guide Dinerscope)']) !!}  
                    </div>
                </div>
            </div>
            <!-- Example d'historique -->
            <div class="row">
                <div class="col-md-4 form-group">
                    <img src="" width="30" height="30"/>
                    2001 Ouverture du restaurant
                </div>
                <div class="col-md-4 form-group">
                    <img src="" width="30" height="30"/>
                    2002 Le restaurant prend feu
                </div>
                <div class="col-md-4 form-group">
                    <img src="" width="30" height="30"/>
                    2018 Rien ne nous arréterra
                </div>
            </div>
            <!--------->

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