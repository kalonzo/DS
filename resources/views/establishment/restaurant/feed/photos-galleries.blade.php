@if(!isset($reloaded) || !$reloaded)
<div class="row form-group" id="gallery-reloader">
@endif
    <div class="col-xs-12">
        <h5>Galeries</h5>
        @if(checkModel($establishment))
        <div class="col-xs-12 no-gutter">
            <p>
                Donnez un nom de galerie et ajoutez une ou plusieurs photos pour créer une nouvelle galerie.
            </p>
            <br/>
            <div class="col-xs-12 highlight-container subform-collection" data-subform-action="add_gallery" data-subform-reloader="#gallery-reloader">
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
                        @slot('fileuploaded')
                            $('#gallery-reloader input[name=new_gallery_name]').val('');
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
                <div class="col-xs-12">
                    <button type="button" role="button" class="btn btn-md pull-right text-uppercase" onclick="addCollectionItem(this);">
                        Enregistrer
                    </button>
                </div>
            </div>
        </div>
        
        @else
        <div class="row incomplete-sheet-disclaimer">
            <div class="col-xs-12">
                <p>
                    L'ajout de galerie sera accessible une fois votre établissement enregistré avec les informations minimales requises.
                </p>
            </div>
        </div>
        @endif
    </div>
    @if(checkModel($establishment))
        @foreach($establishment->galleries()->orderBy('created_at')->get() as $gallery)
        <div class="col-xs-12 gallery-item">
            <div class="gallery-inner">
                <div class="gallery-header">
                    <h6 class="gallery-title">{{ $gallery->getName() }}</h6>
                    <span class="glyphicon glyphicon-remove gallery-remove" aria-hidden="true" title="Supprimer cette galerie" 
                          onclick="removeCollectionItem(this, '{!! $gallery->getUuid() !!}', 'delete_gallery')" data-subform-reloader="#gallery-reloader"></span>
                </div>
                @component('components.file-input', 
                                    [
                                    'name' => 'gallery['.$gallery->getUuid().']',
                                    'class' => 'form-control',
                                    'multiple' => true,
                                    'medias' => $gallery->medias()->orderBy('position')->get(),
                                    'fileType' => 'image',
                                    'showRemove' => 'false',
                                    'directUpload' => 'true',
                                    'fileRefreshOnUpload' => 'true',
                                    'uploadUrl' => '/edit/establishment/'.$establishment->getUuid().'/ajax',
                                    ])
                    @slot('extraData')
                        {'action': 'add_media_to_gallery', 'id_gallery': '{!!$gallery->getUuid()!!}'}
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
        </div>
        @endforeach
    @endif
@if(!isset($reloaded) || !$reloaded)
</div>
@endif
