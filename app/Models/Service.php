<?php

namespace App\Models;



/**
 * Class Service
 */
class Service extends Model
{
    protected $table = 'services';

    public $timestamps = true;

    protected $fillable = [
        'service'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getService() {
		return $this->service;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setService($value) {
		$this->service = $value;
		return $this;
	}



}