<?php

namespace App\Models;



/**
 * Class LinkUserInChargeOfEstablishment
 */
class LinkUserInChargeOfEstablishment extends Model
{
    protected $table = 'link_user_in_charge_of_establishment';

    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'id_establishment'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getIdUser() {
		return $this->id_user;
	}

	/**
	 * @return mixed
	 */
	public function getIdEstablishment() {
		return $this->id_establishment;
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
	public function setIdEstablishment($value) {
		$this->id_establishment = $value;
		return $this;
	}



}