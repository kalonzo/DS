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
                @foreach($form_data['business_types'] as $businessTypeId => $businessTypeData)
                    <?php
                    $disabled = true;
                    $selected = false;
                    if(isset($form_values['business_type']) && $form_values['business_type'] == $businessTypeId){
                        $selected = true;
                    }
                    if(isset($businessTypeData['enabled']) && $businessTypeData['enabled']){
                        $disabled = false;
                    }
                    ?>
                    <div class="business-type-tile col-xs-6 col-sm-4 col-md-2 @if($disabled) disabled @endif @if($selected) selected @endif"
                         style="@if(isset($businessTypeData['url_media'])) background-image: url('{{ $businessTypeData['url_media'] }}');@endif">
                        <img src="/img/square-pattern.png" alt="square pattern" class="square-pattern"/>
                        <div class='business-label'>{{ $businessTypeData['label'] }}</div>
                        @if(!$disabled)
                        {!! Form::radio('business_type', $businessTypeId, $selected, ['disabled' => $disabled]) !!}
                        @endif
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
                    $('body').on('click', '.business-type-tile:not(.disabled)', function(){
                        $('.business-type-tile.selected').find('input[name=business_type]').removeAttr('checked');
                        $(this).find('input[name=business_type]').attr('checked', 'checked');
                        
                        $('.business-type-tile.selected').removeClass('selected');
                        $(this).addClass('selected');
                    });
                });
            </script>
        </div>                    
    </div>
</div>