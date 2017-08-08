<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading7">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse7" 
           aria-expanded="true" aria-controls="collapse7">
            <div class="container">
                <h4 class="panel-title">Services</h4>
            </div>
        </a>
    </div>
    <div id="collapse7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading7">
        <div class="panel-body container">
            <div class="row">
                <section class="col-md-12 container-fluid">
                    <div>
                        {!! Form::select('services[]', $form_data['services'], null, array('multiple' => true,'class' => 
                        'multiselect-dual')) !!}
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