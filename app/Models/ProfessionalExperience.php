<?php

namespace App\Models;



/**
 * Class ProfessionalExperience
 */
class ProfessionalExperience extends Model
{
    protected $table = 'professional_experiences';

    public $timestamps = true;

    protected $fillable = [
        'company_name',
        'job',
        'start_date',
        'end_date',
        'id_cv'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getCompanyName() {
		return $this->company_name;
	}

	/**
	 * @return mixed
	 */
	public function getJob() {
		return $this->job;
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
	public function getIdCv() {
		return $this->id_cv;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setCompanyName($value) {
		$this->company_name = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setJob($value) {
		$this->job = $value;
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
	public function setIdCv($value) {
		$this->id_cv = $value;
		return $this;
	}



}