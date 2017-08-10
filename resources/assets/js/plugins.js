$(document).ready(function(){
    if(isPluginLoaded($.fn.multiSelect)){
        $('.multiselect-dual').multiSelect();
    }
    if(isPluginLoaded($.fn.fileinput)){
        $(".bootstrap-file-input").fileinput({
            'showUpload': false
        });
    }
    if(isPluginLoaded($.fn.select2)){
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
});