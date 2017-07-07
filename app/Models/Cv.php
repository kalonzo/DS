<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cv
 */
class Cv extends Model
{
    protected $table = 'cv';

    public $timestamps = false;

    protected $fillable = [
        'status',
        'civil_status',
        'target_job',
        'id_user'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return mixed
	 */
	public function getCivilStatus() {
		return $this->civil_status;
	}

	/**
	 * @return mixed
	 */
	public function getTargetJob() {
		return $this->target_job;
	}

	/**
	 * @return mixed
	 */
	public function getIdUser() {
		return $this->id_user;
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
	public function setCivilStatus($value) {
		$this->civil_status = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setTargetJob($value) {
		$this->target_job = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdUser($value) {
		$this->id_user = $value;
		return $this;
	}



}