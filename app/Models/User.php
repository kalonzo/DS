<?php

namespace App\Models;



/**
 * Class Usere
 */
class User extends Model
{
    protected $table = 'users';

    public $timestamps = true;
    
    const TYPE_USER_ADMIN_PRO = 1;
    const TYPE_USER = 2;
    const TYPE_GENDER_WOMAN = 3;
    const TYPE_GENDER_MAN = 4;
    const TYPE_GENDER_SOCITY = 5;

    protected $fillable = [
        'status',
        'name',
        'type',
        'gender',
        'lastname',
        'firstname',
        'email',
        'password',
        'is_connected',
        'id_address',
        'id_inbox',
        'longitude',
        'latitude',
        'id_photo',
        'id_company'
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
	public function getName() {
		return $this->name;
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
	public function getGender() {
		return $this->gender;
	}

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
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @return mixed
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @return mixed
	 */
	public function getIsConnected() {
		return $this->is_connected;
	}

	/**
	 * @return mixed
	 */
	public function getIdAddress() {
		return $this->id_address;
	}

	/**
	 * @return mixed
	 */
	public function getIdInbox() {
		return $this->id_inbox;
	}

	/**
	 * @return mixed
	 */
	public function getLongitude() {
		return $this->longitude;
	}

	/**
	 * @return mixed
	 */
	public function getLatitude() {
		return $this->latitude;
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
	public function getIdCompany() {
		return $this->id_company;
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
	public function setName($value) {
		$this->name = $value;
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
	public function setGender($value) {
		$this->gender = $value;
		return $this;
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
	public function setEmail($value) {
		$this->email = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setPassword($value) {
		$this->password = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIsConnected($value) {
		$this->is_connected = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdAddress($value) {
		$this->id_address = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdInbox($value) {
		$this->id_inbox = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setLongitude($value) {
		$this->longitude = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setLatitude($value) {
		$this->latitude = $value;
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
	public function setIdCompany($value) {
		$this->id_company = $value;
		return $this;
	}



}