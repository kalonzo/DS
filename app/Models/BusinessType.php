<?php

namespace App\Models;

/**
 * Class BusinessType
 */
class BusinessType extends Model {

    protected $table = 'business_types';
    const TABLENAME = 'business_types';
    
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 2;
    
    const TYPE_BUSINESS_RESTAURANT = 1;
    const TYPE_BUSINESS_HOTEL = 2;
    const TYPE_BUSINESS_WINEMAKER = 3;
    const TYPE_BUSINESS_BAKER = 4;
    const TYPE_BUSINESS_CHOCOLATE = 5;
    const TYPE_BUSINESS_HOME_CHEF = 6;
    const TYPE_BUSINESS_TAKEAWAY = 7;
    const TYPE_BUSINESS_BAR = 8;
    const TYPE_BUSINESS_SPA = 9;
    const TYPE_BUSINESS_EVENTS = 10;
    const TYPE_BUSINESS_BEVERAGE = 11;
    const TYPE_BUSINESS_CONSULTING = 12;
    const TYPE_BUSINESS_EQUIPMENT = 13;
    const TYPE_BUSINESS_GROCERY = 14;
    const TYPE_BUSINESS_FURNITURE = 15;
    const TYPE_BUSINESS_RECRUITMENT = 16;
    const TYPE_BUSINESS_SERVICES = 17;
    const TYPE_BUSINESS_OFFICE_SUPPLY = 18;
    const TYPE_BUSINESS_TABLE_ART = 19;

    public $timestamps = true;
    public $incrementing = true;
    public static $hasUuid = false;
    
    protected $fillable = [
        'id_media',
        'label',
        'status'
    ];
    protected $guarded = [];

    public static function getLabelByType(){
        $labelByType = array();
        $labelByType[self::TYPE_BUSINESS_RESTAURANT] = 'Restaurant';
        $labelByType[self::TYPE_BUSINESS_HOTEL] = 'Hôtel';
        $labelByType[self::TYPE_BUSINESS_WINEMAKER] = 'Vigneron';
        $labelByType[self::TYPE_BUSINESS_BAKER] = 'Boulangerie';
        $labelByType[self::TYPE_BUSINESS_CHOCOLATE] = 'Chocolaterie';
        $labelByType[self::TYPE_BUSINESS_HOME_CHEF] = 'Chef à domicile';
        $labelByType[self::TYPE_BUSINESS_TAKEAWAY] = 'Traiteur';
        $labelByType[self::TYPE_BUSINESS_BAR] = 'Bar';
        $labelByType[self::TYPE_BUSINESS_SPA] = 'Spa';
        $labelByType[self::TYPE_BUSINESS_EVENTS] = 'Evénementiel';
        $labelByType[self::TYPE_BUSINESS_BEVERAGE] = 'Boissons';
        $labelByType[self::TYPE_BUSINESS_CONSULTING] = 'Consultants';
        $labelByType[self::TYPE_BUSINESS_EQUIPMENT] = 'Equipements';
        $labelByType[self::TYPE_BUSINESS_GROCERY] = 'Produits';
        $labelByType[self::TYPE_BUSINESS_FURNITURE] = 'Mobilier';
        $labelByType[self::TYPE_BUSINESS_RECRUITMENT] = 'Recrutement';
        $labelByType[self::TYPE_BUSINESS_SERVICES] = 'Services';
        $labelByType[self::TYPE_BUSINESS_OFFICE_SUPPLY] = 'Fournitures';
        $labelByType[self::TYPE_BUSINESS_TABLE_ART] = "L'art de la table";
        return $labelByType;
    }
    
    public static function getLabelFromType($type){
        $businessLabel = 'Type non défini';
        $businessTypeLabels = self::getLabelByType();
        if(isset($businessTypeLabels[$type])){
            $businessLabel = $businessTypeLabels[$type];
        }
        return $businessLabel;
    }
    
    /**
     * @return mixed
     */
    public function getIdMedia() {
        return $this->id_media;
    }

    /**
     * @return mixed
     */
    public function getLabel() {
        return $this->label;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdMedia($value) {
        $this->id_media = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setLabel($value) {
        $this->label = $value;
        return $this;
    }

    function getStatus() {
        return $this->status;
    }

    function setStatus($status) {
        $this->status = $status;
    }


}
