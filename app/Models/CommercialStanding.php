<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CommercialStanding
 */
class CommercialStanding extends Model
{
    protected $table = 'commercial_standing';

    public $timestamps = false;

    protected $fillable = [
        'status',
        'postal_code',
        'site_section',
        'start_date',
        'end_date',
        'position',
        'id_establishment'
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
	public function getPostalCode() {
		return $this->postal_code;
	}

	/**
	 * @return mixed
	 */
	public function getSiteSection() {
		return $this->site_section;
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
	public function getPosition() {
		return $this->position;
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
	public function setStatus($value) {
		$this->status = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setPostalCode($value) {
		$this->postal_code = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setSiteSection($value) {
		$this->site_section = $value;
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
	public function setPosition($value) {
		$this->position = $value;
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