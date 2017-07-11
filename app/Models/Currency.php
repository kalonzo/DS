<?php

namespace App\Models;



/**
 * Class Currency
 */
class Currency extends Model
{
    protected $table = 'currencies';

    public $timestamps = true;

    protected $fillable = [
        'symbol',
        'short_label',
        'label',
        'rate'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getSymbol() {
		return $this->symbol;
	}

	/**
	 * @return mixed
	 */
	public function getShortLabel() {
		return $this->short_label;
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
	public function getRate() {
		return $this->rate;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setSymbol($value) {
		$this->symbol = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setShortLabel($value) {
		$this->short_label = $value;
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
	public function setRate($value) {
		$this->rate = $value;
		return $this;
	}



}