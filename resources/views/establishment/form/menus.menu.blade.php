@if(!isset($reloaded) || !$reloaded)
<div class="row form-group" id="menu-reloader">
@endif
    <div class="col-xs-12">
        <h5>Menus</h5>
        <div class="col-xs-12 no-gutter">
            <p>
                Veuillez insérer votre/vos menu(s). Choisissez votre menu en PDF, Word ou JPEG depuis votre ordinateur.
            </p>
            <br/>
            <div class="col-xs-12 highlight-container" data-subform-action="add_menu" data-subform-reloader="#menu-reloader">
                <div class="col-xs-12 form-group">
                    {!! Form::label('new_menu_name','Nom de votre menu') !!}
                    {!! Form::text('new_menu_name', old('new_menu_name'), ['class' => 'form-control']) !!}
                </div>
                <div class="col-xs-12 form-group">
                    @component('components.file-input', 
                                ['name' => 'new_menu',
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
    @foreach($establishment->galleries()->orderBy('created_at')->get() as $menu)
    <div class="col-xs-12 gallery-item">
        <div class="gallery-inner">
            <div class="gallery-header">
                <h6 class="gallery-title">{{ $menu->getName() }}</h6>
                <span class="glyphicon glyphicon-remove gallery-remove" aria-hidden="true" title="Supprimer ce menu" 
                      onclick="removeGallery(this, '{!! $menu->getUuid() !!}')" data-subform-reloader="#menu-reloader"></span>
            </div>
            @component('components.file-input', 
                                [
                                'name' => 'menu['.$menu->getUuid().']',
                                'class' => 'form-control',
                                'multiple' => true,
                                'medias' => $menu->medias()->orderBy('created_at')->get(),
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