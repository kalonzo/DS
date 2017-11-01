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
        'guests',
        'guests_message',
        'guests_email_cc',
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
    
    public function isOver(){
        $over = false;
        
        $interval = date_diff(new \Datetime($this->getDatetimeReservation()), new \DateTime());
        if($interval->format('%i') <= 0){
            $over = true;
        }
        return $over;
    }
    
    public function getGuestsEmailArray(){
        $guestsEmailArray = null;
        if(!empty($this->getGuests())){
            $guestsEmailArray = explode(',', $this->getGuests());
        }
        return $guestsEmailArray;
    }
    
    public function establishment(){
        $establishment = $this->hasOne(Establishment::class, 'id', 'id_establishment');
        return $establishment;
    }
    
    public function user(){
        $user = $this->hasOne(User::class, 'id', 'id_user');
        return $user;
    }
    
    public function getEstablishmentOwner(){
        $user = User::select([User::TABLENAME.'.*'])
                ->join(Establishment::TABLENAME, Establishment::TABLENAME.'.id_user_owner', '=', User::TABLENAME.'.id')
                ->where(Establishment::TABLENAME.'.id', '=', $this->getIdEstablishment())
                ->first();
        return $user;
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

    function getGuests() {
        return $this->guests;
    }

    function setGuests($guests) {
        $this->guests = $guests;
        return $this;
    }

    function getGuestsMessage() {
        return $this->guests_message;
    }

    function setGuestsMessage($guests_message) {
        $this->guests_message = $guests_message;
        return $this;
    }

    function getGuestsEmailCc() {
        return $this->guests_email_cc;
    }

    function setGuestsEmailCc($guests_email_cc) {
        $this->guests_email_cc = $guests_email_cc;
        return $this;
    }


}
