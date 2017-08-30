@if(!isset($reloaded) || !$reloaded)
<div class="row form-group" id="gallery-reloader">
@endif
    <div class="col-xs-12">
        <h5>Galeries</h5>
        <div class="col-xs-12 no-gutter">
            <p>
                Donnez un nom de galerie et ajoutez une ou plusieurs photos pour créer une nouvelle galerie.
            </p>
            <br/>
            <div class="col-xs-12 highlight-container" data-subform-action="add_gallery" data-subform-reloader="#gallery-reloader">
                <div class="col-xs-12 form-group">
                    {!! Form::label('new_gallery_name','Nom de la galerie') !!}
                    {!! Form::text('new_gallery_name', old('new_gallery_name'), ['class' => 'form-control']) !!}
                </div>
                <div class="col-xs-12 form-group">
                    @component('components.file-input', 
                                ['name' => 'new_gallery',
                                'class' => 'form-control',
                                'multiple' => true,
                                'fileType' => 'image',
                                ])
                    @endcomponent
                </div>
                <div class="col-xs-12">
                    <button type="button" role="button" class="btn btn-md pull-right text-uppercase" onclick="addGallery(this);">
                        Enregistrer
                    </button>
                </div>
            </div>
        </div>
    </div>
    @foreach($establishment->galleries()->orderBy('created_at')->get() as $gallery)
    <div class="col-xs-12 gallery-item">
        <div class="gallery-inner">
            <div class="gallery-header">
                <h6 class="gallery-title">{{ $gallery->getName() }}</h6>
                <span class="glyphicon glyphicon-remove gallery-remove" aria-hidden="true" title="Supprimer cette galerie" 
                      onclick="removeGallery(this, '{!! $gallery->getUuid() !!}')" data-subform-reloader="#gallery-reloader"></span>
            </div>
            @component('components.file-input', 
                                [
                                'name' => 'gallery['.$gallery->getUuid().']',
                                'class' => 'form-control',
                                'multiple' => true,
                                'medias' => $gallery->medias()->orderBy('created_at')->get(),
                                'fileType' => 'image',
                                'showRemove' => 'false',
                                'directUpload' => 'true',
                                'uploadUrl' => '/establishment/'.$establishment->getUuid().'/ajax',
                                ])
                @slot('extraData')
                    {'action': 'add_media_to_gallery', 'id_gallery': '{!!$gallery->getUuid()!!}'}
                @endslot
            @endcomponent
        </div>
    </div>
    @endforeach
@if(!isset($reloaded) || !$reloaded)
</div>
@endif