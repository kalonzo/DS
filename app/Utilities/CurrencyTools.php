<?php

namespace App\Utilities;

/**
 * Description of CurrencyTools
 *
 * @author Nico
 */
class CurrencyTools {
    const DEFAULT_CURRENCY = 'USD';
    static $currencyByCountry = array(  
                                        'ch' => 'CHF',
                                        'fr' => 'EUR',
                                        'gb' => 'GBP'
                                );
    
    public static function getCurrencyFromLocale(){
        $currency = self::DEFAULT_CURRENCY;
        $locale = \Illuminate\Support\Facades\App::getLocale();
        if(isset(self::$currencyByCountry[$locale])){
            $currency = self::$currencyByCountry[$locale];
        }
        return $currency;
    }
}
