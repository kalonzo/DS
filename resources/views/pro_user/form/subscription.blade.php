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
            <div class="row subscription-tiles">
                @foreach($form_data['subscriptions'] as $subscription)
                    @php
                    $disabled = false;
                    $selected = false;
                    if(isset($form_values['id_subscription']) && $form_values['id_subscription'] == $idSubscription){
                        $selected = true;
                    }
                    @endphp
                    <div class="subscription-tile col-xs-6 col-sm-3 @if($disabled) disabled @endif @if($selected) selected @endif">
                        <div class="subscription-header div-table" style="background-color: {{ $subscription->getColor() }};">
                            <div class="div-cell">
                                {{ formatPrice($subscription->getNetPrice(), 'CHF') }}
                            </div>
                        </div>
                        <div class="subscription-body" style="border-color: {{ $subscription->getColor() }};">
                            <div class="col-xs-12">
                                <h3>{{ $subscription->getDesignation() }}</h3>
                            </div>
                             <div class="tile-footer">
                                <button type="button" class="btn btn-primary btn-select-subscription"
                                        style="background-color: {{ $subscription->getColor() }};">Sélectionner</button>
                                {!! Form::radio('id_subscription', $subscription->getUuid(), $selected, ['disabled' => $disabled]) !!}
                             </div>
                        </div>
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
                    $('body').on('click', 'button.btn-select-subscription', function(){
                        $(this).next('input[name=id_subscription]').attr('checked', 'checked');
                        
                        $('.subscription-tile.selected').removeClass('selected');
                        var tile = $(this).parentsInclude('.subscription-tile');
                        if(checkExist(tile)){
                            $(tile).addClass('selected');
                        }
                    });
                });
            </script>
        </div>                    
    </div>
</div>