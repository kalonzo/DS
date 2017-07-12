<?php
namespace App\Utilities;

/**
 * Description of ArrayTools
 *
 * @author Nico
 */
class ArrayTools {

    public static function objectToArray($object) {
        var_dump($object);
        $array = null;
        if (is_object($object)) {
            $object = get_object_vars($object);
        }
        var_dump($object);
        if (is_array($object)) {
            $array = array_map(__FUNCTION__, $object);
        } else {
            $array = $object;
        }
        return $array;
    }

}
