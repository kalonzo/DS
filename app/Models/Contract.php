<?php

namespace App\Models;

/**
 * Class Contract
 */
class Contract extends Model {

    protected $table = 'contracts';

    const TABLENAME = 'contracts';

    const STATUS_ACTIVE = 1;
    const STATUS_CANCELED = 2;
    const STATUS_OVER = 3;
    
    public $timestamps = true;
    protected $fillable = [
        'status',
        'number',
        'start_date',
        'end_date',
        'id_user_in_charge',
        'id_establishment_customer',
        'id_user_customer',
        'type_business'
    ];
    protected $guarded = [];

    public function generateNumber($save = true){
        $date = new \DateTime();
        $number = $date->format('YmdHis').rand(10, 99);
        $this->setNumber($number);
        if($save){
            $this->save();
        }
    }
    /**
     * @return mixed
     */
    public function getNumber() {
        return $this->number;
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
    public function getIdUserInCharge() {
        return $this->id_user_in_charge;
    }

    /**
     * @return mixed
     */
    public function getIdEstablishmentCustomer() {
        return $this->id_establishment_customer;
    }

    /**
     * @return mixed
     */
    public function getIdUserCustomer() {
        return $this->id_user_customer;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setNumber($value) {
        $this->number = $value;
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
    public function setIdUserInCharge($value) {
        $this->id_user_in_charge = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdEstablishmentCustomer($value) {
        $this->id_establishment_customer = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdUserCustomer($value) {
        $this->id_user_customer = $value;
        return $this;
    }

    function getTypeBusiness() {
        return $this->type_business;
    }

    function setTypeBusiness($type_business) {
        $this->type_business = $type_business;
    }


}
