<?php

namespace App\Utilities;

use App\Models\Currency;
use Illuminate\Support\Facades\App;

/**
 * Description of CurrencyTools
 *
 * @author Nico
 */
class CurrencyTools {
    const DEFAULT_CURRENCY = Currency::USD;
    static $currencyByCountry = array(  
                                        'ch' => Currency::CHF,
                                        'fr' => Currency::EUR,
                                        'gb' => Currency::GBP
                                );
    
    public static function getIdCurrencyFromLocale(){
        $currency = self::DEFAULT_CURRENCY;
        $locale = App::getLocale();
        if(isset(self::$currencyByCountry[$locale])){
            $currency = self::$currencyByCountry[$locale];
        }
        return $currency;
    }
    
    public static function getSymbolFromCurrency($currencyIso, $locale = null){
        if(empty($locale)){
            $locale = Illuminate\Support\Facades\App::getLocale();
        }
        $fmt = new NumberFormatter( $locale."@currency=$currencyIso", NumberFormatter::CURRENCY);
        $symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
        return $symbol;
    }
}
