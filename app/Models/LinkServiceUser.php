<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LinkServiceUser
 */
class LinkServiceUser extends Model
{
    protected $table = 'link_service_user';

    public $timestamps = false;

    protected $fillable = [
        'id_service',
        'id_user'
    ];

    protected $guarded = [];

    
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