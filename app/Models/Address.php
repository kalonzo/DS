<?php

namespace App\Models;

/**
 * Class Address
 */
class Address extends Model {

    protected $table = 'address';

    const TABLENAME = 'address';

    public $timestamps = true;
    protected $fillable = [
        'street_number',
        'street',
        'address_additional',
        'po_box',
        'postal_code',
        'city',
        'country',
        'latitude',
        'longitude',
        'label',
        'firstname',
        'lastname',
        'id_location_index',
        'id_object_related',
        'type_object_related'
    ];
    protected $guarded = [];
    
    /**
     * @return mixed
     */
    public function getStreetNumber() {
        return $this->street_number;
    }

    /**
     * @return mixed
     */
    public function getStreet() {
        return $this->street;
    }

    /**
     * @return mixed
     */
    public function getAddressAdditional() {
        return $this->address_additional;
    }

    /**
     * @return mixed
     */
    public function getPoBox() {
        return $this->po_box;
    }

    /**
     * @return mixed
     */
    public function getPostalCode() {
        return $this->postal_code;
    }

    /**
     * @return mixed
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude() {
        return $this->longitude;
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
    public function getFirstname() {
        return $this->firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname() {
        return $this->lastname;
    }

    /**
     * @return mixed
     */
    public function getIdLocationIndex() {
        return $this->id_location_index;
    }

    /**
     * @return mixed
     */
    public function getIdObjectRelated() {
        return $this->id_object_related;
    }

    /**
     * @return mixed
     */
    public function getTypeObjectRelated() {
        return $this->type_object_related;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setStreetNumber($value) {
        $this->street_number = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setStreet($value) {
        $this->street = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setAddressAdditional($value) {
        $this->address_additional = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setPoBox($value) {
        $this->po_box = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setPostalCode($value) {
        $this->postal_code = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setCity($value) {
        $this->city = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setCountry($value) {
        $this->country = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setLatitude($value) {
        $this->latitude = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setLongitude($value) {
        $this->longitude = $value;
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

    /**
     * @param $value
     * @return $this
     */
    public function setFirstname($value) {
        $this->firstname = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setLastname($value) {
        $this->lastname = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdLocationIndex($value) {
        $this->id_location_index = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdObjectRelated($value) {
        $this->id_object_related = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setTypeObjectRelated($value) {
        $this->type_object_related = $value;
        return $this;
    }

}
