<div class="panel panel-default">
    @lang('messages.bienvennue')  
    
    
   @lang('Bonjour.') 
   
   @lang('Switzerland') 
    
    
    Dinerscope
       
</div>
 
<ul id="payment-errors"></ul>
<div id="payment-form"></div>
<button id="pay-button">Pay</button>

<script src="jquery.js" type="text/javascript"></script>
<script src="{ JavaScript URL }" type="text/javascript"></script>
<script type="text/javascript">
// Set here the id of the payment method configuration the customer chose.
var paymentMethodConfigurationId = 616;

// Set here the id of the HTML element the payment iframe should be appended to.
var containerId = 'payment-form';

var handler = window.IframeCheckoutHandler(paymentMethodConfigurationId);

handler.setValidationCallback(
	function(validationResult){
		// Reset payment errors
		$('#payment-errors').html('');

		if (validationResult.success) {
			// Create the order within the shop and eventually update the transaction.
			$.ajax('http://your-shop-backend.com/create-order', {
				success: function(){
					handler.submit();
				}
			});
		} else {
			// Display errors to customer
			$.each(validationResult.errors, function(index, errorMessage){
				$('#payment-errors').append('<li>' + errorMessage + '</li>');
			});
		}
	});

//Set the optional initialize callback
handler.setInitializeCallback(function(){
		//Execute initialize code
	});

//Set the optional height change callback
handler.setHeightChangeCallback(function(height){
		//Execute code
	});

handler.create(containerId)


$('#pay-button').on('click', function(){
	handler.validate();
});
</script>