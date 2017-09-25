<?php
if(!isset($multiple)){
    $multiple = false;
    $class .= ' file-input-single';
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
}
if(!is_array($fileType)){
    $fileType = array($fileType);
}
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
            $fileExtensions[] = 'avi';
            $fileExtensions[] = 'mpeg';
            $typeMaxFileSize= 40000;
            if($typeMaxFileSize > $maxFileSize){
                $maxFileSize = $typeMaxFileSize;
            }
        break;
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
                        showRemove: {!! $showRemove !!},
                    @endif
                    @if(isset($showCaption))
                        showCaption: {!! $showCaption !!},
                    @endif
                    @if(isset($showClose))
                        showClose: {!! $showClose !!},
                    @endif
                    @if(isset($showPreview))
                        showPreview: {!! $showPreview !!},
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
                    overwriteInitial: false,
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
                .on('filesorted', function(event, params) {
                    console.log('File sorted ', params.previewId, params.oldIndex, params.newIndex, params.stack);
                })
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
                ;
            });
        }
    @if(!Request::ajax())
    });
    @endif
</script>