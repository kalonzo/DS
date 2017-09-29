<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading7">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse10" 
           aria-expanded="true" aria-controls="collapse10">
            <div class="container">
                <h4 class="panel-title">Vidéos</h4>
            </div>
        </a>
    </div>
    <div id="collapse10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading10">
        <div class="panel-body container">
            @if(checkModel($establishment))
            <div class="row form-group" id='ets-video'>
                <div class="col-xs-12">
                    <p>
                        @lang("Veuillez télécharger votre vidéo. Elle ne sera pas publiée avant l'accord de l'administrateur.") 
                    </p>
                    <br/>
                    @php
                        $medias = null;
                        if(checkModel($establishment) && $establishment->video()->exists()){
                            $medias = [$establishment->video()->first()];
                        }
                    @endphp
                    @component('components.file-input', 
                                        [
                                        'name' => 'video',
                                        'class' => 'form-control',
                                        'multiple' => false,
                                        'medias' => $medias,
                                        'fileType' => 'video',
                                        'showRemove' => 'false',
                                        'directUpload' => 'true',
                                        'fileRefreshOnUpload' => 'true',
                                        'uploadUrl' => '/edit/establishment/'.$establishment->getUuid().'/ajax',
                                        ])
                        @slot('extraData')
                            {'action': 'add_video'}
                        @endslot
                    @endcomponent
                </div>
            </div>
            
            @else
            <div class="row incomplete-sheet-disclaimer">
                <div class="col-xs-12">
                    <p>
                        L'ajout de vidéo sera accessible une fois votre établissement enregistré avec les informations minimales requises.
                    </p>
                </div>
            </div>
            @endif
            
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