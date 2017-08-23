<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading13">
        <a role="button" data-toggle="collapse" data-parent="#pro_user_form_accordion" href="#collapse2" 
           aria-expanded="true" aria-controls="collapse2">
            <div class="container">
                <h4 class="panel-title">Choisir votre "Business" Catégorie</h4>
            </div>
        </a>
    </div>
    <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
        <div class="panel-body container">
            <div class="row business-type-tiles">
                @foreach($form_data['business_types'] as $businessType => $label)
                    @php
                    $disabled = false;
                    $selected = false;
                    if(isset($form_values['business_type']) && $form_values['business_type'] == $businessType){
                        $selected = true;
                    }
                    @endphp
                    <div class="business-type-tile @if($disabled) disabled @endif @if($selected) selected @endif">
                        {{ $label }}
                        <br/>
                        {!! Form::radio('business_type', $businessType, $selected, ['disabled' => $disabled]) !!}
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="button" role="button" class="btn btn-md pull-right text-uppercase" onclick="goToNextAccordion(this);">
                        Suivant
                    </button>
                </div>
            </div>
            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function(event) { 
                    $('body').on('change', '[name=business_type]', function(){
                        var tile = $(this).parentsInclude('.business-type-tile');
                        var selected = $(this).is(':checked');
                        if(checkExist(tile)){
                            if(selected){
                                $(tile).addClass('selected');
                            } else {
                                $(tile).removeClass('selected');
                            }
                        }
                    });
                });
            </script>
        </div>                    
    </div>
</div>