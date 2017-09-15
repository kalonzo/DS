<?php

namespace App\Utilities;

/**
 * Description of MediaTools
 *
 * @author Nico
 */
class MediaTools {
    public static function getRandomDsThumbnailPath(){
        return "/img/images_ds/imagen-DS-".rand(1, 20).".jpg";
    }
}
