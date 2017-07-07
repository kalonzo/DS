<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cron
 */
class Cron extends Model
{
    protected $table = 'cron';

    public $timestamps = false;

    protected $fillable = [
        'type',
        'status',
        'frequency',
        'start_time',
        'max_duration'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @return mixed
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return mixed
	 */
	public function getFrequency() {
		return $this->frequency;
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
	public function getMaxDuration() {
		return $this->max_duration;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setType($value) {
		$this->type = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setStatus($value) {
		$this->status = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setFrequency($value) {
		$this->frequency = $value;
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
	public function setMaxDuration($value) {
		$this->max_duration = $value;
		return $this;
	}



}