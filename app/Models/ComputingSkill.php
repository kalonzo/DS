<?php

namespace App\Models;



/**
 * Class ComputingSkill
 */
class ComputingSkill extends Model
{
    protected $table = 'computing_skills';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'position'
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



}