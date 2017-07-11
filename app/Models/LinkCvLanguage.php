<?php

namespace App\Models;



/**
 * Class LinkCvLanguage
 */
class LinkCvLanguage extends Model
{
    protected $table = 'link_cv_language';

    public $timestamps = true;

    protected $fillable = [
        'id_cv',
        'id_language',
        'level'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getIdCv() {
		return $this->id_cv;
	}

	/**
	 * @return mixed
	 */
	public function getIdLanguage() {
		return $this->id_language;
	}

	/**
	 * @return mixed
	 */
	public function getLevel() {
		return $this->level;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdCv($value) {
		$this->id_cv = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdLanguage($value) {
		$this->id_language = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setLevel($value) {
		$this->level = $value;
		return $this;
	}



}