<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserFavouriteEstablishment
 */
class UserFavouriteEstablishment extends Model
{
    protected $table = 'user_favourite_establishments';

    public $timestamps = false;

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