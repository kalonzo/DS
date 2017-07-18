<?php
namespace App\Utilities;

/**
 * Description of ArrayTools
 *
 * @author Nico
 */
class ArrayTools {

    public static function objectToArray($object) {
        return json_decode(json_encode($object));
//        $array = null;
//        if (is_object($object)) {
//            $object = get_object_vars($object);
//        }
//        if (is_array($object)) {
//            $array = array_map(function(){}, $object);
//        } else {
//            $array = $object;
//        }
//        return $array;
    }

}
