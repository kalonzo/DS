<?php

namespace App\Models;

/**
 * Class Promotion
 */
class Promotion extends Model {

    protected $table = 'promotions';

    const TABLENAME = 'promotions';
    
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 2;

    public $timestamps = true;
    protected $fillable = [
        'name',
        'status',
        'description',
        'start_date',
        'end_date',
        'id_establishment',
        'id_promotion_type'
    ];
    protected $guarded = [];

    /**
     * 
     * @return Establishment
     */
    public function establishment(){
        return $this->hasOne(Establishment::class, 'id', 'id_establishment');
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
    public function getStatus() {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getStartDate() {
        return $this->start_date;
    }

    /**
     * @return mixed
     */
    public function getEndDate() {
        return $this->end_date;
    }

    /**
     * @return mixed
     */
    public function getIdEstablishment() {
        return $this->id_establishment;
    }

    /**
     * @return mixed
     */
    public function getIdPromotionType() {
        return $this->id_promotion_type;
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
    public function setStatus($value) {
        $this->status = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDescription($value) {
        $this->description = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setStartDate($value) {
        $this->start_date = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setEndDate($value) {
        $this->end_date = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdEstablishment($value) {
        $this->id_establishment = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdPromotionType($value) {
        $this->id_promotion_type = $value;
        return $this;
    }

}
