<?php

namespace App\Models;

/**
 * Class BusinessType
 */
class BusinessType extends Model {

    protected $table = 'business_types';

    const TABLENAME = 'business_types';
    const TYPE_BUSINESS_RESTAURANT = 1;

    public $timestamps = true;
    public $incrementing = true;
    public static $hasUuid = false;
    
    protected $fillable = [
        'id_media',
        'label'
    ];
    protected $guarded = [];

    public static function getLabelByType(){
        $labelByType = array();
        $labelByType[self::TYPE_BUSINESS_RESTAURANT] = 'Restaurant';
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

}
