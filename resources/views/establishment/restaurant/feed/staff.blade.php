<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading13">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse13" 
           aria-expanded="true" aria-controls="collapse7">
            <div class="container">
                <h4 class="panel-title">Notre équipe</h4>
            </div>
        </a>
    </div>
    <div id="collapse13" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading13">
        <div class="panel-body container">
            @if(checkModel($establishment))
            <div class="row form-group" id='ets-staff'>
                <div class="col-xs-12">
                    <p>
                        @lang('Veuillez télécharger les informations de votre équipe') 
                    </p>
                    <br/>
                    <div class="col-xs-12 highlight-container">
                        <div class="col-xs-12 col-sm-6 form-group">
                            {!! Form::label('new_employee_lastname','Nom') !!}
                            {!! Form::text('new_employee_lastname', old('new_employee_lastname'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-xs-12 col-sm-6 form-group">
                            {!! Form::label('new_employee_firstname','Prénom') !!}
                            {!! Form::text('new_employee_firstname', old('new_employee_firstname'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-xs-12 col-sm-6 form-group">
                            @foreach($form_data['job_types'] as $jobType => $label)
                                <div class="radio">
                                    <label>
                                        {!! Form::radio('job_type', $jobType) !!}
                                        {{ $label }}
                                    </label>
                                </div>
                            @endforeach
                        </div>    
                        <div class="col-xs-12 col-sm-6 form-group">
                            {!! Form::label('new_employee_position','Titre') !!}
                            {!! Form::text('new_employee_position', old('new_employee_position'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-xs-12 form-group">
                            @php
                            $employeeMedias = array();
                            $employees = $establishment->employees()->orderBy('created_at')->get();
                            foreach($employees as $employee){
                                $employeeMedias[] = $employee->media()->first();
                            }
                            @endphp
                            @component('components.file-input', 
                                        ['name' => 'new_employee',
                                        'class' => 'form-control',
                                        'medias' => $employeeMedias,
                                        'fileType' => ['image', 'text'],
                                        'uploadLabel' => 'Ajouter cet employé',
                                        'browseLabel' => 'Ajouter une photo',
                                        'uploadUrl' => '/edit/establishment/'.$establishment->getUuid().'/ajax',
                                        'fileRefreshOnUpload' => 'true',
                                        'showCaption' => 'true',
                                        'showRemove' => 'false',
                                        'existingFilesConfig' => \App\Models\Employee::getMediaConfigForInputFile($employees),
                                        ])
                                @slot('extraData')
                                    function(){
                                        var params = {
                                            'action': 'add_employee'
                                        };
                                        $('#ets-staff').find('input, select').each(function(){
                                            params[$(this).attr('name')] = $(this).val();
                                        });
                                        return params;
                                    }
                                @endslot
                                @slot('fileuploaded')
                                    $('#ets-staff').find('input[type=text]').each(function(){
                                        $(this).val('');
                                    });
                                    $('#ets-staff .kv-fileinput-caption').hide();
                                @endslot
                                @slot('filebatchselected')
                                    $('#ets-staff .kv-fileinput-caption').show();
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
                        L'ajout des membres d'équipe sera accessible une fois votre établissement enregistré avec les informations minimales requises.
                    </p>
                </div>
            </div>
            @endif
            
            <div class="row form-group">
                <div class="col-xs-12">
                    <button type="button" role="button" class="btn btn-md pull-right text-uppercase" onclick="goToNextAccordion(this);">
                        Suivant
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>