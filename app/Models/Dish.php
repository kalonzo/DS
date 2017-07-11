<?php

namespace App\Models;



/**
 * Class Dish
 */
class Dish extends Model
{
    protected $table = 'dishes';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'status',
        'price',
        'currency',
        'start_date',
        'end_date',
        'position',
        'id_establishment',
        'id_photo'
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
	public function getDescription() {
		return $this->description;
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
	public function getPrice() {
		return $this->price;
	}

	/**
	 * @return mixed
	 */
	public function getCurrency() {
		return $this->currency;
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
	public function getPosition() {
		return $this->position;
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
	public function getIdPhoto() {
		return $this->id_photo;
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
	public function setDescription($value) {
		$this->description = $value;
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
	public function setPrice($value) {
		$this->price = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setCurrency($value) {
		$this->currency = $value;
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
	public function setPosition($value) {
		$this->position = $value;
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
	public function setIdPhoto($value) {
		$this->id_photo = $value;
		return $this;
	}



}