<?php

namespace App\Models;

/**
 * Class Subscription
 */
class Subscription extends Model {

    protected $table = 'subscriptions';
    const TABLENAME  = 'subscriptions';
    
    public $timestamps = true;
    protected $fillable = [
        'priceTTC',
        'start_date',
        'end_date',
        'close_date',
        'id_establishment',
        'id_user',
        'id_bill',
        'id_buyable_item'
    ];
    protected $guarded = [];

    /**
     * @return mixed
     */
    public function getPriceTTC() {
        return $this->priceTTC;
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
    public function getCloseDate() {
        return $this->close_date;
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
    public function getIdUser() {
        return $this->id_user;
    }

    /**
     * @return mixed
     */
    public function getIdBill() {
        return $this->id_bill;
    }

    /**
     * @return mixed
     */
    public function getIdBuyableItem() {
        return $this->id_buyable_item;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setPriceTTC($value) {
        $this->priceTTC = $value;
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
    public function setCloseDate($value) {
        $this->close_date = $value;
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
    public function setIdUser($value) {
        $this->id_user = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdBill($value) {
        $this->id_bill = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdBuyableItem($value) {
        $this->id_buyable_item = $value;
        return $this;
    }

}
