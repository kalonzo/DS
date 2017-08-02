<?php

namespace App\Models;



/**
 * Class Country
 */
class Country extends Model
{
    protected $table = 'countries';
    const TABLENAME = 'countries';

    public $timestamps = true;

    protected $fillable = [
        'iso',
        'label',
        'id_currency',
        'iso3',
        'prefix'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getIso() {
		return $this->iso;
	}

	/**
	 * @return mixed
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @return mixed
	 */
	public function getIdCurrency() {
		return $this->id_currency;
	}
        
	/**
	 * @return mixed
	 */
	public function getIso3() {
		return $this->iso3;
	}
        
	/**
	 * @return mixed
	 */
	public function getPrefix() {
		return $this->prefix;
	}

    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setIso($value) {
		$this->iso = $value;
		return $this;
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
	public function setIdCurrency($value) {
		$this->id_currency = $value;
		return $this;
	}
        
 	/**
	 * @param $value
	 * @return $this
	 */
	public function setIso3($value) {
		$this->iso3 = $value;
		return $this;
	}

 	/**
	 * @param $value
	 * @return $this
	 */
	public function setPrefix($value) {
		$this->prefix = $value;
		return $this;
	}

}