$(document).on('ready', function(){
    $('body').on('hidden.bs.modal', '.ajax-modal:not(#ajax-modal-sample)', function (e) {
        $(this).remove();
    });
});

$(document).on('ready js-loaded ajaxSuccess', function(e){
    if (isPluginLoaded($.fn.multiSelect)) {
        $('.multiselect-dual:not(.msd-done)').each(function(){
            $(this).addClass('msd-done');
            $(this).multiSelect();
        });
    }
    if(isPluginLoaded($.fn.datepicker)){
        $.datepicker.setDefaults($.datepicker.regional[ "fr" ]);
        $.datepicker.setDefaults({dayNamesMin: $.datepicker._defaults.dayNamesShort});
        
        $('div.datepicker-inline:not(.dpi-done)').each(function(){
            $(this).addClass('dpi-done');
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
        
        $('select.select2:not(.s2-done)').each(function(){
            $(this).addClass('s2-done');
            var tagsParam = $(this).attr('data-tags') ? true : false;
            var maxSelectionLengthParam = $(this).attr('data-maximumSelectionLength') ? $(this).attr('data-maximumSelectionLength') : null;
            var options = {
                tags: tagsParam,
                maximumSelectionLength: maxSelectionLengthParam
            };
            if(this.hasAttribute('data-ajax-url')){
                var ajaxFeedUrl = $(this).attr('data-ajax-url');
                var ajaxFeedAction = $(this).attr('data-ajax-action');
                options['ajax'] = {
                    url: ajaxFeedUrl,
                    data: function (params) {
                        return {
                            action: ajaxFeedAction,
                            q: params.term
                        };
                    },
                    dataType: 'json',
                    delay: 250,
                }
                options['minimumInputLength'] = 2;
            }
            $(this).select2(options);
        });
    }
    if (isPluginLoaded($.fn.ckeditor)) {
        $('.ckeditor:not(.cke-done)').each(function () {
            $(this).addClass('cke-done');
            var options = {
      
            };
            $(this).ckeditor(options);
        });
    }
    if (typeof baguetteBox != 'undefined') {
        baguetteBox.run('.gallery-box');
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
