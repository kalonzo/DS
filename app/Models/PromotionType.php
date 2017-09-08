<?php

namespace App\Models;

/**
 * Class PromotionType
 */
class PromotionType extends Model {

    protected $table = 'promotion_types';

    const TABLENAME = 'promotion_types';
    
    const TYPE_DISCOUNT_PERCENT = 1;
    const TYPE_DISCOUNT_AMOUNT = 2;

    public $timestamps = true;
    public $incrementing = true;
    public static $hasUuid = false;
    
    protected $fillable = [
        'name'
    ];
    protected $guarded = [];

    public static function getLabelByType(){
        $labelByType = array();
        $labelByType[self::TYPE_DISCOUNT_PERCENT] = 'Rabais avec pourcentage';
        $labelByType[self::TYPE_DISCOUNT_AMOUNT] = 'Rabais avec montant';
        return $labelByType;
    }
    
    public static function getLabelFromType($type){
        $typeLabel = 'Type non défini';
        $promoTypeLabels = self::getLabelByType();
        if(isset($promoTypeLabels[$type])){
            $typeLabel = $promoTypeLabels[$type];
        }
        return $typeLabel;
    }
    
    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setName($value) {
        $this->name = $value;
        return $this;
    }

}
