<?php

namespace App\Models;

/**
 * Class CallNumber
 */
class CallNumber extends Model {

    const TYPE_PHONE_NUMBER_RESERVATION = 1;
    const TYPE_FAX = 2;
    const TYPE_MOBILE = 3;
    const TYPE_PHONE_CONTACT = 4;

    protected $table = 'call_numbers';
    public $timestamps = true;
    protected $fillable = [
        'label',
        'type',
        'main',
        'prefix',
        'id_country',
        'number',
        'id_establishment'
    ];
    protected $guarded = [];
    
    public function getDisplayable(){
        $country = $this->country()->select('iso')->first();
        if(checkModel($country)){
            $countryIso = $country->getIso();
        }
        $label = (string)\Propaganistas\LaravelPhone\PhoneNumber::make($this->getNumber(), $countryIso)->formatForCountry(\Illuminate\Support\Facades\App::getLocale());
        return $label;
    }
    
    public function country(){
        return $this->hasOne(Country::class, 'id', 'id_country');
    }
    
    /**
     * @return mixed
     */
    public function getLabel() {
        return $this->label;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getMain() {
        return $this->main;
    }

    /**
     * @return mixed
     */
    public function getPrefix() {
        return $this->prefix;
    }

    /**
     * @return mixed
     */
    public function getNumber() {
        return $this->number;
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
    public function setType($value) {
        $this->type = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setMain($value) {
        $this->main = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setPrefix($value) {
        $this->prefix = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setNumber($value) {
        $this->number = $value;
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

    function getIdCountry() {
        return $this->id_country;
    }

    function setIdCountry($id_country) {
        $this->id_country = $id_country;
    }
}