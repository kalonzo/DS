<?php
/** file-input notes
*Gallery reordering-> search "Drag and Drop Ajax ordering JS"
*  
*/

if(!isset($overwriteInitial)){
    $overwriteInitial = false;
}
if(!isset($multiple)){
    $multiple = false;
    $class .= ' file-input-single';
    $overwriteInitial = true;
} else if($multiple){
    $name .= '[]';
    $class .= ' file-input-multiple';
}

if(isset($medias) && !empty($medias)){
    if(!isset($existingFiles)){
        $existingFiles = getMediaUrlForInputFile($medias);
    }
    if(!isset($existingFilesConfig)){
        $existingFilesConfig = getMediaConfigForInputFile($medias);
    }
} else {
    $existingFiles = '[]';
    $existingFilesConfig = '[]';
}

$maxFileSize= 5000;
if(!isset($fileExtensions)){
    $fileExtensions = array();
}
//['image', 'html', 'text', 'video', 'audio', 'flash', 'object']
if(!isset($fileType)){
    $fileType = array();
} else {
    if(!is_array($fileType)){
        $fileType = array($fileType);
    }
}
if(!empty($fileType)){
    foreach($fileType as $type){
        switch($type){
            default:
                $typeMaxFileSize= 5000;
                if($typeMaxFileSize > $maxFileSize){
                    $maxFileSize = $typeMaxFileSize;
                }
            break;
            case 'image':
                $fileExtensions[] = 'jpg';
                $fileExtensions[] = 'png';
                $typeMaxFileSize= 5000;
                if($typeMaxFileSize > $maxFileSize){
                    $maxFileSize = $typeMaxFileSize;
                }
            break;
            case 'text':
                $fileExtensions[] = 'doc';
                $fileExtensions[] = 'docx';
                $fileExtensions[] = 'pdf';
                $typeMaxFileSize= 5000;
                if($typeMaxFileSize > $maxFileSize){
                    $maxFileSize = $typeMaxFileSize;
                }
            break;
            case 'video':
                $fileExtensions[] = 'mp4';
                $typeMaxFileSize= 40000;
                if($typeMaxFileSize > $maxFileSize){
                    $maxFileSize = $typeMaxFileSize;
                }
            break;
        }
    }
}
if(!empty($fileType)){
    $fileType = json_encode($fileType);
}
$fileExtensions = json_encode($fileExtensions);

if(!isset($fileRefreshOnUpload)){
    $fileRefreshOnUpload = false;
}
if(!isset($directUpload)){
    $directUpload = false;
}
if(!isset($uploadLabel)){
    $uploadLabel = __('Upload');
}
if(!isset($browseLabel)){
    $browseLabel = __('Parcourir');
}

if(!isset($tablename)){
    $tablename = "";
};
?>

