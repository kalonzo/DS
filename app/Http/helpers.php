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

function checkFlow($flowSource, $flowIndexes){
    $flowValid = false;
    if(!isset($flowSource)){
        $flowValid = false;
        return $flowValid;
    } else if(empty($flowSource)){
        $flowValid = false;
        return $flowValid;
    }
    if(!is_array($flowIndexes)){
        $flowIndexes = array($flowIndexes);
    }
    foreach($flowIndexes as $flowIndex){
        if(isset($flowSource[$flowIndex]) && !empty($flowSource[$flowIndex])){
            $flowValid = true;
            return $flowValid;
        }
    }
    return $flowValid;
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
function getMediaConfigForInputFile($medias, $jsonEncoded = true, $allowRemove = true){
    $mediaConfig = array();
    if($medias instanceof App\Models\Media){
        $medias = array($medias);
    }
    if(!empty($medias)){
        foreach($medias as $media){
            if($media instanceof App\Models\Media){
                $instanceConfig = array(
                    'caption' => $media->getFilename(),
                    'size' => $media->getSize(),
                    'key' => $media->getUuid(),
                );
                if($allowRemove){
                    $instanceConfig['url'] = '/delete/'.$media::TABLENAME.'/'.$media->getUuid();
                }
                if(!empty($media->getType())){
                    switch($media->getType()){
                        case \App\Models\Media::TYPE_IMAGE:
                        case \App\Models\Media::TYPE_VIDEO:
                            $instanceConfig['type'] = $media->getTypeLabel();
                            $instanceConfig['filetype'] = $media->getMimeType();
                            break;
                        default :
                            switch($media->getExtension()){
                                case 'pdf' :
                                    $instanceConfig['type'] = $media->getExtension();
                                    $instanceConfig['filetype'] = $media->getMimeType();
                                    break;
                                default :
                                    $instanceConfig['type'] = 'other';
                                    break;
                            }
                            break;
            }
                }
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

/**
 * 
 * @param type $price
 * @param type $currency
 * @param type $formatConst
 * @param type $locale
 * @return type
 */
function formatPrice($price, $currency = null, $formatConst = null, $locale = null){
    $formattedPrice = $price;
    if(empty($locale)){
        $locale = Illuminate\Support\Facades\App::getLocale();
    }
    if(empty($formatConst)){
        $formatConst = NumberFormatter::CURRENCY;
    }
    if(!empty($currency)){
        $kernelDSPriceFormatter = new NumberFormatter($locale, $formatConst);
        $formattedPrice = $kernelDSPriceFormatter->formatCurrency($price, $currency);
    } else {
        $kernelDSPriceFormatter = new NumberFormatter($locale, NumberFormatter::SCIENTIFIC);
        $formattedPrice = $kernelDSPriceFormatter->format($price);
    }
    return $formattedPrice;
}

function formatDate($datetime, $dateFormat = IntlDateFormatter::GREGORIAN, $timeFormat = IntlDateFormatter::NONE){
    if(is_string($datetime)){
        $datetime = new DateTime($datetime);
    }
    $intlDateFormatter = new IntlDateFormatter(\Illuminate\Support\Facades\App::getLocale(), $dateFormat, $timeFormat);
    return $intlDateFormatter->format($datetime);
}

function checkRight($action = null){
    return \App\Utilities\RightGranter::getInstance()->isAllowedTo($action);
}

function isAdmin(){
    $isAdmin = false;
    $user = \Illuminate\Support\Facades\Auth::user();
    if(checkModel($user) && $user->getType() === App\Models\User::TYPE_USER_ADMIN_PRO){
        $isAdmin = true;
    }
    return $isAdmin;
}

function getCurrentEstablishment(){
    $currentEstablishment = null;
    $user = \Illuminate\Support\Facades\Auth::user();
    if(checkModel($user) && $user->getType() === App\Models\User::TYPE_USER_PRO){
        $currentEstablishment = $user->establishmentsOwned()->first();
    }
    return $currentEstablishment;
}

function envDev(){
    $envDev = false;
    if(env('APP_ENV') === 'dev' || env('APP_ENV') === 'local'){
        $envDev = true;
    }
    return $envDev;
}