<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LoggedAction
 */
class LoggedAction extends Model
{
    protected $table = 'logged_actions';

    public $timestamps = false;

    protected $fillable = [
        'action',
        'type_object_related',
        'id_object_related',
        'id_user'
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
	public function getTypeObjectRelated() {
		return $this->type_object_related;
	}

	/**
	 * @return mixed
	 */
	public function getIdObjectRelated() {
		return $this->id_object_related;
	}

	/**
	 * @return mixed
	 */
	public function getIdUser() {
		return $this->id_user;
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
	public function setTypeObjectRelated($value) {
		$this->type_object_related = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdObjectRelated($value) {
		$this->id_object_related = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdUser($value) {
		$this->id_user = $value;
		return $this;
	}



}