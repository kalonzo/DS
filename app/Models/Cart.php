<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cart
 */
class Cart extends Model
{
    protected $table = 'carts';

    public $timestamps = false;

    protected $fillable = [
        'status',
        'price_HT',
        'price_TTC',
        'vat_amount',
        'discount_amount',
        'discount_percent',
        'shipping_amount',
        'total_price'
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
	public function getPriceHT() {
		return $this->price_HT;
	}

	/**
	 * @return mixed
	 */
	public function getPriceTTC() {
		return $this->price_TTC;
	}

	/**
	 * @return mixed
	 */
	public function getVatAmount() {
		return $this->vat_amount;
	}

	/**
	 * @return mixed
	 */
	public function getDiscountAmount() {
		return $this->discount_amount;
	}

	/**
	 * @return mixed
	 */
	public function getDiscountPercent() {
		return $this->discount_percent;
	}

	/**
	 * @return mixed
	 */
	public function getShippingAmount() {
		return $this->shipping_amount;
	}

	/**
	 * @return mixed
	 */
	public function getTotalPrice() {
		return $this->total_price;
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
	public function setPriceHT($value) {
		$this->price_HT = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setPriceTTC($value) {
		$this->price_TTC = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setVatAmount($value) {
		$this->vat_amount = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setDiscountAmount($value) {
		$this->discount_amount = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setDiscountPercent($value) {
		$this->discount_percent = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setShippingAmount($value) {
		$this->shipping_amount = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setTotalPrice($value) {
		$this->total_price = $value;
		return $this;
	}



}