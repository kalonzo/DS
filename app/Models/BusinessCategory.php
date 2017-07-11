<?php

namespace App\Models;



/**
 * Class BusinessCategory
 */
class BusinessCategory extends Model
{
    protected $table = 'business_categories';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'type'
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
	public function getType() {
		return $this->type;
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
	public function setType($value) {
		$this->type = $value;
		return $this;
	}



}