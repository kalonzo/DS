<?php

namespace App\Models;

/**
 * Class Currency
 */
class Currency extends Model {

    protected $table = 'currencies';

    const TABLENAME = 'currencies';
    const AED = 1;
    const AFN = 2;
    const ALL = 3;
    const AMD = 4;
    const ANG = 5;
    const AOA = 6;
    const ARS = 7;
    const AUD = 8;
    const AWG = 9;
    const AZN = 10;
    const BAM = 11;
    const BBD = 12;
    const BDT = 13;
    const BGN = 14;
    const BHD = 15;
    const BIF = 16;
    const BMD = 17;
    const BND = 18;
    const BOV = 19;
    const BRL = 20;
    const BSD = 21;
    const BWP = 22;
    const BYR = 23;
    const BZD = 24;
    const CAD = 25;
    const CDF = 26;
    const CHF = 27;
    const CLF = 28;
    const CNY = 29;
    const COU = 30;
    const CRC = 31;
    const CUC = 32;
    const CVE = 33;
    const CZK = 34;
    const DJF = 35;
    const DKK = 36;
    const DOP = 37;
    const DZD = 38;
    const EEK = 39;
    const EGP = 40;
    const ERN = 41;
    const ETB = 42;
    const EUR = 43;
    const FJD = 44;
    const FKP = 45;
    const GBP = 46;
    const GEL = 47;
    const GHS = 48;
    const GIP = 49;
    const GMD = 50;
    const GNF = 51;
    const GTQ = 52;
    const GYD = 53;
    const HKD = 54;
    const HNL = 55;
    const HRK = 56;
    const USD = 57;
    const HUF = 58;
    const IDR = 59;
    const ILS = 60;
    const INR = 61;
    const BTN = 62;
    const IQD = 63;
    const IRR = 64;
    const ISK = 65;
    const JMD = 66;
    const JOD = 67;
    const JPY = 68;
    const KES = 69;
    const KGS = 70;
    const KHR = 71;
    const KMF = 72;
    const KPW = 73;
    const KRW = 74;
    const KWD = 75;
    const KYD = 76;
    const KZT = 77;
    const LAK = 78;
    const LBP = 79;
    const LKR = 80;
    const LRD = 81;
    const LTL = 82;
    const LVL = 83;
    const LYD = 84;
    const MAD = 85;
    const MDL = 86;
    const MGA = 87;
    const MKD = 88;
    const MMK = 89;
    const MNT = 90;
    const MOP = 91;
    const MRO = 92;
    const MUR = 93;
    const MVR = 94;
    const MWK = 95;
    const MXV = 96;
    const MYR = 97;
    const MZN = 98;
    const NGN = 99;
    const NIO = 100;
    const NOK = 101;
    const NPR = 102;
    const NZD = 103;
    const OMR = 104;
    const USD_PAB = 105;
    const PEN = 106;
    const PGK = 107;
    const PHP = 108;
    const PKR = 109;
    const PLN = 110;
    const PYG = 111;
    const QAR = 112;
    const RON = 113;
    const RSD = 114;
    const RUB = 115;
    const RWF = 116;
    const SAR = 117;
    const SBD = 118;
    const SCR = 119;
    const SDG = 120;
    const SEK = 121;
    const SGD = 122;
    const SHP = 123;
    const SLL = 124;
    const SOS = 125;
    const SRD = 126;
    const STD = 127;
    const USD_SVC = 128;
    const SYP = 129;
    const SZL = 130;
    const THB = 131;
    const TJS = 132;
    const TMT = 133;
    const TND = 134;
    const TOP = 135;
    const TRYL = 136;
    const TTD = 137;
    const TWD = 138;
    const TZS = 139;
    const UAH = 140;
    const UGX = 141;
    const UYI = 143;
    const UZS = 144;
    const VEF = 145;
    const VND = 146;
    const VUV = 147;
    const WST = 148;
    const XAF = 149;
    const XAG = 150;
    const XAU = 151;
    const XBA = 152;
    const XBB = 153;
    const XBC = 154;
    const XBD = 155;
    const XCD = 156;
    const XDR = 157;
    const XFU = 158;
    const XOF = 159;
    const XPD = 160;
    const XPF = 161;
    const XPT = 162;
    const XTS = 163;
    const YER = 164;
    const ZAR = 165;
    const LSL = 166;
    const NAD = 167;
    const ZMK = 168;
    const ZWL = 169;
    const USD_HTG = 170;
    const AUT = 171;

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

