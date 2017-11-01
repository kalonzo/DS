$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

dsSetCookie = function(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
};

dsGetCookie = function(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
};

function readCookie(name) {
    var cookiename = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++)
    {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(cookiename) == 0) return c.substring(cookiename.length,c.length);
    }
    return null;
}

function reloadPage(extraParams, doneCallback){
    var pathArray  = window.location.pathname.split( '/' );
    if(pathArray.length === 1){
        var secondLevelLocation = pathArray[0];
    } else {
        var secondLevelLocation = pathArray[1];
    }
    var $mainPageReloadContainer = $('body .mainPageReloadContainer');

    if(checkExist($mainPageReloadContainer)){
        var ajaxParams = {};
        $.each(extraParams, function(index, item){
            ajaxParams[index] = item;
        });
        ajaxParams['reload'] = true;

        $.ajax({
            url: '/'+secondLevelLocation,
            data: ajaxParams,
        })
        .done(function( data ) {
            $mainPageReloadContainer.empty().html(data);
            if(!isEmpty(doneCallback) && typeof doneCallback === 'function'){
                doneCallback();
            }
        });
    }
};

function getParamsArrayFromUrl(url){
    var paramsArray = null;
    if(!isEmpty(url)){
        var paramsIndex = url.indexOf('?');
        if(paramsIndex >= 0){
            paramsIndex += 1;
            var params = url.substring(paramsIndex);
            paramsArray = JSON.parse('{"' + decodeURI(params.replace(/&/g, "\",\"").replace(/=/g,"\":\"")) + '"}')
        }
    }
    return paramsArray;
}

goToNextAccordion = function(triggerElement) {
    var $currentPanel = $(triggerElement).parentsInclude('.panel');
    if (checkExist($currentPanel)) {
        $currentPanel.next('.panel').find('a[data-toggle=collapse]').click();
    }
}

selectTimelineItem = function (triggerElement){
    var itemId = $(triggerElement).attr('data-id');
    $(triggerElement).parentsInclude('.timeline-links').find('.selected').removeClass('selected');
    $(triggerElement).parentsInclude('.timeline-links').find('[data-id='+itemId+']').addClass('selected');
};

getOnClickModal = function(title, url, params, modalId, modalClassSize, modalClasses, method){
    var $sampleModal = $('#ajax-modal-sample');
    if(checkExist($sampleModal) && !isEmpty(url)){
        var newModal = $sampleModal.clone();
        if(isEmpty(modalId)){
            modalId = 'modal_'+ Math.round(Math.random() * 1000000);
        }
        if(isEmpty(modalClassSize)){
            modalClassSize = 'modal-lg';
        }
        if(method !== 'post' && method !== 'POST'){
            method = 'get';
        }
        $(newModal).attr('id', modalId);
        $(newModal).addClass(modalClasses);
        $(newModal).find('.modal-dialog').addClass(modalClassSize);
        $(newModal).find('.modal-title').html(title);
        $('body').append(newModal);
        $(newModal).modal('show');
        
        $.ajax({
            url: url,
            type: method,
            data: params,
            dataType: 'json',
            success: function (data) {
                if(data.success){
                    $(newModal).find('.loading-bar').hide();
                    $(newModal).find('.modal-errors').hide();
                    $(newModal).find('.modal-inner-body').empty().append(data.content);
                }
//                if(typeof callback == 'function'){
//                    callback(data);
//                }
            },
            error: function (data) {
                console.log(data);
//                if(typeof callback == 'function'){
//                    callback(data);
//                }
            }
        });
    }
};

redirectToUrl = function(url){
    document.location.href=url;
}

confirmChoice = function(text, ifTrue, ifFalse){
    if(confirm(text)){
        eval(ifTrue);
    } else {
        eval(ifFalse);
    }
}

alertFileInputError = function(event, data, msg){
    var errors = data.jqXHR.responseJSON;
    var alertMsg = '';
    if(typeof errors != 'undefined'){
        var nbInputErrors = Object.keys(errors).length;
        if(nbInputErrors > 0){
            $.each(errors, function (key, value) {
                alertMsg += '' + value + '\n';
            });
        } else {
            alertMsg += msg;
        }
    } else {
        alertMsg += msg;
    }
    alertMsg += '';
    alert(alertMsg);
};
    
/*
    var searchRadius = 500;
    function calculateDistance() {
        var destinationPositionLat = $('#inputLatitude').val() * 1;
        var destinationPositionLng = $('#inputLongitude').val() * 1;
        if (userPositionLng !== null && userPositionLat !== null && destinationPositionLng !== null && destinationPositionLat !== null) {
            var earth_radius = 6378137;   // Terre = sphère de 6378km de rayon
            var rlo1 = Math.radians(userPositionLng);
            var rla1 = Math.radians(userPositionLat);
            var rlo2 = Math.radians(destinationPositionLng);
            var rla2 = Math.radians(destinationPositionLat);
            var dlo = (rlo2 - rlo1) / 2;
            var dla = (rla2 - rla1) / 2;
            var a = (Math.sin(dla) * Math.sin(dla)) + Math.cos(rla1) * Math.cos(rla2) * (Math.sin(dlo) * Math.sin(dlo));
            var d = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var distance = earth_radius * d;

            $('#distanceOutput').val(Math.round(distance));
        }
    }

    function calculateRouteDistance() {
        var service = new google.maps.DistanceMatrixService();
        service.getDistanceMatrix({
            origins: [userPositionLat + "," + userPositionLng],
            destinations: [$('#inputLatitude').val() + "," + $('#inputLongitude').val()],
            travelMode: google.maps.TravelMode.DRIVING,
            avoidHighways: false,
            avoidTolls: false
        }, function (response, status) {
            if (status != google.maps.DistanceMatrixStatus.OK) {
                console.log(err);
            } else {
                var origin = response.originAddresses[0];
                var destination = response.destinationAddresses[0];
                if (response.rows[0].elements[0].status === "ZERO_RESULTS") {
                    console.log("Better get on a plane. There are no roads between " + origin + " and " + destination);
                } else {
                    var distance = response.rows[0].elements[0].distance;
                    var distance_value = distance.value;
                    var distance_text = distance.text;
                    var miles = distance_text.substring(0, distance_text.length - 3);
                    $('#distanceRouteOutput').val(distance_value);
                }
            }
        }
        );
    }
*/