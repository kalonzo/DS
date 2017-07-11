<?php

namespace App\Models;



/**
 * Class Contract
 */
class Contract extends Model
{
    protected $table = 'contracts';

    public $timestamps = true;

    protected $fillable = [
        'number',
        'start_date',
        'end_date',
        'id_user_in_charge',
        'id_establishment_customer',
        'id_user_customer'
    ];

    protected $guarded = [];

    
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



}