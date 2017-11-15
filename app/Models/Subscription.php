<?php

namespace App\Models;

/**
 * Class Subscription
 */
class Subscription extends Model {

    protected $table = 'subscriptions';
    const TABLENAME  = 'subscriptions';
    
    const STATUS_ACTIVE = 1;
    const STATUS_WAITING_4_PAYMENT = 2;
    const STATUS_UNACTIVE = 3;
    const STATUS_CANCELED = 4;
    const STATUS_EXPIRED = 5;
    
    public $timestamps = true;
    protected $fillable = [
        'status',
        'priceTTC',
        'start_date',
        'end_date',
        'close_date',
        'id_establishment',
        'id_user',
        'id_bill',
        'id_buyable_item',
        'duration'
    ];
    protected $guarded = [];
    
    
    public static function getLabelByStatus(){
        $labelByStatus = array();
        $labelByStatus[self::STATUS_ACTIVE] = 'Activé';
        $labelByStatus[self::STATUS_WAITING_4_PAYMENT] = 'Actif, en attente de paiement';
        $labelByStatus[self::STATUS_UNACTIVE] = 'Désactivé';
        $labelByStatus[self::STATUS_CANCELED] = 'Annulé';
        $labelByStatus[self::STATUS_EXPIRED] = 'Expiré';
        return $labelByStatus;
    }
    
    public static function getColorClassByStatus(){
        $labelByStatus = array();
        $labelByStatus[self::STATUS_ACTIVE] = 'status-ok';
        $labelByStatus[self::STATUS_WAITING_4_PAYMENT] = 'status-warning';
        $labelByStatus[self::STATUS_UNACTIVE] = 'status-disabled';
        $labelByStatus[self::STATUS_CANCELED] = 'status-danger';
        $labelByStatus[self::STATUS_EXPIRED] = 'status-info';
        return $labelByStatus;
    }
    
    public static function getLabelFromStatus($status){
        $statusLabel = 'Statut non défini';
        $subscriptionStatusLabels = self::getLabelByStatus();
        if(isset($subscriptionStatusLabels[$status])){
            $statusLabel = $subscriptionStatusLabels[$status];
        }
        return $statusLabel;
    }
    
    public static function getColorClassFromStatus($status){
        $colorClass = '';
        $colorClassList = self::getColorClassByStatus();
        if(isset($colorClassList[$status])){
            $colorClass = $colorClassList[$status];
        }
        return $colorClass;
    }
    
    public function getStatusLabel(){
        return self::getLabelFromStatus($this->getStatus());
    }
    
    public function getStatusColorClass(){
        return self::getColorClassFromStatus($this->getStatus());
    }
    
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function bill(){
        return $this->hasOne(Bill::class, 'id', 'id_bill');
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function buyableItem(){
        return $this->hasOne(BuyableItem::class, 'id', 'id_buyable_item');
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function establishment(){
        return $this->hasOne(Establishment::class, 'id', 'id_establishment');
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function user(){
        return $this->hasOne(User::class, 'id', 'id_user');
    }
    
    function getStatus() {
        return $this->status;
    }

    function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPriceTTC() {
        return $this->priceTTC;
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
    public function getEndDate() {
        return $this->end_date;
    }

    /**
     * @return mixed
     */
    public function getCloseDate() {
        return $this->close_date;
    }

    /**
     * @return mixed
     */
    public function getIdEstablishment() {
        return $this->id_establishment;
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
    public function getIdBill() {
        return $this->id_bill;
    }

    /**
     * @return mixed
     */
    public function getIdBuyableItem() {
        return $this->id_buyable_item;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setPriceTTC($value) {
        $this->priceTTC = $value;
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
    public function setEndDate($value) {
        $this->end_date = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setCloseDate($value) {
        $this->close_date = $value;
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
    public function setIdBill($value) {
        $this->id_bill = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdBuyableItem($value) {
        $this->id_buyable_item = $value;
        return $this;
    }

    
    function getDuration() {
        return $this->duration;
    }

    function setDuration($duration) {
        $this->duration = $duration;
        return $this;
    }
}
