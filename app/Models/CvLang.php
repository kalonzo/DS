<?php

namespace App\Models;



/**
 * Class CvLang
 */
class CvLang extends Model
{
    protected $table = 'cv_lang';

    protected $primaryKey = 'id_cv_lang';

	public $timestamps = true;

    protected $fillable = [
        'label',
        'niveau'
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
	public function getNiveau() {
		return $this->niveau;
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
	public function setNiveau($value) {
		$this->niveau = $value;
		return $this;
	}



}