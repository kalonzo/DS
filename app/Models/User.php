<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Usere
 */
class User extends Authenticatable implements GlobalObjectManageable{

    use ExtendModelTrait;
    use \Illuminate\Notifications\Notifiable;

    const TYPE_GLOBAL_OBJECT = self::TYPE_OBJECT_USER;
    
    protected $table = 'users';
    const TABLENAME = 'users';
    
    public $timestamps = true;
    public $incrementing = false;

    const TYPE_USER_ADMIN_PRO = 1;
    const TYPE_USER = 2;
    const TYPE_USER_AUTO_INSERTED = 3;
    const TYPE_USER_PRO = 4;
    
    const STATUS_CREATION_PENDING = 1;
    const STATUS_CREATED = 2;
    const STATUS_ACTIVE = 3;
    
    const TYPE_GENDER_WOMAN = 1;
    const TYPE_GENDER_MAN = 2;

    protected $fillable = [
        'status',
        'name',
        'type',
        'gender',
        'lastname',
        'firstname',
        'email',
        'password',
        'is_connected',
        'id_address',
        'id_inbox',
        'longitude',
        'latitude',
        'id_photo',
        'id_company',
    ];
    protected $guarded = [];

    /**
     * Aditional attributes not persisted on the table
     *
     * @var array
     */
    protected $appends = [
        'verified'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function getCurrentPendingCart(){
        return $this->hasMany(Cart::class, 'id_user', 'id')->where('status', '=', Cart::STATUS_PENDING)->orderBy('updated_at', 'DESC')->first();
    }
    
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function company(){
        return $this->hasOne(Company::class, 'id', 'id_company');
    }
    
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function address(){
        return $this->hasOne(Address::class, 'id', 'id_address');
    }

    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function establishmentsOwned(){
        return $this->hasMany(Establishment::class, 'id_user_owner', 'id');
    }
    
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function cart(){
        return $this->hasMany(Cart::class, 'id_user', 'id');
    }
    
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function callNumbers(){
        return $this->hasMany(CallNumber::class, 'id_object_related', 'id');
    }
    
    /**
     * Relationship
     *
     * Function name should be 'tokens', but 'codes' was kept
     * to reuse some code I already had.
     * You are welcome to refactor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function codes() {
        return $this->hasMany(\App\RegistrationToken::class)->orderBy('created_at', 'DESC');
    }

    /**
     * @param $email
     *
     * @return \Illuminate\Database\Eloquent\Model|null|static|User
     */
    public static function findByEmail($email) {
        return static::whereEmail($email)->first();
    }

    /**
     * @param $email
     *
     * @return \App\RegistrationToken[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public static function getTokens($email) {
        return static::findByEmail($email)->codes;
    }

    /**
     * @return bool
     */
    public function getVerifiedAttribute() {
        return (bool) !$this->codes->count();
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
    public function getName() {
        return $this->name;
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
    public function getGender() {
        return $this->gender;
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
    public function getPassword() {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getIsConnected() {
        return $this->is_connected;
    }

    /**
     * @return mixed
     */
    public function getIdAddress() {
        return $this->id_address;
    }

    /**
     * @return mixed
     */
    public function getIdInbox() {
        return $this->id_inbox;
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
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * @return mixed
     */
    public function getIdPhoto() {
        return $this->id_photo;
    }

    /**
     * @return mixed
     */
    public function getIdCompany() {
        return $this->id_company;
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
    public function setName($value) {
        $this->name = $value;
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
    public function setGender($value) {
        $this->gender = $value;
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
    public function setPassword($value) {
        $this->password = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIsConnected($value) {
        $this->is_connected = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdAddress($value) {
        $this->id_address = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdInbox($value) {
        $this->id_inbox = $value;
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
    public function setLatitude($value) {
        $this->latitude = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdPhoto($value) {
        $this->id_photo = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdCompany($value) {
        $this->id_company = $value;
        return $this;
    }

}
