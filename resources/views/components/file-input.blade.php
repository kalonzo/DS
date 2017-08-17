@php
if(!isset($multiple)){
    $multiple = false;
    $class .= ' file-input-single';
} else if($multiple){
    $name .= '[]';
    $class .= ' file-input-multiple';
}

if(isset($medias) && !empty($medias)){
    $existingFiles = getMediaUrlForInputFile($medias);
    $existingFilesConfig = getMediaConfigForInputFile($medias);
} else {
    $existingFiles = '[]';
    $existingFilesConfig = '[]';
}

$fileExtensions = array();
//['image', 'html', 'text', 'video', 'audio', 'flash', 'object']
if(!isset($fileType)){
    $fileType = 'image';
}
switch($fileType){
    default:
    case 'image':
        $fileExtensions = ['jpg', 'png'];
    break;
    case 'video':
        $fileExtensions = ['mp4', 'avi', 'mpeg'];
    break;
}
$fileType = json_encode($fileType);
$fileExtensions = json_encode($fileExtensions);

@endphp
<input type="file" name="{{ $name }}" class="bootstrap-file-input {{ $class }}" @if($multiple) multiple @endif />
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) { 
        if(isPluginLoaded($.fn.fileinput)){
            $(".bootstrap-file-input[name='{!! $name !!}']").each(function(){
                $(this).fileinput({
                    showUpload: false,
                    allowedFileTypes: {!! $fileType !!},
                    allowedFileExtensions: {!! $fileExtensions !!},
                    browseLabel: "@lang('Parcourir')",
                    removeLabel: "@lang('Supprimer')",
                    uploadLabel: "@lang('Upload')",
                    maxFileSize: 3000,
                    overwriteInitial: false,
                    previewFileType: 'any',
                    initialPreview: {!! $existingFiles !!},
                    initialPreviewAsData: true,
                    initialPreviewConfig: {!! $existingFilesConfig !!},
                });
            });
        }
    });
</script>