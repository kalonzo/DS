@if(isset($establishment) && checkModel($establishment))
<div class="panel panel-default" id='ets-menus'>
    <div class="panel-heading" role="tab" id="heading11">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse11" 
           aria-expanded="true" aria-controls="collapse11">
            <div class="container">
                <h4 class="panel-title">Menus</h4>
            </div>
        </a>
    </div>
    <div id="collapse11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading11">
        <div class="panel-body container">
            @if(checkModel($establishment))
            <div class="row form-group">
                <div class="col-xs-12">
                    <h5>Menus</h5>
                    <div class="col-xs-12 no-gutter">
                        <p>
                            Veuillez insérer votre/vos menu(s). Choisissez votre menu en PDF, Word ou JPEG depuis votre ordinateur.
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
                                            'fileExtensions' => ['doc', 'docx', 'pdf', 'jpg', 'png'],
                                            'uploadLabel' => 'Ajouter votre menu',
                                            'browseLabel' => 'Choisir un fichier',
                                            'uploadUrl' => '/edit/establishment/'.$establishment->getUuid().'/ajax',
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
                    </div>
                </div>
            </div>
            @endif
            <div class="row form-group">
                <div class="col-xs-12">
                    <h5>Prix moyen de votre restaurant</h5>
                    <div class="col-xs-12 highlight-container" id='ets-avg-prices'>
                        <p>
                            @lang('Prix moyen à la carte hors boisson. En aucun cas il ne peut être considéré comme contractuel') 
                        </p>
                        <div class="col-xs-12 text-center form-inline">
                            {!! Form::text('average_price_min', old('average_price_min'), ['class' => 'form-control']) !!}
                            <span>&nbsp;-&nbsp;</span>
                            {!! Form::text('average_price_max', old('average_price_max'), ['class' => 'form-control']) !!}
                            {!! Form::select("id_currency", $form_data['currency_ids'], $form_values['id_currency'], ['class' => 'form-control select2']) !!}
                        </div>
                    </div>
                </div>
            </div>
            @if(checkModel($establishment))
            <div class="row form-group" id='ets-menu-dishes'>
                <div class="col-xs-12">
                    <h5>Assiettes</h5>
                    <div class="col-xs-12 no-gutter">
                        <p>
                            @lang('Veuillez télécharger vos assiettes, max 12 items.') 
                        </p>
                        <br/>
                        <div class="col-xs-12 highlight-container">
                            <div class="col-xs-12 form-group">
                                {!! Form::label('new_dish_name','Nom de l\'assiette') !!}
                                {!! Form::text('new_dish_name', old('new_dish_name'), ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-xs-12 form-group">
                                {!! Form::label('new_dish_description','Description de l\'assiette') !!}
                                {!! Form::text('new_dish_description', old('new_dish_description'), ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-xs-12 ">
                                {!! Form::label('new_dish_price','Prix') !!}
                                <div class="form-group form-inline">
                                    {!! Form::text('new_dish_price', old('new_dish_price'), ['class' => 'form-control']) !!}
                                    <span>&nbsp;.&nbsp;</span>
                                    {!! Form::text('new_dish_price_cents', old('new_dish_price_cents'), ['class' => 'form-control']) !!}
                                    {!! Form::select("new_dish_price_currency", $form_data['currency_ids'], $form_values['id_currency'], ['class' => 'form-control select2']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 form-group">
                                @php
                                $dishesMedias = array();
                                $dishes = $establishment->dishes()->orderBy('created_at')->get();
                                foreach($dishes as $dish){
                                    $dishesMedias[] = $dish->media()->first();
                                }
                                @endphp
                                @component('components.file-input', 
                                            ['name' => 'new_dish',
                                            'class' => 'form-control',
                                            'medias' => $dishesMedias,
                                            'fileType' => ['image'],
                                            'uploadLabel' => 'Ajouter votre assiette',
                                            'browseLabel' => 'Choisir un fichier',
                                            'uploadUrl' => '/edit/establishment/'.$establishment->getUuid().'/ajax',
                                            'fileRefreshOnUpload' => 'true',
                                            'showCaption' => 'true',
                                            'showRemove' => 'false',
                                            'existingFilesConfig' => \App\Models\Dish::getMediaConfigForInputFile($dishes),
                                            ])
                                    @slot('extraData')
                                        function(){
                                            var params = {
                                                'action': 'add_dish'
                                            };
                                            $('#ets-menu-dishes').find('input, select').each(function(){
                                                params[$(this).attr('name')] = $(this).val();
                                            });
                                            return params;
                                        }
                                    @endslot
                                    @slot('fileuploaded')
                                        $('#ets-menu-dishes').find('input').each(function(){
                                            $(this).val('');
                                        });
                                        $('#ets-menu-dishes .kv-fileinput-caption').hide();
                                    @endslot
                                    @slot('filebatchselected')
                                        $('#ets-menu-dishes .kv-fileinput-caption').show();
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
                    </div>
                </div>
            </div>
            @endif
            
            @if(checkModel($establishment))
            <div class="row form-group" id="ets-daily-menu">
                <div class="col-xs-12">
                    <h5>Menu du jour</h5>
                    <div class="col-xs-12 no-gutter highlight-container">
                        <div class="col-xs-12 form-group">
                            @php
                            $dailyMenuMedia = null;
                            $dailyMenu = $establishment->dailyMenu()->first();
                            if(checkModel($dailyMenu)){
                                $dailyMenuMedia = $dailyMenu->media()->first();
                            }
                            @endphp
                            @component('components.file-input', 
                                        ['name' => 'new_daily_menu',
                                        'class' => 'form-control',
                                        'medias' => $dailyMenuMedia,
                                        'fileExtensions' => ['doc', 'docx', 'pdf', 'jpg', 'png'],
                                        'uploadLabel' => 'Ajouter votre menu',
                                        'browseLabel' => 'Choisir un fichier',
                                        'uploadUrl' => '/edit/establishment/'.$establishment->getUuid().'/ajax',
                                        'fileRefreshOnUpload' => 'true',
                                        'showCaption' => 'true',
                                        'showRemove' => 'false',
                                ])
                                @slot('extraData')
                                    function(){
                                        return {'action': 'add_daily_menu'}
                                    }
                                @endslot
                                @slot('fileuploaded')
                                    $('#ets-daily-menu .kv-fileinput-caption').hide();
                                @endslot
                                @slot('filebatchselected')
                                    $('#ets-daily-menu .kv-fileinput-caption').show();
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
@endif