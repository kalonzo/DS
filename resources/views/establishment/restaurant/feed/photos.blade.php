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
                    $logoQuery = $establishment->logo();
                    if(checkModel($establishment) && $logoQuery->exists()){
                        $logoOriginal = $logoQuery->first();
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