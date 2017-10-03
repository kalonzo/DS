<?php

namespace App\Models;

/**
 * Class JobType
 */
class JobType extends Model {

    protected $table = 'job_types';
    const TABLENAME = 'job_types';
    
    const TYPE_RESTO_CHEF = 1;
    const TYPE_RESTO_STAFF = 2;
    
    public $incrementing = true;
    public static $hasUuid = false;
    public $timestamps = true;
    protected $fillable = [
        'name',
        'id_business_type'
    ];
    protected $guarded = [];

    public static function getLabelByType(){
        $labelByType = array();
        $labelByType[self::TYPE_RESTO_CHEF] = 'Chef de cuisine';
        $labelByType[self::TYPE_RESTO_STAFF] = 'Staff restaurant';
        return $labelByType;
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
    public function getIdBusinessType() {
        return $this->id_business_type;
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
    public function setIdBusinessType($value) {
        $this->id_business_type = $value;
        return $this;
    }

}
