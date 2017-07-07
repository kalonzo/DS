<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LinkCvComputingSkill
 */
class LinkCvComputingSkill extends Model
{
    protected $table = 'link_cv_computing_skill';

    public $timestamps = false;

    protected $fillable = [
        'id_computing_skill',
        'id_cv'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getIdComputingSkill() {
		return $this->id_computing_skill;
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
	public function setIdComputingSkill($value) {
		$this->id_computing_skill = $value;
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