<?php

namespace App\Models;

/**
 * Class Payment
 */
class Payment extends Model {

    protected $table = 'payments';
    const TABLENAME = 'payments';
    
    const STATUS_START_CHECKOUT = 1; // Transaction pending
    const STATUS_ERROR_CHECKOUT = 2; // Transaction not initiated properly
    const STATUS_VALID_CHECKOUT = 3; // Transaction confirmed
    const STATUS_PROCESSING = 4; // Transaction processing
    const STATUS_AUTHORIZED = 5; // Transaction authorized
    const STATUS_DENIED = 6; // Transaction denied
    const STATUS_COMPLETED = 7; // Transaction completed
    const STATUS_TO_COLLECT = 8; // Transaction completed
    
    public $timestamps = true;
    protected $fillable = [
        'status',
        'amount',
        'id_currency',
        'id_user',
        'id_payment_method',
        'method_config',
        'id_bill',
        'id_cart',
        'id_transaction'
    ];
    protected $guarded = [];

    public function getFinalStatuses(){
        $statuses = [
            self::STATUS_ERROR_CHECKOUT,
            self::STATUS_COMPLETED,
        ];
        return $statuses;
    }
    
    
    public static function getLabelByStatus(){
        $labelByStatus = array();
        $labelByStatus[self::STATUS_START_CHECKOUT] = 'Transaction initiée';
        $labelByStatus[self::STATUS_ERROR_CHECKOUT] = 'Erreur en cours de transaction';
        $labelByStatus[self::STATUS_VALID_CHECKOUT] = "Transaction valide";
        $labelByStatus[self::STATUS_PROCESSING] = "Transaction en attente d'autorisation";
        $labelByStatus[self::STATUS_AUTHORIZED] = 'Transaction autorisée';
        $labelByStatus[self::STATUS_DENIED] = 'Transaction annulée';
        $labelByStatus[self::STATUS_COMPLETED] = 'Paiement reçu';
        $labelByStatus[self::STATUS_TO_COLLECT] = 'Paiement à percevoir';
        return $labelByStatus;
    }
    
    public static function getColorClassByStatus(){
        $labelByStatus = array();
        $labelByStatus[self::STATUS_START_CHECKOUT] = 'status-info';
        $labelByStatus[self::STATUS_ERROR_CHECKOUT] = 'status-danger';
        $labelByStatus[self::STATUS_VALID_CHECKOUT] = 'status-info';
        $labelByStatus[self::STATUS_PROCESSING] = 'status-warning';
        $labelByStatus[self::STATUS_AUTHORIZED] = 'status-warning';
        $labelByStatus[self::STATUS_DENIED] = 'status-danger';
        $labelByStatus[self::STATUS_COMPLETED] = 'status-ok';
        $labelByStatus[self::STATUS_TO_COLLECT] = 'status-info';
        return $labelByStatus;
    }
    
    public static function getLabelFromStatus($status){
        $statusLabel = 'Statut non défini';
        $statusLabelList = self::getLabelByStatus();
        if(isset($statusLabelList[$status])){
            $statusLabel = $statusLabelList[$status];
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
     * @return mixed
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getAmount() {
        return $this->amount;
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
    public function getIdPaymentMethod() {
        return $this->id_payment_method;
    }

    /**
     * @return mixed
     */
    public function getIdBill() {
        return $this->id_bill;
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
    public function setAmount($value) {
        $this->amount = $value;
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
    public function setIdPaymentMethod($value) {
        $this->id_payment_method = $value;
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

    
    function getIdCart() {
        return $this->id_cart;
    }

    function setIdCart($id_cart) {
        $this->id_cart = $id_cart;
        return $this;
    }

    function getIdCurrency() {
        return $this->id_currency;
    }

    function setIdCurrency($id_currency) {
        $this->id_currency = $id_currency;
        return $this;
    }
    
    function getIdTransaction() {
        return $this->id_transaction;
    }

    function setIdTransaction($id_transaction) {
        $this->id_transaction = $id_transaction;
        return $this;
    }

    function getMethodConfig() {
        return $this->method_config;
    }

    function setMethodConfig($method_config) {
        $this->method_config = $method_config;
        return $this;
    }

}
