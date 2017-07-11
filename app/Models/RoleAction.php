<?php

namespace App\Models;



/**
 * Class RoleAction
 */
class RoleAction extends Model
{
    protected $table = 'role_actions';

    public $timestamps = true;

    protected $fillable = [
        'action',
        'id_role'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getAction() {
		return $this->action;
	}

	/**
	 * @return mixed
	 */
	public function getIdRole() {
		return $this->id_role;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setAction($value) {
		$this->action = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdRole($value) {
		$this->id_role = $value;
		return $this;
	}



}