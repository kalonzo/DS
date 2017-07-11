<?php

namespace App\Models;



/**
 * Class InboxEmail
 */
class InboxEmail extends Model
{
    protected $table = 'inbox_emails';

    public $timestamps = true;

    protected $fillable = [
        'status',
        'subject',
        'content',
        'conversation_identifier',
        'id_user_sender',
        'id_user_recipient'
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
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * @return mixed
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * @return mixed
	 */
	public function getConversationIdentifier() {
		return $this->conversation_identifier;
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
	public function getIdUserRecipient() {
		return $this->id_user_recipient;
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
	public function setSubject($value) {
		$this->subject = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setContent($value) {
		$this->content = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setConversationIdentifier($value) {
		$this->conversation_identifier = $value;
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
	public function setIdUserRecipient($value) {
		$this->id_user_recipient = $value;
		return $this;
	}



}