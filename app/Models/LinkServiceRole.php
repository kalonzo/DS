<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LinkServiceRole
 */
class LinkServiceRole extends Model
{
    protected $table = 'link_service_role';

    public $timestamps = false;

    protected $fillable = [
        'id_role',
        'id_service',
        'id_user'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getIdRole() {
		return $this->id_role;
	}

	/**
	 * @return mixed
	 */
	public function getIdService() {
		return $this->id_service;
	}

	/**
	 * @return mixed
	 */
	public function getIdUser() {
		return $this->id_user;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdRole($value) {
		$this->id_role = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdService($value) {
		$this->id_service = $value;
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



}