<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JobReference
 */
class JobReference extends Model
{
    protected $table = 'job_references';

    public $timestamps = false;

    protected $fillable = [
        'lastname',
        'firstname',
        'company',
        'phone_prefix',
        'phone_number',
        'position',
        'cv_id'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getLastname() {
		return $this->lastname;
	}

	/**
	 * @return mixed
	 */
	public function getFirstname() {
		return $this->firstname;
	}

	/**
	 * @return mixed
	 */
	public function getCompany() {
		return $this->company;
	}

	/**
	 * @return mixed
	 */
	public function getPhonePrefix() {
		return $this->phone_prefix;
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
	public function getPosition() {
		return $this->position;
	}

	/**
	 * @return mixed
	 */
	public function getCvId() {
		return $this->cv_id;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setLastname($value) {
		$this->lastname = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setFirstname($value) {
		$this->firstname = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setCompany($value) {
		$this->company = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setPhonePrefix($value) {
		$this->phone_prefix = $value;
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
	public function setPosition($value) {
		$this->position = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setCvId($value) {
		$this->cv_id = $value;
		return $this;
	}



}