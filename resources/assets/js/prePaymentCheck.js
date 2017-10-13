

$(document).ready(function () {
    var validPaymentTypeSubmit = true;
    var countryCodeCH = 168;
    var paymentModeThirty = 2;
    var thirtyDays = 0;
    var warned = false;
    /**
     * countryRequired(countryCriteria) 
     * returns bool if the form country is the same as req country
     * @param countryCriteria
     * @const currentCountry
     */
    function countryRequired(countryCriteria) {
        var currentCountry = $('#form-group-country select').val();
        var validityOutput;
        if (currentCountry == countryCriteria) {
            validityOutput = true;
        } else {
            validityOutput = false;
        }
        return validityOutput;
    }

    /**
     * isBillingChecked() 
     * returns bool if payment method is checked
     * @const paymentModeThiry
     */
    function isBillingChecked() {
        return $('.radio-inline input[name = "payment_method"][value =' + paymentModeThirty + ']:checked').length;
    }

    /**
     * displayWarning()() 
     *Turns on warning messages in blade
     */

    function displayWarning() {
        $('#form-group-country label[for="address[id_country]"]').hide();
        $('#country-warning').css('visibility', 'visible');

        if (warned == false) {
            $('#payment-warning').css('visibility', 'visible');
            warned = true;
        }
        $('#collapse4').removeAttr('style');
        $('#collapse4').addClass('in');
        $('#collapse5').removeAttr('style');
        $('#collapse5').addClass('in');
    }

    $('.radio-inline input[name = "payment_method"][value = "2"]').click(function () {
        thirtyDays = isBillingChecked();
        if (thirtyDays > 0 && countryRequired(countryCodeCH) == false) {
            console.log(countryRequired(countryCodeCH));
            validPaymentTypeSubmit = countryRequired(countryCodeCH);
            displayWarning();
        } else {
            //do nothing for now
        }
    }).delay(1);

    $('#collapse4').click(function () {
        if (isBillingChecked() < 1 && warned == true) {
            $("#payment-warning").css('visibility', 'hidden');
            $('#form-group-country label[for="address[id_country]"]').show();
            $('#country-warning').css('visibility', 'hidden');
            warned = false;
        }

    });

    $("#validToPayment").mouseenter(function () {
        if (isBillingChecked() > 0) {
            validPaymentTypeSubmit = countryRequired(countryCodeCH);
            console.log(validPaymentTypeSubmit);
        } else {
            validPaymentTypeSubmit = true;
        }
    });

    $("#validToPayment").click(function () {
        if (validPaymentTypeSubmit === true) {
            //do nothing
        } else {
            displayWarning();
            location.href = "#heading13";
            return false;
        }
    });

    $(window).keydown(function (event) {
        if (isBillingChecked() > 0) {
            validPaymentTypeSubmit = countryRequired(countryCodeCH);
            if (event.keyCode == 13 && validPaymentTypeSubmit == false) {
                event.preventDefault();
                console.log('No Enter key until payment option change');
                displayWarning();
                //location.href = "#address[po_box]";
                location.href = "#heading13";
                return false;
            }
        }
    });

    $(".form-control.select2.s2-done.select2-hidden-accessible").change(function () {
        if (isBillingChecked() > 0 && countryRequired(countryCodeCH) == false) {
            displayWarning();
        } else if (isBillingChecked() > 0 && countryRequired(countryCodeCH) === true) {
            $('#form-group-country label[for="address[id_country]"]').show();
            $('#country-warning').css('visibility', 'hidden');
            $("#payment-warning").css('visibility', 'hidden');
            warned = false;
            console.log('reset fields');
        }
    }).delay(1);

});
