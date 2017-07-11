<?php

namespace App\Models;



/**
 * Class ChatMessage
 */
class ChatMessage extends Model
{
    protected $table = 'chat_messages';

    public $timestamps = true;

    protected $fillable = [
        'status',
        'message',
        'id_user_sender',
        'id_user_receiver'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return mixed
	 */
	public function getMessage() {
		return $this->message;
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
	public function getIdUserReceiver() {
		return $this->id_user_receiver;
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
	public function setMessage($value) {
		$this->message = $value;
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
	public function setIdUserReceiver($value) {
		$this->id_user_receiver = $value;
		return $this;
	}



}