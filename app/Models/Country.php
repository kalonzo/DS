<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 */
class Country extends Model
{
    protected $table = 'countries';

    public $timestamps = false;

    protected $fillable = [
        'iso',
        'label',
        'id_currency'
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



}