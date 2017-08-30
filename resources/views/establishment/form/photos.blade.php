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
            <div class="row form-group">
                <div class="col-xs-12">
                    @php
                        $medias = null;
                    @endphp
                    @if(checkModel($establishment) && $establishment->logo()->exists())
                        @php
                        $medias = [$establishment->logo()->first()];
                        @endphp
                    @endif
                    <h5>Logo</h5>
                    @component('components.file-input', 
                                        ['name' => 'logo',
                                        'class' => 'form-control',
                                        'medias' => $medias,
                                        'fileType' => 'image'
                                        ])
                    
                    @endcomponent
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
            @if(checkModel($establishment))
                @component('establishment.form.photos-galleries', ['establishment' => $establishment])
                @endcomponent
            @endif
            <div class="row">
                <div class="col-xs-12">
                    <button type="button" role="button" class="btn btn-md pull-right text-uppercase" onclick="goToNextAccordion(this);">
                        Suivant
                    </button>
                </div>
            </div>
            <script type="text/javascript">
                function addGallery(triggerButton){
                    var $form = $(triggerButton).parentsInclude('form');
                    var $container = $(triggerButton).parentsInclude('.highlight-container');
                    var $reloader = $($container.attr('data-subform-reloader'));
                    
                    if(checkExist($reloader)){
                        var fd = new FormData();
                        $container.find('input').each(function(){
                            if($(this).attr('type') === 'file'){
                                var fileInputName = $(this).attr('name');
                                $.each($(this)[0].files, function(i, file) {
                                    fd.append(fileInputName, file);
                                });
                            } else {
                                fd.append($(this).attr('name'), $(this).val());
                            }
                        });
                        fd.append('action', $container.attr('data-subform-action'));
                        $.ajax({
                            url: $form.attr('action') + "/ajax",
                            method: "POST",
                            data: fd,
                            contentType: false,
                            processData: false,
                            dataType: "json",
                            success: function (data) {
                                if(data.success){
                                    $reloader.empty().append(data.content);
                                }
                            },
                            error: function (data) {
                                console.log(data);
                            }
                        });
                    }
                }
                
                function removeGallery(triggerButton, idGallery){
                    var $form = $(triggerButton).parentsInclude('form');
                    var $reloader = $($(triggerButton).attr('data-subform-reloader'));
                    
                    if(checkExist($reloader)){
                        $.ajax({
                            url: $form.attr('action') + "/ajax",
                            method: "POST",
                            data: {
                                action: 'delete_gallery', 
                                id_gallery: idGallery, 
                            },
                            success: function (data) {
                                if(data.success){
                                    $reloader.empty().append(data.content);
                                }
                            },
                            error: function (data) {
                                console.log(data);
                            }
                        });
                    }
                }
            </script>
        </div> 
    </div>
</div>