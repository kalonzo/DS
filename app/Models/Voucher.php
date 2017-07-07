<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Voucher
 */
class Voucher extends Model
{
    protected $table = 'vouchers';

    public $timestamps = false;

    protected $fillable = [
        'status',
        'priceTTC',
        'end_date',
        'id_establishment',
        'id_buyable_item',
        'id_bill',
        'id_user',
        'id_currency'
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
	public function getPriceTTC() {
		return $this->priceTTC;
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
	public function getIdBuyableItem() {
		return $this->id_buyable_item;
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
	public function getIdUser() {
		return $this->id_user;
	}

	/**
	 * @return mixed
	 */
	public function getIdCurrency() {
		return $this->id_currency;
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
	public function setPriceTTC($value) {
		$this->priceTTC = $value;
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
	public function setIdBuyableItem($value) {
		$this->id_buyable_item = $value;
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
	public function setIdUser($value) {
		$this->id_user = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdCurrency($value) {
		$this->id_currency = $value;
		return $this;
	}



}