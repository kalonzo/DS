<?php

namespace App\Models;



/**
 * Class EstablishmentHistory
 */
class EstablishmentHistory extends Model
{
    protected $table = 'establishment_history';

    public $timestamps = true;

    protected $fillable = [
        'year',
        'title',
        'content',
        'id_photo'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getYear() {
		return $this->year;
	}

	/**
	 * @return mixed
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @return mixed
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * @return mixed
	 */
	public function getIdPhoto() {
		return $this->id_photo;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setYear($value) {
		$this->year = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setTitle($value) {
		$this->title = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setContent($value) {
		$this->content = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdPhoto($value) {
		$this->id_photo = $value;
		return $this;
	}



}