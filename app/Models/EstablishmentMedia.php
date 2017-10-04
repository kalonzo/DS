<?php

namespace App\Models;



/**
 * Class EstablishmentMedia
 */
class EstablishmentMedia extends Media
{
    protected $table = 'establishment_medias';
    const TABLENAME = 'establishment_medias';

    public static function getLabelByTypeUse(){
        $labelByType = array();
        $labelByType[self::TYPE_USE_ETS_LOGO] = 'Logo établissement';
        $labelByType[self::TYPE_USE_ETS_HOME_PICS] = "Image d'accueil";
        $labelByType[self::TYPE_USE_ETS_GALLERY_ITEM] = 'Image de galerie';
        $labelByType[self::TYPE_USE_ETS_MENU] = 'Menu';
        $labelByType[self::TYPE_USE_ETS_DISH] = 'Assiette';
        $labelByType[self::TYPE_USE_ETS_EMPLOYEE] = 'Photo employé';
        $labelByType[self::TYPE_USE_ETS_STORY] = 'Image histoire';
        $labelByType[self::TYPE_USE_ETS_VIDEO] = 'Vidéo établissement';
        $labelByType[self::TYPE_USE_ETS_PROMO] = 'Image promotion';
        $labelByType[self::TYPE_USE_ETS_EVENT] = 'Image événement';
        return $labelByType;
    }
    
    public static function getLabelFromTypeUse($type){
        $businessLabel = 'Type non défini';
        $businessTypeLabels = self::getLabelByTypeUse();
        if(isset($businessTypeLabels[$type])){
            $businessLabel = $businessTypeLabels[$type];
        }
        return $businessLabel;
    }
    
    function getIdEstablishment() {
        return $this->id_establishment;
    }

    function setIdEstablishment($id_establishment) {
        $this->id_establishment = $id_establishment;
    }
}