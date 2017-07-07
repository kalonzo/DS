<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 */
class Payment extends Model
{
    protected $table = 'payments';

    public $timestamps = false;

    protected $fillable = [
        'status',
        'amount',
        'id_user',
        'id_payment_method',
        'id_bill'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return mixed
	 */
	public function getAmount() {
		return $this->amount;
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
	public function getIdPaymentMethod() {
		return $this->id_payment_method;
	}

	/**
	 * @return mixed
	 */
	public function getIdBill() {
		return $this->id_bill;
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
	public function setAmount($value) {
		$this->amount = $value;
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
	public function setIdPaymentMethod($value) {
		$this->id_payment_method = $value;
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



}