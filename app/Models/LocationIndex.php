<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LocationIndex
 */
class LocationIndex extends Model
{
    protected $table = 'location_index';

    public $timestamps = false;

    protected $fillable = [
        'postal_code',
        'city',
        'latitude',
        'longitude',
        'id_country'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getPostalCode() {
		return $this->postal_code;
	}

	/**
	 * @return mixed
	 */
	public function getCity() {
		return $this->city;
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
	public function getLongitude() {
		return $this->longitude;
	}

	/**
	 * @return mixed
	 */
	public function getIdCountry() {
		return $this->id_country;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setPostalCode($value) {
		$this->postal_code = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setCity($value) {
		$this->city = $value;
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
	public function setLongitude($value) {
		$this->longitude = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdCountry($value) {
		$this->id_country = $value;
		return $this;
	}



}