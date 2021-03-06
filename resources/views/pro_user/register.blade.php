@extends('layouts.front') 

@section('css_imports')
<link href="/css/establishment.css" rel="stylesheet">
@endsection

@section('content')

<div id="map"> </div>
@if(checkModel($user))
{!! Form::model($user, ['id'=>'feed-pro-user', 'url' => '/establishment/register/'.$user->getUuid(), 'method' => 'PUT', 'files' => true]) !!}
@else
{!! Form::open(['id'=>'feed-pro-user', 'url'=>'/establishment/register/', 'method' => 'put', 'files' => true]) !!}
@endif
{!! Form::hidden('id_user', old('id_user')) !!}
<?php
if(checkRight(\App\Models\Action::CREATE_USER_PRO_ADMIN) && !empty(Illuminate\Support\Facades\Request::get('id_establishment'))){
    echo Form::hidden('id_establishment', Request::get('id_establishment'));
}
?>


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
    <div class="panel-group form-accordion" id="pro_user_form_accordion" role="tablist" aria-multiselectable="true">  
        @component('pro_user.form.credentials', ['user' => $user, 'form_data' => $form_data, 'form_values' => $form_values])
        @endcomponent   

        @component('pro_user.form.business_categories', ['user' => $user, 'form_data' => $form_data, 'form_values' => $form_values])
        @endcomponent   

        @component('pro_user.form.subscription', ['user' => $user, 'form_data' => $form_data, 'form_values' => $form_values])
        @endcomponent   

        @component('pro_user.form.mode_payment', ['user' => $user, 'form_data' => $form_data, 'form_values' => $form_values])
        @endcomponent   

        @component('pro_user.form.info_bill', ['user' => $user, 'form_data' => $form_data, 'form_values' => $form_values])
        @endcomponent   
    </div>
    <div class="row no-margin text-center">
        <div class="col-sm-4 col-sm-offset-4 col-md-3 col-md-offset-4_5">
            <div class="checkbox">
                <label class="text-left">
                    {!! Form::checkbox('accept_cgv', '1', false) !!}
                    En cochant cette case, je/nous accepte/acceptons les conditions générales d'utilisation et la politique de confidentialité.
                </label>
            </div>
        </div>
        <br class="cleaner"/><br/>
        <div class="col-xs-12">
            {{-- !! Form::submit('Submit', array('class'=>'btn btn-lg')) !! --}}
            {!! Form::button('Envoyer', ['class' => 'btn btn-lg form-data-button', 'type' => 'button', 'id' => 'validToPayment']) !!}
        </div>
        <br class="cleaner"/><br/><br/>
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
                <img src="/img/logo-dinerscope.png" alt="Dinerscope"/>
            </div>
            <div class="modal-body">
                <div class="row" id="payment-form">
                    
                </div>
                <div class="progress loading-bar">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                      <!--<span class="sr-only">-->Chargement en cours...<!--</span>-->
                    </div>
                </div>
                <div class="form-error">
                    
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
        $('body').on('click', '#validToPayment', function(e){
            $('#checkoutModal').modal('show');
            $('#checkoutModal .loading-bar').show();
            $('#checkoutModal .form-error').hide();
            $('#iframe-ext-footer').hide();
            $('#payment-form').empty();
        });
        
        $('body').on('ajaxFormFailed', 'form#feed-pro-user', function(e, data){
            $('#checkoutModal').modal('hide');
        });
        
        $('body').on('ajaxFormSubmitted', 'form#feed-pro-user', function(e, data){
            $('#checkoutModal').modal('show');
            var $form = $(this);

            if(data.success){
                if(!isEmpty(data.id_user)){
                    $form.find('[name=id_user]').val(data.id_user);
                }
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
                                $('#checkoutModal .loading-bar').hide();
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
                            $('#checkoutModal .loading-bar').hide();
                            $('#payment-form').html("Une erreur est survenue avec le service de paiement.");
                        }
                    }
                    $(document).ready(function(){
                        myLoop = setInterval(loadPaymentIframe, 200);
                    });

                    $('body').append("<script type=\"text\/javascript\" src=\""+iframeScriptUrl+"\"><\/script>");
                } else if(data.payment_page){
                    redirectToUrl(data.payment_page);
                }
            } else if(data.error){
                $('#checkoutModal .form-error').html(data).show();
            }
        });
        
    });
    
</script>

@section('js_imports_footer')
<script src="/js/google-map.js"></script>
<script src="/js/prePaymentCheck.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&callback=initGoogleAPI&libraries=places" type="text/javascript"></script>
@endsection
