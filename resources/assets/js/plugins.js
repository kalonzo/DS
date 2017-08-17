$(document).ready(function () {
    if (isPluginLoaded($.fn.multiSelect)) {
        $('.multiselect-dual').multiSelect();
    }
//    if(isPluginLoaded($.fn.fileinput)){
//        $(".bootstrap-file-input").each(function(){
//            var initialPreview = $(this).attr('initialPreview');
//            $(this).fileinput({
//                showUpload: false,
//                hiddenThumbnailContent: true,
//                allowedFileExtensions: ['jpg', 'png'],
//                allowedFileTypes: ['image'],
//                browseLabel: 'Parcourir',
//                removeLabel: 'Supprimer',
//                uploadLabel: 'Upload',
//                maxFileSize: 2000,
//                previewFileType: 'any',
//                initialPreview: [initialPreview],
//    //            msgSizeTooLarge: "File "{name}" ({size} KB) exceeds maximum allowed upload size of {maxSize} KB. Please retry your upload!",
//            });
//        });
//    }
    if (isPluginLoaded($.fn.select2)) {
        $('.select2').each(function () {
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