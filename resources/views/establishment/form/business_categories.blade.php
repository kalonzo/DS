<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading13">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse2" 
           aria-expanded="true" aria-controls="collapse2">
            <div class="container">
                <h4 class="panel-title">Choisir votre "Business" Catégorie</h4>
            </div>
        </a>
    </div>
    <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
        <div class="panel-body container">
            <div class="row">
                <section class="col-md-12 container-fluid">
                    <div>
                        @foreach($form_data['business_tools'] as $businessTool => $label)
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    {!! Form::label($label) !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>   
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