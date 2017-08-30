<?php

function checkModel($model, $dbSync = true){
    $valid = false;
    if($model instanceof \Illuminate\Database\Eloquent\Model && objectHasTrait($model, 'App\Models\ExtendModelTrait')){
        if(!$dbSync || $model->exists){
            $valid = true;
        }
    }
    return $valid;
}

function checkModelId($id){
    $valid = false;
    if(!empty($id)){
        $valid = true;
    }
    return $valid;
}

function checkHexUuid($uuid){
    return preg_match('/^[0-9a-f]{8}([0-9a-f]{4}){3}[0-9a-f]{12}$/', $uuid);
}

function isBinary($str) {
    return preg_match('~[^\x20-\x7E\t\r\n]~', $str) > 0;
}

function str_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = mb_strpos($string, $start, 0, 'UTF-8');
    if ($ini == 0) return '';
    $ini += mb_strlen($start, 'UTF-8');
    $len = mb_strpos($string, $end, $ini, 'UTF-8') - $ini;
    return mb_substr($string, $ini, $len, 'UTF-8');
}

function objectHasTrait($obj, $trait){
    $used = class_uses($obj);
    if (!isset($used[$trait])) {
        $parents = class_parents($obj);
        while (!isset($used[$trait]) && $parents) {
            $used = class_uses(array_pop($parents));
        }
    }
    return isset($used[$trait]);
}

function getImageWidth($filePath){
    $width = null;
    if(!empty($filePath) && file_exists($filePath)){
        $dim = getimagesize($filePath);
        if(is_array($dim) && isset($dim[0])){
            $width = $dim[0];
        }
    }
    return $width;
}

function getImageHeight($filePath){
    $height = null;
    if(!empty($filePath) && file_exists($filePath)){
        $dim = getimagesize($filePath);
        if(is_array($dim) && isset($dim[1])){
            $height = $dim[1];
        }
    }
    return $height;
}

/**
 * 
 * @param App\Models\Media $medias
 */
function getMediaConfigForInputFile($medias, $jsonEncoded = true){
    $mediaConfig = array();
    if($medias instanceof App\Models\Media){
        $medias = array($medias);
    }
    if(!empty($medias)){
        foreach($medias as $media){
            $instanceConfig = array(
                'caption' => $media->getFilename(),
                'size' => $media->getSize(),
                'key' => $media->getUuid(),
            );
            if($media instanceof App\Models\Media){
                $instanceConfig['url'] = '/delete/'.$media::TABLENAME.'/'.$media->getUuid();
            }
            $mediaConfig[] = $instanceConfig;
        }
    }
    if($jsonEncoded){
        return json_encode($mediaConfig);
    } else {
        return $mediaConfig;
    }
}

/**
 * 
 * @param App\Models\Media $medias
 */
function getMediaUrlForInputFile($medias, $jsonEncoded = true){
    $mediaUrls = array();
    if($medias instanceof App\Models\Media){
        $medias = array($medias);
    }
    if(!empty($medias)){
        foreach($medias as $media){
            $mediaUrls[] = asset($media->getLocalPath());
        }
    }
    if($jsonEncoded){
        return json_encode($mediaUrls);
    } else {
        return $mediaUrls;
    }
}

function formatPrice($price, $currency = null){
    $kernelDSPriceFormatter = new NumberFormatter(Illuminate\Support\Facades\App::getLocale(), NumberFormatter::CURRENCY);
    $formattedPrice = $kernelDSPriceFormatter->formatCurrency($price, $currency);
    return $formattedPrice;
}