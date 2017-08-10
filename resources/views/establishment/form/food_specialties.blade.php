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
                <div class="col-xs-12">
                    * Vous pouvez enregistrer jusqu'à 5 spécialités
                    <br/>
                    <div class="form-group {{ $errors->has('id_country') ? 'has-error' : '' }}">
                        @php
                        $selectedValues = old('business_categories[2][]');
                        if(isset($form_values['business_categories'])){
                            $selectedValues = $form_values['business_categories'];
                        }
                        @endphp
                        
                        {!! Form::select('businessCategories[2][]', $form_data['food_specialties'], $selectedValues, 
                                   ['multiple' => true, 'class' => 'form-control select2', 'id' => 'foodSpecialties',
                                   'style' => 'width: 100%;',
                                   'data-tags' => 'true', 'data-maximumSelectionLength' => 5]) !!}
                    </div>
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