<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading13">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse14" 
           aria-expanded="true" aria-controls="collapse14">
            <div class="container">
                <h4 class="panel-title">Notre histoire</h4>
            </div>
        </a>
    </div>
    <div id="collapse14" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading14">
        <div class="panel-body container">
            @if(checkModel($establishment))
            <div class="row form-group" id='ets-story'>
                <div class="col-xs-12">
                    <p>
                        @lang('Veuillez insérer une histoire brève sur votre établissement') 
                    </p>
                    <br/>
                    <div class="col-xs-12 highlight-container">
                        <div class="col-xs-4 col-sm-3 col-md-2 form-group">
                            {!! Form::label('new_story_year','Année', ['class' => 'col-xs-12 no-gutter']) !!}
                            {!! Form::selectRange('new_story_year', 1900, date('Y'), 2000, ['class' => 'form-control select2']) !!}
                        </div>
                        <div class="col-xs-8 col-sm-9 col-md-10 form-group">
                            {!! Form::label('new_story_title','Titre') !!}
                            {!! Form::text('new_story_title', old('new_story_title'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-xs-12">
                            {!! Form::label('new_story_description', 'Texte (limité à 180 caractères)') !!}
                            <div class="form-group">
                                {!! Form::textarea('new_story_description', old('new_story_description'), ['class' => '', 'style' => 'height: 60px;', 'maxlength' => 180]) !!}  
                            </div>
                        </div>
                        <div class="col-xs-12 form-group">
                            @php
                            $storyMedias = array();
                            $stories = $establishment->stories()->orderBy('year')->get();
                            foreach($stories as $story){
                                $storyMedias[] = $story->media()->first();
                            }
                            @endphp
                            @component('components.file-input', 
                                        ['name' => 'new_story',
                                        'class' => 'form-control',
                                        'medias' => $storyMedias,
                                        'fileType' => ['image', 'text'],
                                        'uploadLabel' => 'Ajouter',
                                        'browseLabel' => 'Ajouter une photo',
                                        'uploadUrl' => '/establishment/'.$establishment->getUuid().'/ajax',
                                        'fileRefreshOnUpload' => 'true',
                                        'showCaption' => 'true',
                                        'showRemove' => 'false',
                                        'existingFilesConfig' => \App\Models\EstablishmentHistory::getMediaConfigForInputFile($stories),
                                        ])
                                @slot('extraData')
                                    function(){
                                        var params = {
                                            'action': 'add_story'
                                        };
                                        $('#ets-story').find('input, select, textarea').each(function(){
                                            params[$(this).attr('name')] = $(this).val();
                                        });
                                        return params;
                                    }
                                @endslot
                                @slot('fileuploaded')
                                    $('#ets-story').find('input, textarea').each(function(){
                                        $(this).val('').change();
                                    });
                                    $('#ets-story .kv-fileinput-caption').hide();
                                @endslot
                                @slot('filebatchselected')
                                    $('#ets-story .kv-fileinput-caption').show();
                                @endslot
                            @endcomponent
                        </div>
                    </div>
                </div>
            </div>
            
            @else
            <div class="row incomplete-sheet-disclaimer">
                <div class="col-xs-12">
                    <p>
                        La saisie de l'histoire de l(établissement sera accessible une fois votre établissement enregistré avec les informations minimales requises.
                    </p>
                </div>
            </div>
            @endif
            
        </div>                    
    </div>
</div>