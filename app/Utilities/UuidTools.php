<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utilities;

/**
 * Description of UuidTools
 *
 * @author Nico
 */
class UuidTools {
    public static function getUuid($binaryId){
        return bin2hex($binaryId);
    }
    
    public static function generateUuid(){
        return hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
    }
}
