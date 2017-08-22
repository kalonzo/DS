@extends('layouts.front') 

@section('content')

<div class="container-fluid">
    <div class="row">
        @lang('messages.bienvennue')  
        @lang('Bonjour.') 
        @lang('Switzerland') 
        Dinerscope
    </div>

    <div class="row">
        <ul id="payment-errors"></ul>
        <div id="payment-form"></div>
        <button id="pay-button">Pay</button>
    </div>
</div>

@endsection

<script src="{{$url}}" type="text/javascript"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) { 
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
                        alert('chekpoint');
                        $.ajax('http://dinerscope/welcome', {
                            success: function () {
                                handler.submit();
                            }
                        });
                    } else {
                        // Display errors to customer
                        $.each(validationResult.errors, function (index, errorMessage) {
                            $('#payment-errors').append('<li>' + errorMessage + '</li>');
                        });
                    }
                });

        //Set the optional initialize callback
        handler.setInitializeCallback(function () {
            //Execute initialize code
        });

        //Set the optional height change callback
        handler.setHeightChangeCallback(function (height) {
            //Execute code
        });

        handler.create(containerId);

        
         $('#pay-button').on('click', function(){
            handler.validate();
         });
    });
</script>