    public static function getCurrenciesById() {
        $currenciesById = [
        self::AED => 'AED',
        self::AFN => 'AFN',
        self::ALL => 'ALL',
        self::AMD => 'AMD',
        self::ANG => 'ANG',
        self::AOA => 'AOA',
        self::ARS => 'ARS',
        self::AUD => 'AUD',
        self::AWG => 'AWG',
        self::AZN => 'AZN',
        self::BAM => 'BAM',
        self::BBD => 'BBD',
        self::BDT => 'BDT',
        self::BGN => 'BGN',
        self::BHD => 'BHD',
        self::BIF => 'BIF',
        self::BMD => 'BMD',
        self::BND => 'BND',
        self::BOV => 'BOV',
        self::BRL => 'BRL',
        self::BSD => 'BSD',
        self::BWP => 'BWP',
        self::BYR => 'BYR',
        self::BZD => 'BZD',
        self::CAD => 'CAD',
        self::CDF => 'CDF',
        self::CHF => 'CHF',
        self::CLF => 'CLF',
        self::CNY => 'CNY',
        self::COU => 'COU',
        self::CRC => 'CRC',
        self::CUC => 'CUC',
        self::CVE => 'CVE',
        self::CZK => 'CZK',
        self::DJF => 'DJF',
        self::DKK => 'DKK',
        self::DOP => 'DOP',
        self::DZD => 'DZD',
        self::EEK => 'EEK',
        self::EGP => 'EGP',
        self::ERN => 'ERN',
        self::ETB => 'ETB',
        self::EUR => 'EUR',
        self::FJD => 'FJD',
        self::FKP => 'FKP',
        self::GBP => 'GBP',
        self::GEL => 'GEL',
        self::GHS => 'GHS',
        self::GIP => 'GIP',
        self::GMD => 'GMD',
        self::GNF => 'GNF',
        self::GTQ => 'GTQ',
        self::GYD => 'GYD',
        self::HKD => 'HKD',
        self::HNL => 'HNL',
        self::HRK => 'HRK',
        self::USD_HTG => 'USD_HTG',
        self::HUF => 'HUF',
        self::IDR => 'IDR',
        self::ILS => 'ILS',
        self::INR => 'INR',
        self::BTN => 'BTN',
        self::IQD => 'IQD',
        self::IRR => 'IRR',
        self::ISK => 'ISK',
        self::JMD => 'JMD',
        self::JOD => 'JOD',
        self::JPY => 'JPY',
        self::KES => 'KES',
        self::KGS => 'KGS',
        self::KHR => 'KHR',
        self::KMF => 'KMF',
        self::KPW => 'KPW',
        self::KRW => 'KRW',
        self::KWD => 'KWD',
        self::KYD => 'KYD',
        self::KZT => 'KZT',
        self::LAK => 'LAK',
        self::LBP => 'LBP',
        self::LKR => 'LKR',
        self::LRD => 'LRD',
        self::LTL => 'LTL',
        self::LVL => 'LVL',
        self::LYD => 'LYD',
        self::MAD => 'MAD',
        self::MDL => 'MDL',
        self::MGA => 'MGA',
        self::MKD => 'MKD',
        self::MMK => 'MMK',
        self::MNT => 'MNT',
        self::MOP => 'MOP',
        self::MRO => 'MRO',
        self::MUR => 'MUR',
        self::MVR => 'MVR',
        self::MWK => 'MWK',
        self::MXV => 'MXV',
        self::MYR => 'MYR',
        self::MZN => 'MZN',
        self::NGN => 'NGN',
        self::NIO => 'NIO',
        self::NOK => 'NOK',
        self::NPR => 'NPR',
        self::NZD => 'NZD',
        self::OMR => 'OMR',
        self::USD_PAB => 'USD_PAB',
        self::PEN => 'PEN',
        self::PGK => 'PGK',
        self::PHP => 'PHP',
        self::PKR => 'PKR',
        self::PLN => 'PLN',
        self::PYG => 'PYG',
        self::QAR => 'QAR',
        self::RON => 'RON',
        self::RSD => 'RSD',
        self::RUB => 'RUB',
        self::RWF => 'RWF',
        self::SAR => 'SAR',
        self::SBD => 'SBD',
        self::SCR => 'SCR',
        self::SDG => 'SDG',
        self::SEK => 'SEK',
        self::SGD => 'SGD',
        self::SHP => 'SHP',
        self::SLL => 'SLL',
        self::SOS => 'SOS',
        self::SRD => 'SRD',
        self::STD => 'STD',
        self::USD_SVC => 'USD_SVC',
        self::SYP => 'SYP',
        self::SZL => 'SZL',
        self::THB => 'THB',
        self::TJS => 'TJS',
        self::TMT => 'TMT',
        self::TND => 'TND',
        self::TOP => 'TOP',
        self::TRYL => 'TRY',
        self::TTD => 'TTD',
        self::TWD => 'TWD',
        self::TZS => 'TZS',
        self::UAH => 'UAH',
        self::UGX => 'UGX',
        self::USD => 'USD',
        self::UYI => 'UYI',
        self::UZS => 'UZS',
        self::VEF => 'VEF',
        self::VND => 'VND',
        self::VUV => 'VUV',
        self::WST => 'WST',
        self::XAF => 'XAF',
        self::XAG => 'XAG',
        self::XAU => 'XAU',
        self::XBA => 'XBA',
        self::XBB => 'XBB',
        self::XBC => 'XBC',
        self::XBD => 'XBD',
        self::XCD => 'XCD',
        self::XDR => 'XDR',
        self::XFU => 'XFU',
        self::XOF => 'XOF',
        self::XPD => 'XPD',
        self::XPF => 'XPF',
        self::XPT => 'XPT',
        self::XTS => 'XTS',
        self::YER => 'YER',
        self::ZAR => 'ZAR',
        self::LSL => 'LSL',
        self::NAD => 'NAD',
        self::ZMK => 'ZMK',
        self::ZWL => 'ZWL',

        ];
        return $currenciesById;
    }

    public static function getCurrencyLabel($id_currency) {
        $label = null;
        $currenciesById = self::getCurrenciesById();
        if (isset($currenciesById[$id_currency])) {
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
