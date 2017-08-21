<div class="panel panel-default">
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
            <div class="row">
                <div class="col-xs-12 form-group">
                    @php
                        $medias = null;
                    @endphp
                    @if(checkModel($establishment) && $establishment->logo()->exists())
                        <img src="{{ asset($establishment->logo()->first()->getLocalPath()) }}" style="width: 50px;" />
                        @php
                        $medias = [$establishment->logo()->first()];
                        @endphp
                    @endif
                    {{ Form::label('logo','Sélectionnez votre logo') }}
                    @component('components.file-input', 
                                        ['name' => 'logo',
                                        'class' => 'form-control',
                                        'medias' => $medias,
                                        'fileType' => 'image'
                                        ])
                    
                    @endcomponent
                </div>
            </div>
            <br/><br/>
            <div class="row">
                <div class="col-xs-12 form-group">
                    Ajoutez les photos les plus représentatives de votre restaurant (format JPEG, PNG) en haute résolution.<br/>
                    Les photos seront affichées dans la page d\'accueil
                    <br/><br/>
                    @php
                        $medias = null;
                    @endphp
                    @if(checkModel($establishment) && $establishment->homePictures()->exists())
                        @foreach($establishment->homePictures()->get() as $media)
                            <img src="{{ asset($media->getLocalPath()) }}" style="width: 50px;" />
                        @endforeach
                        @php
                        $medias = $establishment->homePictures()->get();
                        @endphp
                    @endif
                    {{ Form::label('home_picture','Images page d\'accueil') }}
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