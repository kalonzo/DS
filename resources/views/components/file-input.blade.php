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
        $fileExtensions = null;
    break;
    case 'image':
        $fileExtensions = ['jpg', 'png'];
    break;
    case 'video':
        $fileExtensions = ['mp4', 'avi', 'mpeg'];
    break;
}
$fileType = json_encode($fileType);
$fileExtensions = json_encode($fileExtensions);

if(!isset($directUpload)){
    $directUpload = false;
}

@endphp
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
                        showRemove: {{ $showRemove }},
                    @endif
                    allowedFileTypes: {!! $fileType !!},
                    allowedFileExtensions: {!! $fileExtensions !!},
                    browseLabel: "@lang('Parcourir')",
                    removeLabel: "@lang('Supprimer')",
                    uploadLabel: "@lang('Upload')",
                    maxFileSize: 5000,
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
                })
                .on('filebeforedelete', function(event, key, data) {
                    return false;
                })
                .on('filesorted', function(event, params) {
                    console.log('File sorted ', params.previewId, params.oldIndex, params.newIndex, params.stack);
                })
                @if($directUpload)
                .on("filebatchselected", function(event, files) {
                    $input.fileinput("upload");
                })
                .on("fileuploaded", function(event, data, previewId, index) {
                    var response = data.response;
                    var inputData = response.inputData;
                    if(typeof inputData != 'undefined'){
                        console.log(inputData);
                        $input.fileinput("refresh", inputData);
                    }
                })
                @endif
                ;
            });
        }
    @if(!Request::ajax())
    });
    @endif
</script>