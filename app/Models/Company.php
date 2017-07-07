<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 */
class Company extends Model
{
    protected $table = 'companies';

    public $timestamps = false;

    protected $fillable = [
        'id_logo',
        'name'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getIdLogo() {
		return $this->id_logo;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdLogo($value) {
		$this->id_logo = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setName($value) {
		$this->name = $value;
		return $this;
	}



}