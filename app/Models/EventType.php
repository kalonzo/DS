<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EventType
 */
class EventType extends Model
{
    protected $table = 'event_types';

    public $timestamps = false;

    protected $fillable = [
        'label'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getLabel() {
		return $this->label;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setLabel($value) {
		$this->label = $value;
		return $this;
	}



}