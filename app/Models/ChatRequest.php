<?php

namespace App\Models;



/**
 * Class ChatRequest
 */
class ChatRequest extends Model
{
    protected $table = 'chat_requests';

    public $timestamps = true;

    protected $fillable = [
        'message',
        'status',
        'id_user_sender',
        'id_service_target',
        'id_user_target'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @return mixed
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return mixed
	 */
	public function getIdUserSender() {
		return $this->id_user_sender;
	}

	/**
	 * @return mixed
	 */
	public function getIdServiceTarget() {
		return $this->id_service_target;
	}

	/**
	 * @return mixed
	 */
	public function getIdUserTarget() {
		return $this->id_user_target;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setMessage($value) {
		$this->message = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setStatus($value) {
		$this->status = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdUserSender($value) {
		$this->id_user_sender = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdServiceTarget($value) {
		$this->id_service_target = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdUserTarget($value) {
		$this->id_user_target = $value;
		return $this;
	}



}