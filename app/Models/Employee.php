<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Employee
 */
class Employee extends Model
{
    protected $table = 'employees';

    public $timestamps = false;

    protected $fillable = [
        'lastname',
        'firstname',
        'status',
        'id_photo',
        'position',
        'id_establishment',
        'id_job_type'
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
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return mixed
	 */
	public function getIdPhoto() {
		return $this->id_photo;
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
	public function getIdJobType() {
		return $this->id_job_type;
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
	public function setStatus($value) {
		$this->status = $value;
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
	public function setIdJobType($value) {
		$this->id_job_type = $value;
		return $this;
	}



}