<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FeedFlowTarget
 */
class FeedFlowTarget extends Model
{
    protected $table = 'feed_flow_targets';

    public $timestamps = false;

    protected $fillable = [
        'id_feed_flow',
        'id_user',
        'id_service'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getIdFeedFlow() {
		return $this->id_feed_flow;
	}

	/**
	 * @return mixed
	 */
	public function getIdUser() {
		return $this->id_user;
	}

	/**
	 * @return mixed
	 */
	public function getIdService() {
		return $this->id_service;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdFeedFlow($value) {
		$this->id_feed_flow = $value;
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

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdService($value) {
		$this->id_service = $value;
		return $this;
	}



}