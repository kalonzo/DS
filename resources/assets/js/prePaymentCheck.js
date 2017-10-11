/* 
 *Pre-payment warnings
 */

$(document).ready(function(){
    
    //console.log('Test script loaded in consoleJqueryDevTest.js');
    var validPaymentTypeSubmit = true;
    var messageWarning = "* Pays: Facture à 30 jours seulement valable en Suisse, changez pays ou type de paiement";
    var theCountry = 'Suisse';
    var theCountryCode = 168;
    var thirtyDays = 0;
    var warned = false;
    
    function countryRequired (countryCriteria) {
        //Pour Select2
        var currentCountry = $('#select2-addressid_country-container').html();
        //Pour des cas de non select2
        // currentCountry = $(".form-control.select2.s2-done.select2-hidden-accessible").val();
        
        var validityOutput;
        if (currentCountry == countryCriteria){
            validityOutput = true;
        } else {
            validityOutput = false;
        }
        //Return true if country matches the desired country else false
        //if not switzerland returns false
        return validityOutput;
    };

   function isBillingChecked () {
       //return 1 if billing is selected
       return $('.radio-inline input[name = "payment_method"][value = "2"]:checked').length;
   };
   
   function displayWarning () {
        $('#formCountry label[for="address[id_country]"]').text(messageWarning);
        $('#formCountry').css({ color: "red" });
        
       if (warned == false){
            $('#collapse4').append('<div class="row" style="text-align: center; color:red;" id="paymentwarning">Facture à 30 jours valable seulement en Suisse, changez pays ou type de paiement <br></div>'); 
            warned = true;
       }
       $('#collapse4').removeAttr('style');
       $('#collapse4').addClass('in');
       $('#collapse5').removeAttr('style');
       $('#collapse5').addClass('in');
   };
   
   //Value stuck on 61 with Select 2...
   function currentDisplayVal () {
       return $(".form-control.select2.s2-done.select2-hidden-accessible").val();
   };
   
   //When the radio button 30 days is checked
    $('.radio-inline input[name = "payment_method"][value = "2"]').click(function() {
       thirtyDays = isBillingChecked();
       if (thirtyDays > 0 && countryRequired(theCountry) == false){
           console.log(countryRequired(theCountry));
           validPaymentTypeSubmit = countryRequired(theCountry);
           displayWarning();
       } else {
           //do nothing for now
       }
    }).delay(1);
    
    //when any other radio button in box area is checked
    $('#collapse4').click (function () {
        if (isBillingChecked() < 1){
            $("#paymentwarning").remove();
            $('#formCountry label[for="address[id_country]"]').text('* Pays');
            $('#formCountry').css({ color: "white" });
            warned = false;
        }
        
    }).delay(1);
    
    //when mouse enters the bottom submit button
    $("#validToPayment").mouseenter(function () {
        if (isBillingChecked() > 0) {
            validPaymentTypeSubmit = countryRequired(theCountry);
            console.log(validPaymentTypeSubmit);
        } else {
            validPaymentTypeSubmit = true;
        }
    });
    
    //on click, disable click action unless the payment is valid
    $("#validToPayment").click(function () {
        if(validPaymentTypeSubmit === true){
            //do nothing
        } else {
            displayWarning ();
            location.href = "#heading13";
            return false;
        }
     });
     
    //On enter, i.e no click we check the billing type and country
    $(window).keydown(function(event){
        if (isBillingChecked() > 0) {
            validPaymentTypeSubmit = countryRequired(theCountry);
            if(event.keyCode == 13 && validPaymentTypeSubmit == false) {
                event.preventDefault();
                console.log('No Enter key until payment option change');
                displayWarning ();
                //location.href = "#address[po_box]";
                location.href = "#heading13";
                return false;
            }
        }
    });

    $(".form-control.select2.s2-done.select2-hidden-accessible").change(function() {
       if(isBillingChecked() > 0 && countryRequired(theCountry) == false) {
           displayWarning ();
       } else if(isBillingChecked() > 0 && countryRequired(theCountry) === true) {
           $('#formCountry label[for="address[id_country]"]').text('* Pays');
           $('#formCountry').css({ color: "white" });
           $("#paymentwarning").remove();
           warned = false;
           console.log('reset fields');
       }
    }).delay(1);

});
