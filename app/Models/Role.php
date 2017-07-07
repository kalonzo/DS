<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 */
class Role extends Model
{
    protected $table = 'role';

    public $timestamps = false;

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