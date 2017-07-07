<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BankingInfo
 */
class BankingInfo extends Model
{
    protected $table = 'banking_info';

    public $timestamps = false;

    protected $fillable = [
        'label',
        'iban',
        'bic',
        'swift',
        'bank_name',
        'id_address_bank',
        'account_owner_lastname',
        'account_owner_firstname',
        'id_establishment'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @return mixed
	 */
	public function getIban() {
		return $this->iban;
	}

	/**
	 * @return mixed
	 */
	public function getBic() {
		return $this->bic;
	}

	/**
	 * @return mixed
	 */
	public function getSwift() {
		return $this->swift;
	}

	/**
	 * @return mixed
	 */
	public function getBankName() {
		return $this->bank_name;
	}

	/**
	 * @return mixed
	 */
	public function getIdAddressBank() {
		return $this->id_address_bank;
	}

	/**
	 * @return mixed
	 */
	public function getAccountOwnerLastname() {
		return $this->account_owner_lastname;
	}

	/**
	 * @return mixed
	 */
	public function getAccountOwnerFirstname() {
		return $this->account_owner_firstname;
	}

	/**
	 * @return mixed
	 */
	public function getIdEstablishment() {
		return $this->id_establishment;
	}


    
	/**
	 * @param $value
	 * @return $this
	 */
	public function setLabel($value) {
		$this->label = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIban($value) {
		$this->iban = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setBic($value) {
		$this->bic = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setSwift($value) {
		$this->swift = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setBankName($value) {
		$this->bank_name = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdAddressBank($value) {
		$this->id_address_bank = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setAccountOwnerLastname($value) {
		$this->account_owner_lastname = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setAccountOwnerFirstname($value) {
		$this->account_owner_firstname = $value;
		return $this;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setIdEstablishment($value) {
		$this->id_establishment = $value;
		return $this;
	}



}