<input type="file" name="{!! $name !!}" class="bootstrap-file-input {{ $class }}" @if($multiple) multiple @endif />
<script type="text/javascript">
    @if(!Request::ajax())
    document.addEventListener("DOMContentLoaded", function(event) { 
    @endif
        if(isPluginLoaded($.fn.fileinput)){
            $(".bootstrap-file-input[name='{!! $name !!}']").each(function(){
                var $input = $(this);
                $input.fileinput({
                    @if(isset($uploadUrl) && !$directUpload)
                        showUpload: true,
                    @else
                        showUpload: false,
                    @endif
                    @if(isset($showRemove))
                        showRemove: @if($showRemove) true @else false @endif,
                    @endif
                    @if(isset($showBrowse))
                        showBrowse: @if($showBrowse) true @else false @endif,
                    @endif
                    @if(isset($showCaption))
                        showCaption: @if($showCaption) true @else false @endif,
                    @endif
                    @if(isset($showClose))
                        showClose: @if($showClose) true @else false @endif,
                    @endif
                    @if(isset($showPreview))
                        showPreview: @if($showPreview) true @else false @endif,
                    @endif
                    @if(isset($required))
                        required: {!! $required !!},
                    @endif
                    @if(!empty($fileType))
                        allowedFileTypes: {!! $fileType !!},
                    @endif
                    @if(!empty($fileExtensions))
                    allowedFileExtensions: {!! $fileExtensions !!},
                    @endif
                    browseLabel: "{!! $browseLabel !!}",
                    removeLabel: "@lang('Supprimer')",
                    uploadLabel: "{!! $uploadLabel !!}",
                    maxFileSize: {!! $maxFileSize !!},
                    overwriteInitial: @if($overwriteInitial) true @else false @endif,
                    previewFileType: 'any',
                    initialPreview: {!! $existingFiles !!},
                    initialPreviewAsData: true,
                    initialPreviewConfig: {!! $existingFilesConfig !!},
                    @if(isset($uploadUrl))
                    uploadUrl: '{!! $uploadUrl !!}',
                    @endif
                    @if(isset($extraData))
                    uploadExtraData: {{ $extraData }},
                    @endif
                    dropZoneEnabled: false,
                    previewFileIcon: '<i class="glyphicon glyphicon-file"></i>',
                    preferIconicPreview: true,
                    previewFileIconSettings: {
                        'doc': '<i class="glyphicon glyphicon-file doc"></i>',
                        'docx': '<i class="glyphicon glyphicon-file doc"></i>'
                    },
                    previewFileExtSettings: {
                        'doc': function(ext) {
                            return ext.match(/(doc|docx)$/i);
                        },
                        'docx': function(ext) {
                            return ext.match(/(doc|docx)$/i);
                        }
                    }
                })
                @if(!empty($tablename))
                .on('filesorted', function(event, params) {
                    // Drag and Drop Ajax ordering JS store in DB
                    var tableName = '{{$tablename}}';
                    var keyByPosition = {};
                    for (var i = 0; i < params.stack.length; i++) {
                        keyByPosition[i] = params.stack[i].key
                    }
                    var ajaxParams = {};
                    ajaxParams ["keyByPosition"] = keyByPosition;
                    ajaxParams["table"] = tableName;
                    //JSON is sent {table:"table_name", position : {0:"uuid"....n:"uuid"}}
                    $.ajax({
                        url: "/edit/update_order",
                        method: "POST",
                        data: ajaxParams,
                        datatype: "json",
                        error: function (jqXHR, exception) {
                            var msg = '';
                            var reload = false;
                            switch (jqXHR.status) {
                                case 0:
                                    msg = 'Not connect.\n Verify Network.';
                                    reload = true;
                                break;
                                case 404:
                                    msg = 'Photo order not changed. [404]';
                                    reload = true;
                                break;
                                case 500:
                                    msg = 'Photo order not changed. [500].';
                                    reload = true;
                                break;
                                default:
                                    switch (exception) {
                                         case 'parsererror':
                                             msg = 'Photo order not changed. Parse Error';
                                             break;
                                         case 'timeout':
                                             msg = 'Photo order not changed. Time Out';
                                             reload = true;
                                             break;
                                         case 'abort':
                                             msg = 'Photo order not changed. Ajax Abort';
                                            reload = true;
                                            break;
                                        default:
                                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                                            reload = true;
                                            break;
                                    }
                                break;
                            }

                            if (reload === true) {
                                alert('error:' + msg);
                            }
                        },
                    });
                    
                })
                @endif
                @if($directUpload || isset($filebatchselected))
                .on("filebatchselected", function(event, files) {
                    @if($directUpload)
                    $input.fileinput("upload");
                    @endif
                    
                    @if(isset($filebatchselected))
                    {!! $filebatchselected !!}
                    @endif                   
                })
                @endif
                @if($fileRefreshOnUpload || isset($fileuploaded))
                .on("fileuploaded", function(event, data, previewId, index) {
                    @if(isset($fileuploaded))
                    {!! $fileuploaded !!}
                    @endif
                    
                    @if(isset($fileRefreshOnUpload))
                    var response = data.response;
                    var inputData = response.inputData;
                    if(typeof inputData != 'undefined'){
                        $input.fileinput("refresh", inputData);
                    }
                    @endif
                    $input.fileinput('unlock');
                })
                @endif
                @if(isset($filepreupload))
                .on('filepreupload', function(event, data, previewId, index) {
                    {!! $filepreupload !!}
                })
                @endif
                @if(isset($filepreajax))
                .on('filepreajax', function(event, previewId, index) {
                    {!! $filepreajax !!}
                })
                @endif
                @if(isset($filebatchpreupload))
                .on('filebatchpreupload', function(event, data, previewId, index) {
                    {!! $filebatchpreupload !!}
                })
                @endif
                .on('filebeforedelete', function(event, key, data) {
                    var aborted = !window.confirm('Veuillez confirmer la suppression de ce fichier.');
                    if(aborted){
                        event.stopPropagation();
                    }
                    return aborted;
                })
                
                // ERRORS 
                @if(isset($fileerror))
                .on('fileerror', function(event, data, msg) {
                    {!! $fileerror !!}
                })
                @endif
                @if(isset($fileuploaderror))
                .on('fileuploaderror', function(event, data, msg) {
                    {!! $fileuploaderror !!}
                })
                @endif
                @if(isset($filebatchuploaderror))
                .on('filebatchuploaderror', function(event, data, msg) {
                    {!! $filebatchuploaderror !!}
                })
                @endif
                @if(isset($filedeleteerror))
                .on('filedeleteerror', function(event, data, msg) {
                    {!! $filedeleteerror !!}
                })
                @endif
                ;
            });
        }
    @if(!Request::ajax())
    });
    @endif
</script>