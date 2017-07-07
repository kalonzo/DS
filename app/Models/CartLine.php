<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CartLine
 */
class CartLine extends Model
{
    protected $table = 'cart_lines';

    public $timestamps = false;

    protected $fillable = [
        'designation',
        'qty',
        'unit_price_HT',
        'unit_price_TTC',
        'vat_rate',
        'price_HT',
        'price_TTC',
        'discount_amount',
        'discount_percent',
        'net_price',
        'id_cart',
        'id_buyable_item'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getDesignation() {
		return $this->designation;
	}

	/**
	 * @return mixed
	 */
	public function getQty() {
		return $this->qty;
	}

	/**
	 * @return mixed
	 */
	public function getUnitPriceHT() {
		return $this->unit_price_HT;
	}

	/**
	 * @return mixed
	 */
	public function getUnitPriceTTC() {
		return $this->unit_price_TTC;
	}

	/**
	 * @return mixed
	 */
	public function getVatRate() {
		return $this->vat_rate;
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
	public function getNetPrice() {
		return $this->net_price;
	}

	/**
	 * @return mixed
	 */
	public function getIdCart() {
		return $this->id_cart;
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
	public function setDesignation($value) {
		$this->designation = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setQty($value) {
		$this->qty = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setUnitPriceHT($value) {
		$this->unit_price_HT = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setUnitPriceTTC($value) {
		$this->unit_price_TTC = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setVatRate($value) {
		$this->vat_rate = $value;
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
	public function setNetPrice($value) {
		$this->net_price = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdCart($value) {
		$this->id_cart = $value;
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