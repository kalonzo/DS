<?php

namespace App\Models;

/**
 * Class PaymentMethod
 */
class PaymentMethod extends Model {

    protected $table = 'payment_methods';
    const TABLENAME = 'payment_methods';

    const METHOD_CB = 1;
    const METHOD_CB_MASTERCARD = 101;
    const METHOD_CB_VISA = 102;
    const METHOD_CB_POSTFINANCE = 103;
    
    const METHOD_30_DAYS_BILL = 2;
    
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 2;
    const STATUS_ONLY_DISPLAY = 3;

    public $timestamps = true;
    public $incrementing = false;
    public static $hasUuid = false;
    protected $fillable = [
        'id',
        'name',
        'status',
        'id_logo'
    ];
    protected $guarded = [];

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
    public function getIdLogo() {
        return $this->id_logo;
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
    public function setIdLogo($value) {
        $this->id_logo = $value;
        return $this;
    }

}
