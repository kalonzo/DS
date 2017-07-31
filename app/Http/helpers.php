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