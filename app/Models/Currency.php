<?php

namespace App\Models;

/**
 * Class Currency
 */
class Currency extends Model {

    protected $table = 'currencies';
    const TABLENAME = 'currencies';
    
    const CHF = 1;
    const USD = 2;
    const EUR = 3;
    const GBP = 4;
    
    public $timestamps = true;
    public $incrementing = false;
    public static $hasUuid = false;
    
    protected $fillable = [
        'symbol',
        'short_label',
        'label',
        'rate'
    ];
    protected $guarded = [];
    
    public static function getCurrenciesById(){
        $currenciesById = [
            self::CHF => 'CHF',
            self::USD => 'USD',
            self::EUR => 'EUR',
            self::GBP => 'GBP',
        ];
        return $currenciesById;
    }
    
    public static function getCurrencyLabel($id_currency){
        $label = null;
        $currenciesById = self::getCurrenciesById();
        if(isset($currenciesById[$id_currency])){
            $label = $currenciesById[$id_currency];
        }
        return $label;
    }

    /**
     * @return mixed
     */
    public function getSymbol() {
        return $this->symbol;
    }

    /**
     * @return mixed
     */
    public function getShortLabel() {
        return $this->short_label;
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
    public function getRate() {
        return $this->rate;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setSymbol($value) {
        $this->symbol = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setShortLabel($value) {
        $this->short_label = $value;
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
    public function setRate($value) {
        $this->rate = $value;
        return $this;
    }

}
