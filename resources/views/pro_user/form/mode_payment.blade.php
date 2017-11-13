<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading13">
        <a role="button" data-toggle="collapse" data-parent="#pro_user_form_accordion" href="#collapse4" 
           aria-expanded="true" aria-controls="collapse4">
            <div class="container">
                <h4 class="panel-title">Type de paiement</h4>
            </div>
        </a>
    </div>
    <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
        <div class="panel-body container">
            <div class="row">
                <div class="col-xs-12 form-group text-center">
                    <?php
                    foreach($form_data['payment_methods'] as $id => $paymentMethod){
                        ?>
                        <label class="radio-inline">
                            <?php
                            echo Form::radio('payment_method', $id, false, ['onclick' => "if($(this).val() == ".App\Models\PaymentMethod::METHOD_CB.")"
                                . "{ $('.payment-methods-config').show(); } else { $('.payment-methods-config').hide(); }"]);
                            echo $paymentMethod->getName();
                            ?>
                        </label>   
                        <?php
                    }
                    ?>
                </div>
                <div class="col-xs-12 form-group text-center payment-methods-config">
                    <?php
                    foreach($form_data['methods_config'] as $methodConfig => $paymentMethods){
                        ?>
                        <label class="radio-inline">
                            <?php
                            $methodsList = array();
                            echo Form::radio('method_config', $methodConfig);
                            foreach($paymentMethods as $paymentMethod){
                                $methodsList[] = $paymentMethod->getName();
                            }
                            echo implode(', ', $methodsList);
                            ?>
                        </label>   
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="row" id="payment-warning">
                La facturation à 30 jours est valable uniquement pour les domiciliés bancaires en Suisse, veuillez changez votre domiciliation ou choisir un autre type de paiement.
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