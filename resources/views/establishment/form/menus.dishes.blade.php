<div class="row form-group">
    <div class="col-xs-12">
        <h5>Assiettes</h5>
        <div class="col-xs-12 no-gutter">
            <p>
                @lang('Veuillez télécharger vos assiettes, max 12 items.') 
            </p>
            <br/>
            <div class="col-xs-12 highlight-container">
                <div class="col-xs-12 form-group">
                    {!! Form::label('new_menu_name','Nom de votre menu') !!}
                    {!! Form::text('new_menu_name', old('new_menu_name'), ['class' => 'form-control']) !!}
                </div>
                <div class="col-xs-12 form-group">
                    @php
                    $menusMedias = array();
                    foreach($establishment->menus()->orderBy('created_at')->get() as $menu){
                    $menusMedias[] = $menu->media()->first();
                    }
                    @endphp
                    @component('components.file-input', 
                    ['name' => 'new_menu',
                    'class' => 'form-control',
                    'medias' => $menusMedias,
                    'filetype' => ['image', 'text'],
                    'uploadLabel' => 'Ajouter votre menu',
                    'browseLabel' => 'Choisir un fichier',
                    'uploadUrl' => '/establishment/'.$establishment->getUuid().'/ajax',
                    'fileRefreshOnUpload' => 'true',
                    'showCaption' => 'true',
                    'showRemove' => 'false',
                    ])
                    @slot('extraData')
                    function(){
                    return {'action': 'add_menu', 'menu_name': $('#ets-menus input[name=new_menu_name]').val() }
                    }
                    @endslot
                    @slot('fileuploaded')
                    $('#ets-menus input[name=new_menu_name]').val('');
                    $('#ets-menus .kv-fileinput-caption').hide();
                    @endslot
                    @slot('filebatchselected')
                    $('#ets-menus .kv-fileinput-caption').show();
                    @endslot
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
</div>