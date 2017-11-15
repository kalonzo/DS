<?php

namespace App\Models;

/**
 * Class PaymentMethod
 */
class PaymentMethod extends Model {

    protected $table = 'payment_methods';
    const TABLENAME = 'payment_methods';

    const METHOD_CB = 1;
    const METHOD_CB_MASTERCARD = 101;
    const METHOD_CB_VISA = 102;
    const METHOD_CB_POSTFINANCE = 103;
    const METHOD_CB_AMEX = 104;
    const METHOD_CB_PAYPAL = 105;
    
    const METHOD_30_DAYS_BILL = 2;
    const METHOD_PACKAGE_INCLUDED = 3;
    const METHOD_FREE_PASS = 4;
    const METHOD_DELAYED_PAYMENT = 5;
    
    const METHOD_CONFIG_OFFSITE = 1;
    const METHOD_CONFIG_IFRAME = 2;
    
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 2;
    const STATUS_ONLY_DISPLAY = 3;

    public $timestamps = true;
    public $incrementing = false;
    public static $hasUuid = false;
    protected $fillable = [
        'id',
        'name',
        'status',
        'id_logo',
        'method_config'
    ];
    protected $guarded = [];

    
    public static function getLabelByMethod(){
        $labelByMethod = array();
        $labelByMethod[self::METHOD_CB] = 'Carte bancaire';
        $labelByMethod[self::METHOD_CB_MASTERCARD] = 'Mastercard';
        $labelByMethod[self::METHOD_CB_VISA] = 'Visa';
        $labelByMethod[self::METHOD_CB_POSTFINANCE] = 'PostFinance Card';
        $labelByMethod[self::METHOD_CB_AMEX] = 'American Express';
        $labelByMethod[self::METHOD_CB_PAYPAL] = 'Paypal';
        $labelByMethod[self::METHOD_30_DAYS_BILL] = 'Facture à 30 jours';
        $labelByMethod[self::METHOD_PACKAGE_INCLUDED] = 'Inclus dans une offre commercial';
        $labelByMethod[self::METHOD_FREE_PASS] = 'Gratuit';
        $labelByMethod[self::METHOD_DELAYED_PAYMENT] = 'Paiement à venir';
        return $labelByMethod;
    }
    
    public static function getLabelFromMethod($method){
        $label = 'Méthode non définie';
        $businessTypeLabels = self::getLabelByMethod();
        if(isset($businessTypeLabels[$method])){
            $label = $businessTypeLabels[$method];
        }
        return $label;
    }
    
    public static function getLabelByStatus(){
        $labelByStatus = array();
        $labelByStatus[self::STATUS_ACTIVE] = 'Activé';
        $labelByStatus[self::STATUS_DISABLED] = 'Désactivé';
        $labelByStatus[self::STATUS_ONLY_DISPLAY] = 'Affichage seulement';
        return $labelByStatus;
    }
    
    public static function getLabelFromStatus($status){
        $statusLabel = 'Statut non défini';
        $methodStatusLabels = self::getLabelByStatus();
        if(isset($methodStatusLabels[$status])){
            $statusLabel = $methodStatusLabels[$status];
        }
        return $statusLabel;
    }
    
    /**
     * 
     * @return \Illuminate\Database\Query\Builder
     */
    public function logo(){
        return $this->hasOne(EstablishmentMedia::class, 'id', 'id_logo');
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
    public function getStatus() {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getIdLogo() {
        return $this->id_logo;
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
    public function setStatus($value) {
        $this->status = $value;
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

    function getMethodConfig() {
        return $this->method_config;
    }

    function setMethodConfig($method_config) {
        $this->method_config = $method_config;
        return $this;
    }


}
