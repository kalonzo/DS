<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading5">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse5" 
           aria-expanded="true" aria-controls="collapse5">
            <div class="container">
                <h4 class="panel-title">Spécialités</h4>
            </div>
        </a>
    </div>
    <div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
        <div class="panel-body container">
            <div class="row">
                <section class="col-md-12 container-fluid">
                    <div>
                        <select id="leftValues" size="5" multiple>

                        </select>
                    </div>
                    <div>
                        <input type="button" id="btnLeft" onclick="{
                                    addCookingType();
                                }" value="&lt;&lt;"/>
                        <input type="button" id="btnRight" onclick="{
                                    addCookingType();
                                }" value="&gt;&gt;"/>
                    </div>
                    <div>
                        {!! Form::select('foodSpecialitieIdsByName[]', $form_data['food_specialities'], 
                        null, array('multiple' => true)) !!}
                        <div>
                            <input type="text" id="txtRight" />
                        </div>
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