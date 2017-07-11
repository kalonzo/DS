<?php

namespace App\Models;



/**
 * Class GeographicalZonesCoordinateBorder
 */
class GeographicalZonesCoordinateBorder extends Model
{
    protected $table = 'geographical_zones_coordinate_border';

    public $timestamps = true;

    protected $fillable = [
        'latitude',
        'longitude',
        'id_geographical_zone'
    ];

    protected $guarded = [];

    
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
	public function getIdGeographicalZone() {
		return $this->id_geographical_zone;
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
	public function setIdGeographicalZone($value) {
		$this->id_geographical_zone = $value;
		return $this;
	}



}