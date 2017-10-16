<div class="panel panel-default" id='ets-photos'>
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
            <div class="row form-group" id="logo-submit-container">
                <div class="col-xs-12">
                    <h5>Logo</h5>
                    <?php
                    $logoOriginal = null;
                    $logoDraft = null;
                    if(checkModel($establishment)){
                        $logoOriginal = $establishment->logo()->first();
                    }
                    if(checkModel($logoOriginal) && checkModelId($logoOriginal->getIdDraftMedia())){
                        $logoDraft = $logoOriginal->mediaDraft()->first();
                    }
                    if(checkModel($logoDraft)){
                        ?>
                        <div class="col-xs-6">
                            <h6>Logo actuel</h6>
                        <?php
                    }
                    ?>
                    @component('components.file-input', 
                                        ['name' => 'logo',
                                        'class' => 'form-control',
                                        'medias' => $logoOriginal,
                                        'fileType' => 'image'
                                        ])
                    
                    @endcomponent
                    <?php
                    if(checkModel($logoDraft)){
                        ?>
                        </div>
                        <div class="col-xs-6 logo-submit-draft">
                            <h6>Logo en attente de validation</h6>
                            <div class="col-xs-12 logo-draft-container" style="background-image: url('{{ $logoDraft->getLocalPath() }}');">

                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <br/>
            <div class="row form-group" id='ets-thumbnail'>
                @if(checkModel($establishment))
                <div class="col-xs-12">
                    <h5>Vignette</h5>
                    <p>
                        @lang("Veuillez télécharger une image qui sera affichée en tant que vignette de votre établissement dans les résultats de recherche.") 
                    </p>
                    <br/>
                    @php
                        $medias = null;
                        if(checkModel($establishment) && $establishment->thumbnail()->exists()){
                            $medias = [$establishment->thumbnail()->first()];
                        }
                    @endphp
                    @component('components.file-input', 
                                        [
                                        'name' => 'thumbnail',
                                        'class' => 'form-control',
                                        'multiple' => false,
                                        'medias' => $medias,
                                        'fileType' => 'image',
                                        'showRemove' => 'false',
                                        'directUpload' => 'true',
                                        'fileRefreshOnUpload' => 'true',
                                        'uploadUrl' => '/edit/establishment/'.$establishment->getUuid().'/ajax',
                                        ])
                        @slot('extraData')
                            {'action': 'add_thumbnail'}
                        @endslot
                        @slot('fileerror')
                            alertFileInputError(event, data, msg);
                        @endslot
                        @slot('fileuploaderror')
                            alertFileInputError(event, data, msg);
                        @endslot
                        @slot('filebatchuploaderror')
                            alertFileInputError(event, data, msg);
                        @endslot
                        @slot('filedeleteerror')
                            alertFileInputError(event, data, msg);
                        @endslot
                    @endcomponent
                </div>

                @else
                
                <div class="col-xs-12 incomplete-sheet-disclaimer">
                    <p>
                        L'ajout de vignette sera accessible une fois votre établissement enregistré avec les informations minimales requises.
                    </p>
                </div>
                @endif
            </div>
            <br/>
            <div class="row form-group">
                <div class="col-xs-12">
                    <h5>Page d'accueil</h5>
                </div>
                <div class="col-xs-12">
                    Ajoutez les photos les plus représentatives de votre restaurant (format JPEG, PNG) en haute résolution.<br/>
                    Les photos seront affichées dans la page d'accueil
                </div>
                <br/><br/>
                @php
                    $medias = null;
                @endphp
                @if(checkModel($establishment) && $establishment->homePictures()->exists())
                    @php
                    $medias = $establishment->homePictures()->get();
                    @endphp
                @endif
                <div class="col-xs-12 gallery-item">
                    <div class="gallery-inner">
                        <div class="gallery-header">
                            <h6 class="gallery-title">Images page d'accueil</h6>
                        </div>
                        @component('components.file-input', 
                                            ['name' => 'home_pictures',
                                            'class' => 'form-control',
                                            'medias' => $medias,
                                            'multiple' => true,
                                            'fileType' => 'image'
                                            ])

                        @endcomponent
                    </div>
                </div>
            </div>
            <br/>
            @component('establishment.restaurant.feed.photos-galleries', ['establishment' => $establishment])
            @endcomponent
            <div class="row">
                <div class="col-xs-12">
                    <button type="button" role="button" class="btn btn-md pull-right text-uppercase" onclick="goToNextAccordion(this);">
                        Suivant
                    </button>
                </div>
            </div>
            <script type="text/javascript">
            </script>
        </div> 
    </div>
</div>