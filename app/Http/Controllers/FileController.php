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
     */
    public static function storeFile($formInputFileName, $fileType, $relatedObject){
        $media = null;
        $file = \Illuminate\Support\Facades\Request::file($formInputFileName);
        if(!empty($file)){
            if ($file->isValid()) {
                $path = self::resolveFilePath($fileType, $relatedObject);
                $media = self::resolveMediaInstance($fileType);
                if($media instanceof \App\Models\Media){
                    $options = array();
                    if($media->getPublic() && $media->getDrive(\App\Models\Media::DRIVE_LOCAL)){
                        $options = 'public';
                    }
                    
                    $relPath = $file->storePublicly($path, $options);
                    if($relPath !== false){
                        if($media->getPublic()){
                            $relPath = 'public/'.$relPath;
                        }
                        $appRelPath = \Illuminate\Support\Facades\Storage::url($relPath);
                        $absolutePath = \Illuminate\Support\Facades\Storage::path($relPath);
                        
                        $media->setId(\App\Utilities\UuidTools::generateUuid());
                        $media->setType(\App\Models\Media::TYPE_IMAGE);
                        $media->setFilename($file->getFilename());
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
}
