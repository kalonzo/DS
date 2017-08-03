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