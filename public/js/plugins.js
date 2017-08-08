$(document).ready(function(){
    if(isPluginLoaded($.fn.multiSelect)){
        $('.multiselect-dual').multiSelect();
    }
    if(isPluginLoaded($.fn.fileinput)){
        $(".bootstrap-file-input").fileinput({
            'showUpload': false
        });
    }
});