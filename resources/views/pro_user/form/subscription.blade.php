<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading13">
        <a role="button" data-toggle="collapse" data-parent="#pro_user_form_accordion" href="#collapse3" 
           aria-expanded="true" aria-controls="collapse3">
            <div class="container">
                <h4 class="panel-title">Sélectionner votre abonnement DinerScope</h4>
            </div>
        </a>
    </div>
    <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
        <div class="panel-body container">
            <!--
            <div class="row form-group">
                <div class="col-xs-12">
                    <h5>Durée d'abonnement</h5>
                    <div class="col-xs-12 no-gutter duration-tiles">
                    </div>
                </div>
            </div>
            -->
            <div class="row subscription-tiles">
                <div class="col-xs-12">
                    <h5>Formule</h5>
                    <div class="col-xs-12 no-gutter">
                        @foreach($form_data['subscriptions'] as $subscription)
                            @php
                            $disabled = false;
                            $selected = false;
                            if(isset($form_values['id_subscription']) && $form_values['id_subscription'] == $idSubscription){
                                $selected = true;
                            }
                            @endphp
                            <div class="buyable-tile col-xs-4 col-md-3 @if($loop->index === 0) col-md-offset-0_5 @else col-md-offset-1 @endif
                                 @if($disabled) disabled @endif @if($selected) selected @endif">
                                <div class="buyable-header div-table" style="background-color: {{ $subscription->getColor() }};">
                                    <div class="div-cell">
                                        {{ $subscription->getDesignation() }}
                                    </div>
                                </div>
                                <div class="buyable-body" style="border-color: {{ $subscription->getColor() }};">
                                    <div class="col-xs-12">
                                        <h3>{{ formatPrice($subscription->getNetPrice(), 'CHF') }}</h3>
                                    </div>
                                     <div class="tile-footer">
                                        <button type="button" class="btn btn-primary btn-select-buyable"
                                                style="background-color: {{ $subscription->getColor() }};">Sélectionner</button>
                                        {!! Form::radio('id_subscription', $subscription->getUuid(), $selected, ['disabled' => $disabled]) !!}
                                     </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row extra-tiles">
                <div class="col-xs-12">
                    <h5>Services complémentaires</h5>
                    <div class="col-xs-12 no-gutter">
                        @foreach($form_data['extra_services'] as $extraService)
                            @php
                            $disabled = false;
                            @endphp
                            <div class="buyable-tile col-xs-4 col-xs-offset-4 col-md-3 col-md-offset-4_5
                                 @if($disabled) disabled @endif @if($selected) selected @endif">
                                <div class="buyable-header div-table" style="background-color: {{ $extraService->getColor() }};">
                                    <div class="div-cell">
                                        {{ $extraService->getDesignation() }}
                                    </div>
                                </div>
                                <div class="buyable-body" style="border-color: {{ $extraService->getColor() }};">
                                    <div class="col-xs-12">
                                        <h3>{{ formatPrice($extraService->getNetPrice(), 'CHF') }}</h3>
                                    </div>
                                     <div class="tile-footer">
                                        <button type="button" class="btn btn-primary btn-select-buyable"
                                                style="background-color: {{ $extraService->getColor() }};">Sélectionner</button>
                                        {!! Form::checkbox('id_extra[]', $extraService->getUuid(), $selected, ['disabled' => $disabled]) !!}
                                     </div>
                                </div>
                            </div>
                        @endforeach
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
            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function(event) { 
                    $('body').on('click', '.subscription-tiles button.btn-select-buyable', function(){
                        $('.subscription-tiles .buyable-tile.selected').find('input[name=id_subscription]').removeAttr('checked');
                        $(this).next('input[name=id_subscription]').attr('checked', 'checked');
                        
                        $('.subscription-tiles .buyable-tile.selected').removeClass('selected');
                        var tile = $(this).parentsInclude('.buyable-tile');
                        if(checkExist(tile)){
                            $('.subscription-tiles .buyable-tile').addClass('not-selected');
                            $(tile).removeClass('not-selected').addClass('selected');
                        }
                    });
                    $('body').on('click', '.extra-tiles button.btn-select-buyable', function(){
                        var tile = $(this).parentsInclude('.buyable-tile');
                        if(!$(tile).hasClass('selected')){
                            $(this).next('input[name=id_extra]').attr('checked', 'checked');
                            $(tile).removeClass('not-selected').addClass('selected');
                        } else {
                            $(this).next('input[name=id_extra]').removeAttr('checked');
                            $(tile).addClass('not-selected').removeClass('selected');
                        }
                    });
                });
            </script>
        </div>                    
    </div>
</div>