$(document).ready(function () {
    var countryCodeCH = 168;
    var paymentMode30DaysBilling = 2;

    function is30DaysBillingChecked() {
        return $('input[name="payment_method"][value=' + paymentMode30DaysBilling + ']').is(':checked');
    }
    
    function isSwitzerlandSelected(){
        return $('select[name="address[id_country]"]').val() == countryCodeCH;
    }

    $('input[name="payment_method"]').click(function () {
        if (is30DaysBillingChecked() && !isSwitzerlandSelected()) {
            $('#country-warning').show();
            $('#payment-warning').show();
        } else {
            $('#country-warning').hide();
            $('#payment-warning').hide();
        }
    });
    
    $('select[name="address[id_country]"]').change(function () {
        if (is30DaysBillingChecked() && !isSwitzerlandSelected()) {
            $('#country-warning').show();
            $('#payment-warning').show();
        } else {
            $('#country-warning').hide();
            $('#payment-warning').hide();
        }
    });
});
