<?php

namespace App\Models;



/**
 * Class Role
 */
class Role extends Model
{
    protected $table = 'role';

    public $timestamps = true;

    protected $fillable = [
        'role'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getRole() {
		return $this->role;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setRole($value) {
		$this->role = $value;
		return $this;
	}



}