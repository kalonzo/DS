@extends('layouts.front') 

@section('css_imports')
<link href="/css/establishment.css" rel="stylesheet">
<link href="/css/loading-spinner.css" rel="stylesheet">
@endsection

@section('content')

<div id="map"> </div>
@if(checkModel($establishment))
{!! Form::model($establishment, ['id'=>'feed-establishment', 'url' => '/establishment/register/'.$establishment->getUuid(), 'method' => 'PUT', 'files' => true]) !!}
@else
{!! Form::open(['id'=>'feed-establishment', 'url'=>'/establishment/register/', 'method' => 'put', 'files' => true]) !!}
@endif
<div class="container-fluid no-gutter">
    <div id="ets-heading" class="row no-gutter no-margin"> 

    </div>        
    @if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    @if(count($errors))
    <div class="alert alert-danger">
        <strong>Erreur!</strong> Les informations saisies ne sont pas correctes.
        <br/>
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="panel-group form-accordion" id="establishment_form_accordion" role="tablist" aria-multiselectable="true">  
        @component('establishment.form.credentials', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
        @endcomponent   

        @component('establishment.form.business_categories', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
        @endcomponent   

        @component('establishment.form.subscription', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
        @endcomponent   

        @component('establishment.form.mode_payment', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
        @endcomponent   

        @component('establishment.form.info_bill', ['establishment' => $establishment, 'form_data' => $form_data, 'form_values' => $form_values])
        @endcomponent   
    </div>
    <div class="row no-margin text-center">
        {!! Form::submit('Valider', array('id' => 'validToPayment', 'class'=>'btn')) !!}
    </div>
</div>
{!! form::close() !!}

<!-- Modal -->
<div id="checkoutModal" class="modal fade" role="dialog">
   <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Checkout</h4>
            </div>
            <div class="modal-body">
                <div class="row" id="payment-form">
                    @component('components.loading_spinner')
                    @endcomponent   
                </div>
                <div class="row" id="iframe-ext-footer" style="display: none;">
                    <ul id="payment-errors"></ul>
                    <button type="button" id="pay-button" class="btn btn-default">Valider le paiement</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
   </div>
</div>

@endsection

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) { 
        $('body').on('click', '#validToPayment', function(){
            $('#checkoutModal').modal('show');
            
            var ajaxParams = {};
//            ajaxParams[filterName] = value;

            $.ajax({
                url: '/start_checkout',
                data: ajaxParams,
                method: 'POST'
            })
            .done(function( data ) {
                if(data.success){
                    if(data.url){
                        var iframeScriptUrl = data.url;
                        var counter = 0;
                        var myLoop = null;
                        
                        loadPaymentIframe = function(){
                            counter += 200;
                            if(typeof window.IframeCheckoutHandler != 'undefined'){
                                clearInterval(myLoop);
                                // Set here the id of the payment method configuration the customer chose.
                                var paymentMethodConfigurationId = 616;

                                // Set here the id of the HTML element the payment iframe should be appended to.
                                var containerId = 'payment-form';

                                var handler = window.IframeCheckoutHandler(paymentMethodConfigurationId);

                                handler.setValidationCallback(
                                    function (validationResult) {
                                        // Reset payment errors
                                        $('#payment-errors').html('');

                                        if (validationResult.success) {
                                            // Create the order within the shop and eventually update the transaction.
                                            $.ajax('/create_order', {
                                                method: 'POST',
                                                success: function () {
                                                    handler.submit();
                                                },
                                                error: function (jqXHR, textStatus, errorThrown) {
                                                    console.log("Error processing order creation : " + textStatus);
                                                    console.log(errorThrown);
                                                },
                                            });
                                        } else {
                                            // Display errors to customer
                                            $.each(validationResult.errors, function (index, errorMessage) {
                                                $('#payment-errors').append('<li>' + errorMessage + '</li>');
                                            });
                                        }
                                    }
                                );

                                //Set the optional initialize callback
                                handler.setInitializeCallback(function () {
                                    //Execute initialize code
                                    $('#payment-form .loading-spinner').remove();
                                    $('#iframe-ext-footer').show();
                                });

                                //Set the optional height change callback
                                handler.setHeightChangeCallback(function (height) {
                                    //Execute code
                                });

                                handler.create(containerId);

                                $('#pay-button').on('click', function(){
                                    handler.validate();
                                });
                            } else if(counter > 2000){
                                clearInterval(myLoop);
                                $('#payment-form .loading-spinner').remove();
                                $('#payment-form').html("Une erreur est survenue avec le service de paiement.");
                            }
                        }
                        $(document).ready(function(){
                            myLoop = setInterval(loadPaymentIframe, 200);
                        });

                        $('body').append("<script type=\"text\/javascript\" src=\""+iframeScriptUrl+"\"><\/script>");
                    }
                }
            });
            return false;
        });
    });
    

    function goToNextAccordion(triggerElement) {
        var $currentPanel = $(triggerElement).parentsInclude('.panel');
        if (checkExist($currentPanel)) {
            $currentPanel.next('.panel').find('a[data-toggle=collapse]').click();
        }
    }
    
</script>

@section('js_imports_footer')

@endsection