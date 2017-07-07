<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JobType
 */
class JobType extends Model
{
    protected $table = 'job_types';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'id_business_type'
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
	public function getIdBusinessType() {
		return $this->id_business_type;
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
	public function setIdBusinessType($value) {
		$this->id_business_type = $value;
		return $this;
	}



}