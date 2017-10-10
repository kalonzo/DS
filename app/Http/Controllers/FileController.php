<?php

namespace App\Http\Controllers;

/**
 * Description of FileController
 *
 * @author Nico
 */
class FileController {
    const BASE_FILE_PATH = "";
    
    /**
     * 
     * @param type $formInputFileName
     * @param type $fileType
     * @param \App\Models\Model $relatedObject
     * @param \App\Models\Media $medias
     * @return \App\Models\Media 
     */
    public static function storeFileMultiple($formInputFileName, $fileType, $relatedObject, $medias = null){
        $files = \Illuminate\Support\Facades\Request::file($formInputFileName);
        if(!empty($medias)){
            foreach($medias as $media){
                $media->delete();
            }
        }
        
        $createdMedias = array();
        if(!empty($files)){
            foreach($files as $file){
                if ($file->isValid()) {
                    $path = self::resolveFilePath($fileType, $relatedObject);
                    if($path !== null){
                        // Get infos from request file input
                        $fileMimeType = $file->getMimeType();
                        $resolvedMimeType = self::resolveFileType($fileMimeType);
                        $fileSize = $file->getClientSize();
                        $fileName = self::resolveFileName($fileType, $relatedObject, $file);
                        $fileExtension = $file->getClientOriginalExtension();

                        $media = self::resolveMediaInstance($fileType, $relatedObject);
                        if($media instanceof \App\Models\Media){
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

                                // Set media info
                                $media->setType($resolvedMimeType);
                                $media->setFilename($fileName);
                                $media->setExtension($fileExtension);
                                $media->setSize($fileSize);
                                $media->setLocalPath($appRelPath);
                                list($width, $height) = getimagesize($absolutePath);
                                $media->setWidth($width);
                                $media->setHeight($height);
                                $media->setIdObjectRelated($relatedObject->getId());
                                //$media->setPosition($currentPosition);
                                $media->save();

                                $createdMedias[] = $media;
                            }
                        }
                    }
                }
            }
        }
        return $createdMedias;
    }
    
    /**
     * 
     * @param type $formInputFileName
     * @param type $fileType
     * @param \App\Models\Model $relatedObject
     * @param \App\Models\Media $media
     * @return \App\Models\Media 
     */
    public static function storeFile($formInputFileName, $fileType, $relatedObject, $media = null){
        $originalMedia = null;
        $file = \Illuminate\Support\Facades\Request::file($formInputFileName);
        if(!empty($file)){
            if ($file->isValid()) {
                $hasChanged = true;
                $path = self::resolveFilePath($fileType, $relatedObject);
                
                if($path !== null){
                    // Get infos from request file input
                    $fileMimeType = $file->getMimeType();
                    $resolvedMimeType = self::resolveFileType($fileMimeType);
                    $fileSize = $file->getClientSize();
                    $fileName = self::resolveFileName($fileType, $relatedObject, $file);
                    $fileExtension = $file->getClientOriginalExtension();

                    if(!checkModel($media)){
                        $media = self::resolveMediaInstance($fileType, $relatedObject);
                    } else {
                        // Check if file is different from previous saved media
                        if($media->getExtension() == $fileExtension && $media->getSize() == $fileSize && $media->getType() === $resolvedMimeType){
                            $hasChanged = false;
                        } else {
                            $originalMedia = $media;
                            $media = self::manageReplacingMediaInstance($fileType, $relatedObject, $originalMedia);
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
                            if(checkModel($media)){
                                // Delete previous uploaded file
                                \Illuminate\Support\Facades\Storage::delete($media->getLocalPath());
                            }
                            // Set media info
                            $media->setType($resolvedMimeType);
                            $media->setFilename($fileName);
                            $media->setExtension($fileExtension);
                            $media->setSize($fileSize);
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
        }
        if(checkModel($originalMedia) && $originalMedia->getId() != $media->getId()){
            return $originalMedia;
        } else {
            return $media;
        }
    }
    
    /**
     * 
     * @param type $fileType
     * @param \App\Models\Model $relatedObject
     * @return type
     */
    public static function resolveFilePath($fileType, $relatedObject){
        $path = self::BASE_FILE_PATH;
        $resolved = false;
        switch($fileType){
            case \App\Models\Media::TYPE_USE_ETS_LOGO:
                if($relatedObject instanceof \App\Models\Establishment){
                    $path .= 'ets/'.$relatedObject->getIdBusinessType().'/'.$relatedObject->getUuid().'/logos';
                    $resolved = true;
                }
                break;
            case \App\Models\Media::TYPE_USE_ETS_VIDEO:
                if($relatedObject instanceof \App\Models\Establishment){
                    $path .= 'ets/'.$relatedObject->getIdBusinessType().'/'.$relatedObject->getUuid().'/video';
                    $resolved = true;
                }
                break;
            case \App\Models\Media::TYPE_USE_ETS_HOME_PICS:
                if($relatedObject instanceof \App\Models\Establishment){
                    $path .= 'ets/'.$relatedObject->getIdBusinessType().'/'.$relatedObject->getUuid().'/home_pics';
                    $resolved = true;
                }
                break;
            case \App\Models\Media::TYPE_USE_ETS_GALLERY_ITEM:
                if($relatedObject instanceof \App\Models\Gallery){
                    $ets = $relatedObject->establishment()->first();
                    if(checkModel($ets)){
                        $path .= 'ets/'.$ets->getIdBusinessType().'/'.$ets->getUuid().'/gallery/'.$relatedObject->getUuid();
                        $resolved = true;
                    }
                }
                break;
            case \App\Models\Media::TYPE_USE_ETS_MENU:
                if($relatedObject instanceof \App\Models\Menu){
                    $ets = $relatedObject->establishment()->first();
                    if(checkModel($ets)){
                        $path .= 'ets/'.$ets->getIdBusinessType().'/'.$ets->getUuid().'/menus/'.$relatedObject->getUuid();
                        $resolved = true;
                    }
                }
                break;
            case \App\Models\Media::TYPE_USE_ETS_DISH:
                if($relatedObject instanceof \App\Models\Dish){
                    $ets = $relatedObject->establishment()->first();
                    if(checkModel($ets)){
                        $path .= 'ets/'.$ets->getIdBusinessType().'/'.$ets->getUuid().'/dishes/'.$relatedObject->getUuid();
                        $resolved = true;
                    }
                }
                break;
            case \App\Models\Media::TYPE_USE_ETS_EMPLOYEE:
                if($relatedObject instanceof \App\Models\Employee){
                    $ets = $relatedObject->establishment()->first();
                    if(checkModel($ets)){
                        $path .= 'ets/'.$ets->getIdBusinessType().'/'.$ets->getUuid().'/employees/'.$relatedObject->getUuid();
                        $resolved = true;
                    }
                }
                break;
            case \App\Models\Media::TYPE_USE_ETS_STORY:
                if($relatedObject instanceof \App\Models\EstablishmentHistory){
                    $ets = $relatedObject->establishment()->first();
                    if(checkModel($ets)){
                        $path .= 'ets/'.$ets->getIdBusinessType().'/'.$ets->getUuid().'/stories/'.$relatedObject->getUuid();
                        $resolved = true;
                    }
                }
                break;
            case \App\Models\Media::TYPE_USE_ETS_PROMO:
                if($relatedObject instanceof \App\Models\Promotion){
                    $ets = $relatedObject->establishment()->first();
                    if(checkModel($ets)){
                        $path .= 'ets/'.$ets->getIdBusinessType().'/'.$ets->getUuid().'/promotions/'.$relatedObject->getUuid();
                        $resolved = true;
                    }
                }
                break;
            case \App\Models\Media::TYPE_USE_BUSINESS_TYPE:
                if($relatedObject instanceof \App\Models\BusinessType){
                    $path .= 'business_types/'.$relatedObject->getId().'/';
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
     * @param \App\Models\Model $relatedObject
     * @return \App\Models\EstablishmentMedia
     */
    public static function resolveMediaInstance($fileType, $relatedObject){
        $instance = null;
        switch($fileType){
            case \App\Models\Media::TYPE_USE_ETS_LOGO:
            case \App\Models\Media::TYPE_USE_ETS_VIDEO:
            case \App\Models\Media::TYPE_USE_ETS_HOME_PICS:
            case \App\Models\Media::TYPE_USE_ETS_GALLERY_ITEM:
            case \App\Models\Media::TYPE_USE_ETS_MENU:
            case \App\Models\Media::TYPE_USE_ETS_DISH:
            case \App\Models\Media::TYPE_USE_ETS_EMPLOYEE:
            case \App\Models\Media::TYPE_USE_ETS_STORY:
            case \App\Models\Media::TYPE_USE_ETS_PROMO:
                $instance = new \App\Models\EstablishmentMedia();
                $instance->setId(\App\Utilities\UuidTools::generateUuid());
                $instance->setPublic(TRUE);
                $instance->setDrive(\App\Models\Media::DRIVE_LOCAL);
                $instance->setTypeUse($fileType);
                if(isAdmin()){
                    $instance->setStatus(\App\Models\Media::STATUS_VALIDATED);
                } else {
                    $instance->setStatus(\App\Models\Media::STATUS_PENDING);
                }
                if($relatedObject instanceof \App\Models\Gallery){
                    $instance->setIdGallery($relatedObject->getId());
                }
            break;
            case \App\Models\Media::TYPE_USE_BUSINESS_TYPE:
                $instance = new \App\Models\EstablishmentMedia();
                $instance->setId(\App\Utilities\UuidTools::generateUuid());
                $instance->setPublic(TRUE);
                $instance->setDrive(\App\Models\Media::DRIVE_LOCAL);
                $instance->setTypeUse($fileType);
                $instance->setStatus(\App\Models\Media::STATUS_VALIDATED);
            break;
        }
        if($relatedObject instanceof \App\Models\Interfaces\EstablishmentBoundable){
            $instance->setIdEstablishment($relatedObject->getIdEstablishment());
        } else if($relatedObject instanceof \App\Models\Establishment){
            $instance->setIdEstablishment($relatedObject->getId());
        }
        return $instance;
    }
    
    /**
     * 
     * @param type $fileType
     * @param \App\Models\Model $relatedObject
     * @param \App\Models\EstablishmentMedia $originalMedia
     * @return \App\Models\EstablishmentMedia
     */
    public static function manageReplacingMediaInstance($fileType, $relatedObject, $originalMedia){
        $instance = null;
        
        if(isAdmin()){
            $instance = $originalMedia;
        } else {
            switch($fileType){
                case \App\Models\Media::TYPE_USE_ETS_LOGO:
                case \App\Models\Media::TYPE_USE_ETS_VIDEO:
                    if($originalMedia->getStatus() === \App\Models\Media::STATUS_VALIDATED){
                        $instance = self::resolveMediaInstance($fileType, $relatedObject);
                        $instance->setIdOriginalMedia($originalMedia->getId());

                        if(checkModelId($originalMedia->getIdDraftMedia())){
                            $draftMedia = $originalMedia->mediaDraft()->first();
                            if(checkModel($draftMedia)){
                                $draftMedia->setIdEstablishment(0);
                                $draftMedia->delete();
                            }
                        }
                        $originalMedia->setIdDraftMedia($instance->getId());
                        $originalMedia->save();
                    }
                    break;
                default :
                    $instance = $originalMedia;
                    break;
            }
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
                case 'video':
                    $fileType = \App\Models\Media::TYPE_VIDEO;
                break;
                case 'application':
                    $fileType = \App\Models\Media::TYPE_APPLICATION;
                break;
                case 'text':
                    $fileType = \App\Models\Media::TYPE_TEXT;
                break;
            }
        }
        return $fileType;
    }
    
    /**
     * 
     * @param type $fileType
     * @param \App\Models\Model $relatedObject
     * @param \Illuminate\Http\UploadedFile $file
     * @return type
     */
    public static function resolveFileName($fileType, $relatedObject, $file){
        $filename = null;
        switch($fileType){
            default :
                $filename = $file->getClientOriginalName();
                break;
            case \App\Models\Media::TYPE_USE_ETS_MENU:
                if($relatedObject instanceof \App\Models\Menu){
                    $filename = $relatedObject->getName();
                }
                break;
        }
        return $filename;
    }
}
