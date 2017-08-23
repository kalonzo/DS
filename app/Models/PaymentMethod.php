<?php

namespace App\Models;



/**
 * Class PaymentMethod
 */
class PaymentMethod extends Model
{
    protected $table = 'payment_methods';
    const TABLENAME = 'payment_methods';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'status',
        'id_logo'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
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
	public function getIdLogo() {
		return $this->id_logo;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setName($value) {
		$this->name = $value;
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
	public function setIdLogo($value) {
		$this->id_logo = $value;
		return $this;
	}



}