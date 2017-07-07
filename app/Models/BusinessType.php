<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BusinessType
 */
class BusinessType extends Model
{
    protected $table = 'business_types';

    public $timestamps = false;

    protected $fillable = [
        'id_media',
        'label'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getIdMedia() {
		return $this->id_media;
	}

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
	public function setIdMedia($value) {
		$this->id_media = $value;
		return $this;
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