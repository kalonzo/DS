<?php

namespace App\Models;



/**
 * Class OpeningHour
 */
class OpeningHour extends Model
{
    protected $table = 'opening_hours';

    public $timestamps = true;

    protected $fillable = [
        'day',
        'start_time',
        'end_time',
        'start_date',
        'end_date',
        'id_establishment'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getDay() {
		return $this->day;
	}

	/**
	 * @return mixed
	 */
	public function getStartTime() {
		return $this->start_time;
	}

	/**
	 * @return mixed
	 */
	public function getEndTime() {
		return $this->end_time;
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
	public function setDay($value) {
		$this->day = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setStartTime($value) {
		$this->start_time = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setEndTime($value) {
		$this->end_time = $value;
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