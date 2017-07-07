<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PromotionType
 */
class PromotionType extends Model
{
    protected $table = 'promotion_types';

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setName($value) {
		$this->name = $value;
		return $this;
	}



}