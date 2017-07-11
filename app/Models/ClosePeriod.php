<?php

namespace App\Models;

/**
 * Class ClosePeriod
 */
class ClosePeriod extends Model
{
    protected $table = 'close_periods';

    public $timestamps = true;

    protected $fillable = [
        'label',
        'start_date',
        'end_date',
        'id_establishment'
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
	public function getStartDate() {
		return $this->start_date;
	}

	/**
	 * @return mixed
	 */
	public function getEndDate() {
		return $this->end_date;
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
	public function setLabel($value) {
		$this->label = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setStartDate($value) {
		$this->start_date = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setEndDate($value) {
		$this->end_date = $value;
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