<?php

namespace App\Models;

/**
 * Class BusinessCategory
 */
class BusinessCategory extends Model {

    protected $table = 'business_categories';

    const TABLENAME = 'business_categories';
    const TYPE_COOKING_TYPE = 1;
    const TYPE_FOOD_SPECIALTY = 2;
    const TYPE_RESTAURANT_AMBIENCE = 3;
    const TYPE_SERVICES = 4;
    
    const STATUS_TO_CHECK = 2;

    public $timestamps = true;
    protected $fillable = [
        'name',
        'type',
        'status'
    ];
    protected $guarded = [];

    public static function getLabelByType(){
        $labelByType = array();
        $labelByType[self::TYPE_COOKING_TYPE] = 'Type de cuisine';
        $labelByType[self::TYPE_FOOD_SPECIALTY] = 'Spécialité';
        $labelByType[self::TYPE_RESTAURANT_AMBIENCE] = 'Cadre et ambiance';
        $labelByType[self::TYPE_SERVICES] = 'Service';
        return $labelByType;
    }
    
    public function establishmentLinks(){
        return $this->hasMany(EstablishmentBusinessCategory::class, 'id_business_category', 'id');
    }
    
    public function establishments(){
        return $this->belongsToMany(Establishment::class, EstablishmentBusinessCategory::TABLENAME, 'id_business_category', 'id_establishment');
    }    
    
    public function delete() {
        $this->establishmentLinks()->delete();
        return parent::delete();
    }
    
    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }
    
    /**
     * @return mixed
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setName($value) {
        $this->name = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setType($value) {
        $this->type = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setStatus($value) {
        $this->status = $value;
        return $this;
    }

}
