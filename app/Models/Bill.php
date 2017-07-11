<?php

namespace App\Models;



/**
 * Class Bill
 */
class Bill extends Model
{
    protected $table = 'bills';

    public $timestamps = true;

    protected $fillable = [
        'title',
        'name',
        'prename',
        'company_name',
        'pro_phone',
        'end_date',
        'start_date',
        'phone_number',
        'email',
        'id_condition',
        'id_user',
        'id_cart',
        'id_contract'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getPrename() {
		return $this->prename;
	}

	/**
	 * @return mixed
	 */
	public function getCompanyName() {
		return $this->company_name;
	}

	/**
	 * @return mixed
	 */
	public function getProPhone() {
		return $this->pro_phone;
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
	public function getStartDate() {
		return $this->start_date;
	}

	/**
	 * @return mixed
	 */
	public function getPhoneNumber() {
		return $this->phone_number;
	}

	/**
	 * @return mixed
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @return mixed
	 */
	public function getIdCondition() {
		return $this->id_condition;
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
	public function getIdCart() {
		return $this->id_cart;
	}

	/**
	 * @return mixed
	 */
	public function getIdContract() {
		return $this->id_contract;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setTitle($value) {
		$this->title = $value;
		return $this;
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
	public function setPrename($value) {
		$this->prename = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setCompanyName($value) {
		$this->company_name = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setProPhone($value) {
		$this->pro_phone = $value;
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
	public function setStartDate($value) {
		$this->start_date = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setPhoneNumber($value) {
		$this->phone_number = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setEmail($value) {
		$this->email = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdCondition($value) {
		$this->id_condition = $value;
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
	public function setIdCart($value) {
		$this->id_cart = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdContract($value) {
		$this->id_contract = $value;
		return $this;
	}



}