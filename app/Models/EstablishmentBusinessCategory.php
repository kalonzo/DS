<?php

namespace App\Models;



/**
 * Class EstablishmentBusinessCategory
 */
class EstablishmentBusinessCategory extends Model
{
    protected $table = 'establishment_business_categories';

    public $timestamps = true;

    protected $fillable = [
        'id_establishment',
        'id_business_category'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getIdEstablishment() {
		return $this->id_establishment;
	}

	/**
	 * @return mixed
	 */
	public function getIdBusinessCategory() {
		return $this->id_business_category;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdEstablishment($value) {
		$this->id_establishment = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdBusinessCategory($value) {
		$this->id_business_category = $value;
		return $this;
	}



}