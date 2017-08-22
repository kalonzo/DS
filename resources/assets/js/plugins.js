$(document).ready(function () {
    if (isPluginLoaded($.fn.multiSelect)) {
        $('.multiselect-dual').multiSelect();
    }
    if(isPluginLoaded($.fn.datepicker)){
        $.datepicker.setDefaults($.datepicker.regional[ "fr" ]);
        $.datepicker.setDefaults({dayNamesMin: $.datepicker._defaults.dayNamesShort});
        
        $('div.datepicker-inline').each(function(){
            var $input = $(this).find('input[type=hidden]');
            if(checkExist($input)){
                var options = {
                    dateFormat: "dd/mm/yy",
                    defaultDate: $input.val(),
                    onSelect: function(dateText, inst){
                        $($input).val(dateText).change();
                    }
                };
                $(this).datepicker(options);
            }
        });
    }
    if(isPluginLoaded($.fn.select2)){
        $.fn.select2.defaults.set('language', 'fr');
        
        $('.select2').each(function(){
            var tagsParam = $(this).attr('aria-tags') ? true : false;
            var maxSelectionLengthParam = $(this).attr('data-maximumSelectionLength') ? $(this).attr('data-maximumSelectionLength') : null;
            var options = {
                tags: tagsParam,
                maximumSelectionLength: maxSelectionLengthParam
            };
            $(this).select2(options);
        });
    }
    if (isPluginLoaded($.fn.ckeditor)) {
        $('.ckeditor').each(function () {
            var options = {
      
            };
            $(this).ckeditor(options);
        });
    }
    
    
});
$(document).on('googleGeolocReady', function () {
    $('.quick-map').each(function () {
        var lat = $(this).attr('data-lat') * 1;
        var lng = $(this).attr('data-lng') * 1;
        var zoom = $(this).attr('data-zoom') * 1;
        if (!isEmpty(lat) && !isEmpty(lng) && !isNaN(lat) && !isNaN(lng)) {
            if (isNaN(zoom)) {
                zoom = 15;
            }
            var quickmap = new google.maps.Map(this, {
                center: {lat: lat, lng: lng},
                zoom: zoom,
                streetViewControl: false,
//                    scrollwheel: false,
                styles: [{
                        featureType: 'poi.business',
                        stylers: [{
                                visibility: 'off'
                            }]
                    }, {
                        featureType: 'transit',
                        elementType: 'labels.icon',
                        stylers: [{
                                visibility: 'off'
                            }]
                    }]
            });
            markerPosition = new google.maps.Marker({
                position: {lat: lat, lng: lng},
                map: quickmap,
//                icon: '/img/you_are_here.png',
                zIndex: 1
            });
        }
    });
});
