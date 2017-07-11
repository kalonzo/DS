<?php

namespace App\Models;



/**
 * Class FeedFlow
 */
class FeedFlow extends Model
{
    protected $table = 'feed_flows';

    public $timestamps = true;

    protected $fillable = [
        'type',
        'status'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @return mixed
	 */
	public function getStatus() {
		return $this->status;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setType($value) {
		$this->type = $value;
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



}