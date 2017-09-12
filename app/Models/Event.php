<?php

namespace App\Models;



/**
 * Class Event
 */
class Event extends Model
{
    protected $table = 'events';
    
    const TABLENAME = 'events';
    
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 2;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'status',
        'description',
        'start_date',
        'end_date',
        'type_event',
        'id_establishment',
        'id_event_type'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
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
	public function getDescription() {
		return $this->description;
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
	public function getTypeEvent() {
		return $this->type_event;
	}

	/**
	 * @return mixed
	 */
	public function getIdEstablishment() {
		return $this->id_establishment;
	}

	/**
	 * @return mixed
	 */
	public function getIdEventType() {
		return $this->id_event_type;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setName($value) {
		$this->name = $value;
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
	public function setDescription($value) {
		$this->description = $value;
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
	public function setTypeEvent($value) {
		$this->type_event = $value;
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

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdEventType($value) {
		$this->id_event_type = $value;
		return $this;
	}



}