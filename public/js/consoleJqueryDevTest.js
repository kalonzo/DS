/* 
 * Dev JS file for testing new scripts
 * Waits till load of all other JS scripts before running new script
 * 
 */

(function(funcName, baseObj) {
    "use strict";
    // The public function name defaults to window.docReady
    // but you can modify the last line of this function to pass in a different object or method name
    // if you want to put them in a different namespace and those will be used instead of 
    // window.docReady(...)
    funcName = funcName || "docReady";
    baseObj = baseObj || window;
    var readyList = [];
    var readyFired = false;
    var readyEventHandlersInstalled = false;
    
    // call this when the document is ready
    // this function protects itself against being called more than once
    function ready() {
        if (!readyFired) {
            // this must be set to true before we start calling callbacks
            readyFired = true;
            for (var i = 0; i < readyList.length; i++) {
                // if a callback here happens to add new ready handlers,
                // the docReady() function will see that it already fired
                // and will schedule the callback to run right after
                // this event loop finishes so all handlers will still execute
                // in order and no new ones will be added to the readyList
                // while we are processing the list
                readyList[i].fn.call(window, readyList[i].ctx);
            }
            // allow any closures held by these functions to free
            readyList = [];
        }
    }
    
    function readyStateChange() {
        if ( document.readyState === "complete" ) {
            ready();
        }
    }
    
    // This is the one public interface
    // docReady(fn, context);
    // the context argument is optional - if present, it will be passed
    // as an argument to the callback
    baseObj[funcName] = function(callback, context) {
        if (typeof callback !== "function") {
            throw new TypeError("callback for docReady(fn) must be a function");
        }
        // if ready has already fired, then just schedule the callback
        // to fire asynchronously, but right away
        if (readyFired) {
            setTimeout(function() {callback(context);}, 1);
            return;
        } else {
            // add the function and context to the list
            readyList.push({fn: callback, ctx: context});
        }
        // if document already ready to go, schedule the ready function to run
        // IE only safe when readyState is "complete", others safe when readyState is "interactive"
        if (document.readyState === "complete" || (!document.attachEvent && document.readyState === "interactive")) {
            setTimeout(ready, 1);
        } else if (!readyEventHandlersInstalled) {
            // otherwise if we don't have event handlers installed, install them
            if (document.addEventListener) {
                // first choice is DOMContentLoaded event
                document.addEventListener("DOMContentLoaded", ready, false);
                // backup is window load event
                window.addEventListener("load", ready, false);
            } else {
                // must be IE
                document.attachEvent("onreadystatechange", readyStateChange);
                window.attachEvent("onload", ready);
            }
            readyEventHandlersInstalled = true;
        }
    }
})("docReady", window);
// modify this previous line to pass in your own method name 
// and object for the method to be attached to

docReady(function() {
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

    /**
    $("#formCountry").click(function(){
        
        $("#select2-addressid_country-results").children().each(function () {
            //console.log(this.id); // "this" is the current element in the loop
            //console.log(this.id);
            var targetsID = '#' + this.id; 
            var countryTarget = $(targetsID).html();
             
            //console.log(countryTarget);
            //si Pas la France ou la Suisse Remove
            if (countryTarget == 'Suisse'){
                console.log("DoNothing");
            } else {
                //$(targetsID).remove();
            }
        });
        
    }).delay(1);
    
    //.select2-search.select2-search--dropdown input[type="search"]
    $('.select2-search.select2-search--dropdown input[type="search]"').keyup(function() {
        console.log("KeyDetected");
        
        $("#select2-addressid_country-results").children().each(function () {
            //console.log(this.id); // "this" is the current element in the loop
            //console.log(this.id);
            var targetsID = '#' + this.id; 
            var countryTarget = $(targetsID).html();
             
            //console.log(countryTarget);
            //si Pas la France ou la Suisse Remove
            if (countryTarget == 'Suisse'){
                console.log("DoNothing");
            } else {
                $(targetsID).remove();
            }
        });
        
    }).delay(1);
    **/
    
});