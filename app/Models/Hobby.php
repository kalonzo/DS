<?php

namespace App\Models;



/**
 * Class Hobby
 */
class Hobby extends Model
{
    protected $table = 'hobbies';

    public $timestamps = true;

    protected $fillable = [
        'label',
        'id_cv'
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
	public function getIdCv() {
		return $this->id_cv;
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
	public function setIdCv($value) {
		$this->id_cv = $value;
		return $this;
	}



}