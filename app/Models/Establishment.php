<?php

namespace App\Models;

/**
 * Class Establishment
 */
class Establishment extends Model {

    protected $table = 'establishments';
    const TABLENAME = 'establishments';

    const TYPE_BUSINESS_RESTAURANT = 1;

    public $timestamps = true;
    protected $fillable = [
        'status',
        'name',
        'profile_condition',
        'email',
        'id_address',
        'DS_ranking',
        'id_logo',
        'star',
        'nb_last_week_visits',
        'accept_voucher',
        'site_url',
        'description',
        'average_price_min',
        'average_price_max',
        'id_banking_info',
        'id_user_owner',
        'id_business_type',
        'latitude',
        'longitude'
    ];
    protected $guarded = [];

    private $latLng = null;
    public function getLatLng($lazy = true){
        if($this->latLng === null || !$lazy){
            $this->latLng = new Utilities\LatLng($this->getLatitude(), $this->getLongitude());
        }
        return $this->latLng;
    }
    
    public function getBusinessTypeLabel(){
        $businessLabel = 'Type non défini';
        $businessTypeLabels = BusinessType::getLabelByType();
        if(isset($businessTypeLabels[$this->getIdBusinessType()])){
            $businessLabel = $businessTypeLabels[$this->getIdBusinessType()];
        }
        return $businessLabel;
    }
    
    public function getDefaultPicture(){
        return "/img/images_ds/imagen-DS-".rand(1, 20).".jpg";
    }
    
    public function getDefaultBanner(){
        return "/img/images_ds/imagen-DS-".rand(1, 20).".jpg";
    }
    
    public function address(){
        return $this->hasOne(Address::class, 'id', 'id_address');
    }
    
    public function userOwner(){
        return $this->hasOne(User::class, 'id', 'id_user_owner');
    }
    
    public function logo(){
        return $this->hasOne(EstablishmentMedia::class, 'id', 'id_logo');
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
    public function getProfileCondition() {
        return $this->profile_condition;
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
    public function getIdAddress() {
        return $this->id_address;
    }

    /**
     * @return mixed
     */
    public function getDSRanking() {
        return $this->DS_ranking;
    }

    /**
     * @return mixed
     */
    public function getIdLogo() {
        return $this->id_logo;
    }

    /**
     * @return mixed
     */
    public function getStar() {
        return $this->star;
    }

    /**
     * @return mixed
     */
    public function getNbLastWeekVisits() {
        return $this->nb_last_week_visits;
    }

    /**
     * @return mixed
     */
    public function getAcceptVoucher() {
        return $this->accept_voucher;
    }

    /**
     * @return mixed
     */
    public function getSiteUrl() {
        return $this->site_url;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getAveragePriceMin() {
        return $this->average_price_min;
    }

    /**
     * @return mixed
     */
    public function getAveragePriceMax() {
        return $this->average_price_max;
    }

    /**
     * @return mixed
     */
    public function getIdBankingInfo() {
        return $this->id_banking_info;
    }

    /**
     * @return mixed
     */
    public function getIdUserOwner() {
        return $this->id_user_owner;
    }

    /**
     * @return mixed
     */
    public function getIdBusinessType() {
        return $this->id_business_type;
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
    public function setProfileCondition($value) {
        $this->profile_condition = $value;
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
    public function setIdAddress($value) {
        $this->id_address = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDSRanking($value) {
        $this->DS_ranking = $value;
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

    /**
     * @param $value
     * @return $this
     */
    public function setStar($value) {
        $this->star = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setNbLastWeekVisits($value) {
        $this->nb_last_week_visits = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setAcceptVoucher($value) {
        $this->accept_voucher = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setSiteUrl($value) {
        $this->site_url = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDescription($value) {
        $this->description = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setAveragePriceMin($value) {
        $this->average_price_min = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setAveragePriceMax($value) {
        $this->average_price_max = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdBankingInfo($value) {
        $this->id_banking_info = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdUserOwner($value) {
        $this->id_user_owner = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdBusinessType($value) {
        $this->id_business_type = $value;
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

}
