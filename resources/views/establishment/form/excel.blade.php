<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading9">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse1" 
           aria-expanded="true" aria-controls="collapse1">
            <div class="container">
                <h4 class="panel-title">Fonction import</h4>
            </div>
        </a>
    </div>
    <div id="collapse1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1">
        <div class="panel-body container">
            <div class="row">
                <div class="col-xs-12 form-group">
                    Ajoutez les photos les plus représentatives de votre restaurant (format JPEG, PNG) en haute résolution.<br/>
                    Les photos seront affichées dans la page d\'accueil
                    <br/><br/>
                    @php
                        $medias = null;
                    @endphp
                    
                    <input type="file" name="csv" />
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