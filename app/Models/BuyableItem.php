<?php

namespace App\Models;



/**
 * Class BuyableItem
 */
class BuyableItem extends Model
{
    protected $table = 'buyable_items';

    public $timestamps = true;

    protected $fillable = [
        'designation',
        'status',
        'type',
        'unit_price_HT',
        'unit_price_TTC',
        'vat_rate',
        'price_HT',
        'price_TTC',
        'discount_amount',
        'discount_percent',
        'net_price',
        'id_object',
        'type_object',
        'description',
        'start_date',
        'end_date',
        'id_business_type',
        'id_geographical_zone'
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
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return mixed
	 */
	public function getType() {
		return $this->type;
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
	public function getIdObject() {
		return $this->id_object;
	}

	/**
	 * @return mixed
	 */
	public function getTypeObject() {
		return $this->type_object;
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
	public function getIdBusinessType() {
		return $this->id_business_type;
	}

	/**
	 * @return mixed
	 */
	public function getIdGeographicalZone() {
		return $this->id_geographical_zone;
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
	public function setStatus($value) {
		$this->status = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setType($value) {
		$this->type = $value;
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
	public function setIdObject($value) {
		$this->id_object = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setTypeObject($value) {
		$this->type_object = $value;
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
	public function setIdBusinessType($value) {
		$this->id_business_type = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdGeographicalZone($value) {
		$this->id_geographical_zone = $value;
		return $this;
	}



}