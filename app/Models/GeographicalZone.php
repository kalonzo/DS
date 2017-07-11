<?php

namespace App\Models;



/**
 * Class GeographicalZone
 */
class GeographicalZone extends Model
{
    protected $table = 'geographical_zones';

    public $timestamps = true;

    protected $fillable = [
        'label',
        'id_country'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getLabel() {
		return $this->label;
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
	public function setLabel($value) {
		$this->label = $value;
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