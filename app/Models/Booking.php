<?php

namespace App\Models;

/**
 * Class Booking
 */
class Booking extends Model {

    protected $table = 'bookings';

    const TABLENAME = 'bookings';
    const STATUS_CREATED = 1;
    const STATUS_PENDING = 2;
    const STATUS_CONFIRMED = 3;
    const STATUS_DENIED = 4;
    const STATUS_CANCELED = 5;

    public $timestamps = true;
    protected $fillable = [
        'status',
        'lastname',
        'firstname',
        'email',
        'phone_number',
        'datetime_reservation',
        'comment',
        'nb_adults',
        'nb_children',
        'latitude',
        'longitude',
        'id_user',
        'id_establishment'
    ];
    protected $guarded = [];

    public static function getLabelByStatus(){
        $labelByStatus = array();
        $labelByStatus[self::STATUS_CREATED] = 'Créée';
        $labelByStatus[self::STATUS_PENDING] = 'En attente';
        $labelByStatus[self::STATUS_CONFIRMED] = 'Confirmé';
        $labelByStatus[self::STATUS_DENIED] = 'Refusé';
        $labelByStatus[self::STATUS_CANCELED] = 'Annulé';
        return $labelByStatus;
    }
    
    public function getStatusLabel(){
        $statuses = self::getLabelByStatus();
        $statusLabel = '';
        if(isset($statuses[$this->getStatus()])){
            $statusLabel = $statuses[$this->getStatus()];
        }
        return $statusLabel;
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
    public function getLastname() {
        return $this->lastname;
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
    public function getEmail() {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber() {
        return $this->phone_number;
    }

    /**
     * @return mixed
     */
    public function getDatetimeReservation() {
        return $this->datetime_reservation;
    }

    /**
     * @return mixed
     */
    public function getComment() {
        return $this->comment;
    }

    /**
     * @return mixed
     */
    public function getNbAdults() {
        return $this->nb_adults;
    }

    /**
     * @return mixed
     */
    public function getNbChildren() {
        return $this->nb_children;
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
    public function getIdUser() {
        return $this->id_user;
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
    public function setStatus($value) {
        $this->status = $value;
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
    public function setFirstname($value) {
        $this->firstname = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setEmail($value) {
        $this->email = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setPhoneNumber($value) {
        $this->phone_number = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDatetimeReservation($value) {
        $this->datetime_reservation = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setComment($value) {
        $this->comment = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setNbAdults($value) {
        $this->nb_adults = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setNbChildren($value) {
        $this->nb_children = $value;
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
    public function setIdUser($value) {
        $this->id_user = $value;
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
