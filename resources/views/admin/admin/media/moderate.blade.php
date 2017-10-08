<div class="row form-group" id='media-moderation'>
    @if(checkModel($establishment))
    <div class="form-horizontal">
        <div class="col-xs-12">
            <label class="col-sm-2"><strong>Type d'établissement</strong></label>
            <div class="col-sm-10">
              {{ $establishment->getBusinessTypeLabel() }}
            </div>
        </div>
        <div class="col-xs-12">
            <label class="col-sm-2"><strong>Etablissement</strong></label>
            <div class="col-sm-10">
              {{ $establishment->getName() }}
            </div>
        </div>
        <?php
        $address = $establishment->address()->first();
        if(checkModel($address)){
            ?>
            <div class="col-xs-12">
                <label class="col-sm-2"><strong>Adresse</strong></label>
                <div class="col-sm-10">
                  {{ $address->getDisplayable() }}
                </div>
            </div>
            <?php
        }
        ?>   
        <div class="col-xs-12">
            <label class="col-sm-2"><strong>Type de média</strong></label>
            <div class="col-sm-10">
              {{ $new_media->getTypeLabel() }}
            </div>
        </div>
        <div class="col-xs-12">
            <label class="col-sm-2"><strong>Nom du média</strong></label>
            <div class="col-sm-10">
              {{ $new_media->getFilename() }}
            </div>
        </div>
        <div class="col-xs-12">
            <label class="col-sm-2"><strong>Taille</strong></label>
            <div class="col-sm-10">
              {{ $new_media->getSize() / 1000 }} Ko
            </div>
        </div>
        <div class="col-xs-12">
            <label class="col-sm-2"><strong>Extension</strong></label>
            <div class="col-sm-10">
              {{ $new_media->getExtension() }}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 bg-primary">
                <label class="col-sm-2"><strong>Usage</strong></label>
                <div class="col-sm-10">
                  {{ $new_media->getTypeUseLabel() }}
                </div>
            </div>
        </div>
    </div>
    <br class="cleaner"/>
    @endif
    <div class="col-xs-8">
        <?php
        $mediaOriginal = null;
        if(checkModel($new_media) && checkModelId($new_media->getIdOriginalMedia())){
            $mediaOriginal = $new_media->mediaOriginal()->first();
        }
        if(checkModel($mediaOriginal)){
            ?>
            <div class="col-xs-6">
                <h6>Média initial</h6>
                @component('components.file-input', 
                            ['name' => 'media_original',
                            'class' => 'form-control',
                            'medias' => $mediaOriginal,
                            'showRemove' => false,
                            'showBrowse' => false,
                            'existingFilesConfig' => getMediaConfigForInputFile($mediaOriginal, true, false)
                            ])

                @endcomponent
            </div>
            <div class="col-xs-6">
                <h6>Média à valider</h6>
            <?php
        }
            ?>
            @component('components.file-input', 
                                ['name' => 'media',
                                'class' => 'form-control',
                                'medias' => $new_media,
                                'showRemove' => false,
                                'showBrowse' => false,
                                'existingFilesConfig' => getMediaConfigForInputFile($new_media, true, false)
                                ])

            @endcomponent
            <?php
            if(checkModel($mediaOriginal)){
                ?>
                </div>
                <?php
            }
            ?>
    </div>
    <div class="col-xs-4">
        <a href="/admin/media/validate/{!! $new_media->getUuid() !!}" class="btn btn-success col-xs-12" aria-label="Valider">
            <span class="glyphicon glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
            Valider le fichier
        </a>
        <br/><br/>
        <a href="/admin/media/deny/{!! $new_media->getUuid() !!}" class="btn btn-danger col-xs-12" aria-label="Refuser">
            <span class="glyphicon glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
            Refuser le fichier
        </a>
    </div>
</div>