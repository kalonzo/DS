<?php

namespace App\Models;



/**
 * Class Language
 */
class Language extends Model
{
    protected $table = 'languages';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'position',
        'translation_available'
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
	public function getPosition() {
		return $this->position;
	}

	/**
	 * @return mixed
	 */
	public function getTranslationAvailable() {
		return $this->translation_available;
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
	public function setPosition($value) {
		$this->position = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setTranslationAvailable($value) {
		$this->translation_available = $value;
		return $this;
	}



}