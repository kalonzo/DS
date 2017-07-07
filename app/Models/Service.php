<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Service
 */
class Service extends Model
{
    protected $table = 'services';

    public $timestamps = false;

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