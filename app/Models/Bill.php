<?php

namespace App\Models;

/**
 * Class Bill
 */
class Bill extends Model implements GlobalObjectManageable{

    protected $table = 'bills';

    const TABLENAME = 'bills';
    const TYPE_GLOBAL_OBJECT = self::TYPE_OBJECT_BILL;

    const STATUS_CREATED = 1;
    const STATUS_PARTIALLY_PAID = 2;
    const STATUS_PAID = 3;
    const STATUS_CANCELED = 4;
    
    public $timestamps = true;
    protected $fillable = [
        'status',
        'title',
        'lastname',
        'firstname',
        'company_name',
        'pro_phone',
        'end_date',
        'start_date',
        'phone_number',
        'email',
        'id_user',
        'id_cart',
        'id_contract'
    ];
    protected $guarded = [];

    
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function callNumbers(){
        return $this->hasMany(CallNumber::class, 'id_object_related', 'id');
    }
    
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function addresses(){
        return $this->hasMany(Address::class, 'id_object_related', 'id');
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function cart(){
        return $this->hasOne(Cart::class, 'id', 'id_cart');
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function contract(){
        return $this->hasOne(Contract::class, 'id', 'id_contract');
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function subscriptions(){
        return $this->hasMany(Subscription::class, 'id_bill', 'id');
    }
    
    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
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
    public function getCompanyName() {
        return $this->company_name;
    }

    /**
     * @return mixed
     */
    public function getProPhone() {
        return $this->pro_phone;
    }

    /**
     * @return mixed
     */
    public function getEndDate() {
        return $this->end_date;
    }

    /**
     * @return mixed
     */
    public function getStartDate() {
        return $this->start_date;
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
    public function getEmail() {
        return $this->email;
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
    public function getIdCart() {
        return $this->id_cart;
    }

    /**
     * @return mixed
     */
    public function getIdContract() {
        return $this->id_contract;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setTitle($value) {
        $this->title = $value;
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
    public function setCompanyName($value) {
        $this->company_name = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setProPhone($value) {
        $this->pro_phone = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setEndDate($value) {
        $this->end_date = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setStartDate($value) {
        $this->start_date = $value;
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
    public function setEmail($value) {
        $this->email = $value;
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
    public function setIdCart($value) {
        $this->id_cart = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdContract($value) {
        $this->id_contract = $value;
        return $this;
    }

    function getStatus() {
        return $this->status;
    }

    function setStatus($status) {
        $this->status = $status;
        return $this;
    }


}
