<?php

namespace App\Http\Controllers;

/**
 * Description of FileController
 *
 * @author Nico
 */
class FileController {
    const BASE_FILE_PATH = "";
    
    const FILE_ETS_LOGO = 1;
    
    /**
     * 
     * @param type $formInputFileName
     * @param type $fileType
     * @param \App\Models\Model $relatedObject
     * @param \App\Models\Media $media
     */
    public static function storeFile($formInputFileName, $fileType, $relatedObject, $media = null){
        $file = \Illuminate\Support\Facades\Request::file($formInputFileName);
        if(!empty($file)){
            if ($file->isValid()) {
                $hasChanged = true;
                $path = self::resolveFilePath($fileType, $relatedObject);
                
                // Get infos from request file input
                $fileMimeType = $file->getMimeType();
                $resolvedMimeType = self::resolveFileType($fileMimeType);
                $fileSize = $file->getClientSize();
                $fileName = $file->getClientOriginalName();
                $fileExtension = $file->getClientOriginalExtension();
                
                if(!checkModel($media)){
                    $media = self::resolveMediaInstance($fileType);
                } else {
                    // Check if file is different from previous saved media
                    if($media->getExtension() == $fileExtension && $media->getSize() == $fileSize && $media->getType() === $resolvedMimeType){
                        $hasChanged = false;
                    } 
                }
                if($hasChanged && $media instanceof \App\Models\Media){
                    $options = array();
                    if($media->getPublic() && $media->getDrive(\App\Models\Media::DRIVE_LOCAL)){
                        $options = 'public';
                    }
                    
                    // Store file physically
                    $relPath = $file->storePublicly($path, $options);
                    
                    if($relPath !== false){
                        if($media->getPublic()){
                            $relPath = 'public/'.$relPath;
                        }
                        // Get definitive file paths
                        $appRelPath = \Illuminate\Support\Facades\Storage::url($relPath);
                        $absolutePath = \Illuminate\Support\Facades\Storage::path($relPath);
                        if(!checkModel($media)){
                            $media->setId(\App\Utilities\UuidTools::generateUuid());
                        } else {
                            // Delete previous uploaded file
                            \Illuminate\Support\Facades\Storage::delete($media->getLocalPath());
                        }
                        // Set media info
                        $media->setType($resolvedMimeType);
                        $media->setFilename($fileName);
                        $media->setExtension($file->getClientOriginalExtension());
                        $media->setSize($file->getClientSize());
                        $media->setLocalPath($appRelPath);
                        list($width, $height) = getimagesize($absolutePath);
                        $media->setWidth($width);
                        $media->setHeight($height);
                        $media->setIdObjectRelated($relatedObject->getId());
                        $media->save();
//                        print_r($media);
//                        echo '<img src ="'.asset($appRelPath).'" />';die();
                    }
                }
            }
        }
        return $media;
    }
    
    /**
     * 
     * @param type $fileType
     * @param \App\Models\Establishment $relatedObject
     * @return type
     */
    public static function resolveFilePath($fileType, $relatedObject){
        $path = self::BASE_FILE_PATH;
        $resolved = false;
        switch($fileType){
            case self::FILE_ETS_LOGO:
                if($relatedObject instanceof \App\Models\Establishment){
                    $path .= 'ets/'.$relatedObject->getIdBusinessType().'/'.$relatedObject->getUuid().'/logos';
                    $resolved = true;
                }
                break;
        }
        if(!$resolved){
            $path = null;
        }
        return $path;
    }
    
    /**
     * 
     * @param type $fileType
     * @return \App\Models\EstablishmentMedia
     */
    public static function resolveMediaInstance($fileType){
        $instance = null;
        switch($fileType){
            case self::FILE_ETS_LOGO:
                $instance = new \App\Models\EstablishmentMedia();
                $instance->setPublic(TRUE);
                $instance->setDrive(\App\Models\Media::DRIVE_LOCAL);
            break;
        }
        return $instance;
    }
    
    /**
     * 
     * @param type $mimeType
     * @return type
     */
    public static function resolveFileType($mimeType){
        $fileType = null;
        if(!empty($mimeType)){
            $mimeTypeArray = explode('/', $mimeType);
            $type = $mimeTypeArray[0];
            $ext = null;
            if(isset($mimeTypeArray[1])){
                $ext = $mimeTypeArray[0];
            }
            switch($type){
                case 'image':
                    $fileType = \App\Models\Media::TYPE_IMAGE;
                break;
            }
        }
        return $fileType;
    }
}
