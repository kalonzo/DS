<?php

function checkModel($model, $dbSync = true){
    $valid = false;
    if($model instanceof App\Models\Model){
        if(!$dbSync || $model->exists()){
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