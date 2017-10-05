<?php

namespace App\Models;

/**
 * Class Country
 */
class Country extends Model {

    protected $table = 'countries';

    const TABLENAME = 'countries';
    const AFG = 2;
    const ALB = 3;
    const DZA = 4;
    const ANDO = 5;
    const AGO = 6;
    const ATG = 7;
    const ARG = 8;
    const ARM = 9;
    const AUS_ACI = 10;
    const AUS_CSI = 287;
    const AUS_A = 288;
    const AZE_NK = 12;
    const AZE_A = 282;
    const BHS = 13;
    const BHR = 14;
    const BGD = 15;
    const BRB = 16;
    const BLR = 17;
    const BEL = 18;
    const BLZ = 19;
    const BEN = 20;
    const BTN = 21;
    const BOL = 22;
    const BIH = 23;
    const BWA = 24;
    const BRA = 25;
    const BRN = 26;
    const BGR = 27;
    const BFA = 28;
    const BDI = 29;
    const KHM = 30;
    const CMR = 31;
    const CAN = 32;
    const CPV = 33;
    const CAF = 34;
    const TCD = 35;
    const CHL = 36;
    const CHN = 37;
    const COL = 38;
    const COM = 39;
    const COD = 40;
    const COG = 41;
    const CRI = 42;
    const CIV = 43;
    const HRV = 44;
    const CUB = 45;
    const CYP_C = 46;
    const CYP_NC = 284;
    const CZE = 47;
    const DNK = 48;
    const DJI = 49;
    const DMA = 50;
    const DOM = 51;
    const ECU = 52;
    const EGY = 53;
    const SLV = 54;
    const GNQ = 55;
    const ERI = 56;
    const EST = 57;
    const ETH = 58;
    const FJI = 59;
    const FIN = 60;
    const FRA = 61;
    const GAB = 62;
    const GMB = 63;
    const GEO_A = 64;
    const GEO_SO = 280;
    const GEO_G = 281;
    const DEU = 65;
    const GHA = 66;
    const GRC = 67;
    const GRD = 68;
    const GTM = 69;
    const GIN = 70;
    const GNB = 71;
    const GUY = 72;
    const HTI = 73;
    const HND = 74;
    const HUN = 75;
    const ISL = 76;
    const IND = 77;
    const IDN = 78;
    const IRN = 79;
    const IRQ = 80;
    const IRL = 81;
    const ISR = 82;
    const ITA = 83;
    const JAM = 84;
    const JPN = 85;
    const JOR = 86;
    const KAZ = 87;
    const KEN = 88;
    const KIR = 89;
    const PRK = 90;
    const KOR = 91;
    const KWT = 92;
    const KGZ = 93;
    const LAO = 94;
    const LVA = 95;
    const LBN = 96;
    const LSO = 97;
    const LBR = 98;
    const LBY = 99;
    const LIE = 100;
    const LTU = 101;
    const LUX = 102;
    const MKD = 103;
    const MDG = 104;
    const MWI = 105;
    const MYS = 106;
    const MDV = 107;
    const MLI = 108;
    const MLT = 109;
    const MHL = 110;
    const MRT = 111;
    const MUS = 112;
    const MEX = 113;
    const FSM = 114;
    const MDA_PT = 115;
    const MDA_M = 285;
    const MCO = 116;
    const MNG = 117;
    const MNE = 118;
    const MAR = 119;
    const MOZ = 120;
    const MMR = 121;
    const NAM = 122;
    const NRU = 123;
    const NPL = 124;
    const NLD = 125;
    const NZL = 126;
    const NIC = 127;
    const NER = 128;
    const NGA = 129;
    const NOR = 130;
    const OMN = 131;
    const PAK = 132;
    const PLW = 133;
    const PAN = 134;
    const PNG = 135;
    const PRY = 136;
    const PER = 137;
    const PHL = 138;
    const POL = 139;
    const PRT = 140;
    const QAT = 141;
    const ROU = 142;
    const RUS = 143;
    const RWA = 144;
    const KNA = 145;
    const LCA = 146;
    const VCT = 147;
    const WSM = 148;
    const SMR = 149;
    const STP = 150;
    const SAU = 151;
    const SEN = 152;
    const SRB = 153;
    const SYC = 154;
    const SLE = 155;
    const SGP = 156;
    const SVK = 157;
    const SVN = 158;
    const SLB = 159;
    const SOM_L = 160;
    const SOM_S = 286;
    const ZAF = 161;
    const ESP = 162;
    const LKA = 163;
    const SDN = 164;
    const SUR = 165;
    const SWZ = 166;
    const SWE = 167;
    const CHE = 168;
    const SYR = 169;
    const TJK = 170;
    const TZA = 171;
    const THA = 172;
    const TLS = 173;
    const TGO = 174;
    const TON = 175;
    const TTO = 176;
    const TUN = 177;
    const TUR = 178;
    const TKM = 179;
    const TUV = 180;
    const UGA = 181;
    const UKR = 182;
    const ARE = 183;
    const GBR = 184;
    const USA = 185;
    const URY = 186;
    const UZB = 187;
    const VUT = 188;
    const VAT = 189;
    const VEN = 190;
    const VNM = 191;
    const YEM = 192;
    const ZMB = 193;
    const ZWE = 194;
    const TWN = 196;
    const CXR = 203;
    const CCK = 204;
    const HMD = 206;
    const NFK = 207;
    const NCL = 208;
    const PYF_FP = 209;
    const PYF_CI = 289;
    const MYT = 210;
    const GLP_SB = 211;
    const GLP_SM = 270;
    const GLP_G = 290;
    const SPM = 213;
    const WLF = 214;
    const ATF = 215;
    const BVT = 217;
    const COK = 218;
    const NIU = 219;
    const TKL = 220;
    const GGY = 221;
    const IMN = 222;
    const JEY = 223;
    const AIA = 224;
    const BMU = 225;
    const IOT = 226;
    const VGB = 228;
    const CYM = 229;
    const FLK = 230;
    const GIB = 231;
    const MSR = 232;
    const PCN = 233;
    const SHN = 234;
    const SGS = 235;
    const TCA = 236;
    const MNP = 237;
    const PRI = 238;
    const ASM = 239;
    const UMI_BI = 240;
    const UMI_HI = 271;
    const UMI_JI = 272;
    const UMI_JA = 273;
    const UMI_KR = 274;
    const UMI_MI = 275;
    const UMI_NA = 276;
    const UMI_NI = 277;
    const UMI_PA = 278;
    const UMI_WI = 279;
    const GUM = 241;
    const VIR = 249;
    const HKG = 251;
    const MAC = 252;
    const FRO = 253;
    const GRL = 254;
    const GUF = 255;
    const MTQ = 257;
    const REU = 258;
    const ALA = 259;
    const ABW = 260;
    const ANT = 261;
    const SJM = 262;
    const ASC = 263;
    const TAA = 264;
    const ATA_AAT = 265;
    const ATA_RD = 266;
    const ATA_PI = 267;
    const ATA_QML = 268;
    const ATA_BAT = 269;
    const AUT = 283;

    protected static $hasUuid = false;
    public $timestamps = true;
    protected $fillable = [
        'iso',
        'label',
        'id_currency',
        'iso3',
        'prefix'
    ];
    protected $guarded = [];

    public static function getCountriesLabelById() {
        $countriesById = [
            self::AFG => 'Afghanistan',
            self::ALB => 'Albania',
            self::DZA => 'Algeria',
            self::ANDO => 'Andorra',
            self::AGO => 'Angola',
            self::ATG => 'Antigua and Barbuda',
            self::ARG => 'Argentina',
            self::ARM => 'Armenia',
            self::AUS_A => 'Australia',
            self::AUT => 'Austria',
            self::AZE_A => 'Azerbaijan',
            self::BHS => 'Bahamas',
            self::BHR => 'Bahrain',
            self::BGD => 'Bangladesh',
            self::BRB => 'Barbados',
            self::BLR => 'Belarus',
            self::BEL => 'Belgium',
            self::BLZ => 'Belize',
            self::BEN => 'Benin',
            self::BTN => 'Bhutan',
            self::BOL => 'Bolivia',
            self::BIH => 'Bosnia and Herzegovina',
            self::BWA => 'Botswana',
            self::BRA => 'Brazil',
            self::BRN => 'Brunei',
            self::BGR => 'Bulgaria',
            self::BFA => 'Burkina Faso',
            self::BDI => 'Burundi',
            self::KHM => 'Cambodia',
            self::CMR => 'Cameroon',
            self::CAN => 'Canada',
            self::CPV => 'Cape Verde',
            self::CAF => 'Central African Republic',
            self::TCD => 'Chad',
            self::CHL => 'Chile',
            self::CHN => 'China',
            self::COL => 'Colombia',
            self::COM => 'Comoros',
            self::COD => 'Congo, (Congo Â– Kinshasa)',
            self::COG => 'Congo, (Congo Â– Brazzaville)',
            self::CRI => 'Costa Rica',
            self::CIV => 'Ivory Coast',
            self::HRV => 'Croatia',
            self::CUB => 'Cuba',
            self::CYP_C => 'Cyprus',
            self::CZE => 'Czech Republic',
            self::DNK => 'Denmark',
            self::DJI => 'Djibouti',
            self::DMA => 'Dominica',
            self::DOM => 'Dominican Republic',
            self::ECU => 'Ecuador',
            self::EGY => 'Egypt',
            self::SLV => 'El Salvador',
            self::GNQ => 'Equatorial Guinea',
            self::ERI => 'Eritrea',
            self::EST => 'Estonia',
            self::ETH => 'Ethiopia',
            self::FJI => 'Fiji',
            self::FIN => 'Finland',
            self::FRA => 'France',
            self::GAB => 'Gabon',
            self::GMB => 'Gambia, The',
            self::GEO_G => 'Georgia',
            self::DEU => 'Germany',
            self::GHA => 'Ghana',
            self::GRC => 'Greece',
            self::GRD => 'Grenada',
            self::GTM => 'Guatemala',
            self::GIN => 'Guinea',
            self::GNB => 'Guinea-Bissau',
            self::GUY => 'Guyana',
            self::HTI => 'Haiti',
            self::HND => 'Honduras',
            self::HUN => 'Hungary',
            self::ISL => 'Iceland',
            self::IND => 'India',
            self::IDN => 'Indonesia',
            self::IRN => 'Iran',
            self::IRQ => 'Iraq',
            self::IRL => 'Ireland',
            self::ISR => 'Israel',
            self::ITA => 'Italy',
            self::JAM => 'Jamaica',
            self::JPN => 'Japan',
            self::JOR => 'Jordan',
            self::KAZ => 'Kazakhstan',
            self::KEN => 'Kenya',
            self::KIR => 'Kiribati',
            self::PRK => 'Korea, North',
            self::KOR => 'Korea, South',
            self::KWT => 'Kuwait',
            self::KGZ => 'Kyrgyzstan',
            self::LAO => 'Laos',
            self::LVA => 'Latvia',
            self::LBN => 'Lebanon',
            self::LSO => 'Lesotho',
            self::LBR => 'Liberia',
            self::LBY => 'Libya',
            self::LIE => 'Liechtenstein',
            self::LTU => 'Lithuania',
            self::LUX => 'Luxembourg',
            self::MKD => 'Macedonia',
            self::MDG => 'Madagascar',
            self::MWI => 'Malawi',
            self::MYS => 'Malaysia',
            self::MDV => 'Maldives',
            self::MLI => 'Mali',
            self::MLT => 'Malta',
            self::MHL => 'Marshall Islands',
            self::MRT => 'Mauritania',
            self::MUS => 'Mauritius',
            self::MEX => 'Mexico',
            self::FSM => 'Micronesia',
            self::MDA_M => 'Moldova',
            self::MCO => 'Monaco',
            self::MNG => 'Mongolia',
            self::MNE => 'Montenegro',
            self::MAR => 'Morocco',
            self::MOZ => 'Mozambique',
            self::MMR => 'Myanmar (Burma)',
            self::NAM => 'Namibia',
            self::NRU => 'Nauru',
            self::NPL => 'Nepal',
            self::NLD => 'Netherlands',
            self::NZL => 'New Zealand',
            self::NIC => 'Nicaragua',
            self::NER => 'Niger',
            self::NGA => 'Nigeria',
            self::NOR => 'Norway',
            self::OMN => 'Oman',
            self::PAK => 'Pakistan',
            self::PLW => 'Palau',
            self::PAN => 'Panama',
            self::PNG => 'Papua New Guinea',
            self::PRY => 'Paraguay',
            self::PER => 'Peru',
            self::PHL => 'Philippines',
            self::POL => 'Poland',
            self::PRT => 'Portugal',
            self::QAT => 'Qatar',
            self::ROU => 'Romania',
            self::RUS => 'Russia',
            self::RWA => 'Rwanda',
            self::KNA => 'Saint Kitts and Nevis',
            self::LCA => 'Saint Lucia',
            self::VCT => 'Saint Vincent and the Grenadines',
            self::WSM => 'Samoa',
            self::SMR => 'San Marino',
            self::STP => 'Sao Tome and Principe',
            self::SAU => 'Saudi Arabia',
            self::SEN => 'Senegal',
            self::SRB => 'Serbia',
            self::SYC => 'Seychelles',
            self::SLE => 'Sierra Leone',
            self::SGP => 'Singapore',
            self::SVK => 'Slovakia',
            self::SVN => 'Slovenia',
            self::SLB => 'Solomon Islands',
            self::SOM_S => 'Somalia',
            self::ZAF => 'South Africa',
            self::ESP => 'Spain',
            self::LKA => 'Sri Lanka',
            self::SDN => 'Sudan',
            self::SUR => 'Suriname',
            self::SWZ => 'Swaziland',
            self::SWE => 'Sweden',
            self::CHE => 'Switzerland',
            self::SYR => 'Syria',
            self::TJK => 'Tajikistan',
            self::TZA => 'Tanzania',
            self::THA => 'Thailand',
            self::TLS => 'Timor-Leste (East Timor)',
            self::TGO => 'Togo',
            self::TON => 'Tonga',
            self::TTO => 'Trinidad and Tobago',
            self::TUN => 'Tunisia',
            self::TUR => 'Turkey',
            self::TKM => 'Turkmenistan',
            self::TUV => 'Tuvalu',
            self::UGA => 'Uganda',
            self::UKR => 'Ukraine',
            self::ARE => 'United Arab Emirates',
            self::GBR => 'United Kingdom',
            self::USA => 'United States',
            self::URY => 'Uruguay',
            self::UZB => 'Uzbekistan',
            self::VUT => 'Vanuatu',
            self::VAT => 'Vatican City',
            self::VEN => 'Venezuela',
            self::VNM => 'Vietnam',
            self::YEM => 'Yemen',
            self::ZMB => 'Zambia',
            self::ZWE => 'Zimbabwe',
            self::GEO_A => 'Abkhazia',
            self::TWN => 'China, Republic of (Taiwan)',
            self::AZE_NK => 'Nagorno-Karabakh',
            self::CYP_NC => 'Northern Cyprus',
            self::MDA_PT => 'Pridnestrovie',
            self::SOM_L => 'Somaliland',
            self::GEO_SO => 'South Ossetia',
            self::AUS_ACI => 'Ashmore and Cartier Islands',
            self::CXR => 'Christmas Island',
            self::CCK => 'Cocos (Keeling) Islands',
            self::AUS_CSI => 'Coral Sea Islands',
            self::HMD => 'Heard Island and McDonald Islands',
            self::NFK => 'Norfolk Island',
            self::NCL => 'New Caledonia',
            self::PYF_FP => 'French Polynesia',
            self::MYT => 'Mayotte',
            self::GLP_SB => 'Saint Barthelemy',
            self::GLP_SM => 'Saint Martin',
            self::GLP_G => 'Guadeloupe',
            self::SPM => 'Saint Pierre and Miquelon',
            self::WLF => 'Wallis and Futuna',
            self::ATF => 'French Southern and Antarctic Lands',
            self::PYF_CI => 'Clipperton Island',
            self::BVT => 'Bouvet Island',
            self::COK => 'Cook Islands',
            self::NIU => 'Niue',
            self::TKL => 'Tokelau',
            self::GGY => 'Guernsey',
            self::IMN => 'Isle of Man',
            self::JEY => 'Jersey',
            self::AIA => 'Anguilla',
            self::BMU => 'Bermuda',
            self::IOT => 'British Indian Ocean Territory',
            self::VGB => 'British Virgin Islands',
            self::CYM => 'Cayman Islands',
            self::FLK => 'Falkland Islands (Islas Malvinas)',
            self::GIB => 'Gibraltar',
            self::MSR => 'Montserrat',
            self::PCN => 'Pitcairn Islands',
            self::SHN => 'Saint Helena',
            self::SGS => 'South Georgia & South Sandwich Islands',
            self::TCA => 'Turks and Caicos Islands',
            self::MNP => 'Northern Mariana Islands',
            self::PRI => 'Puerto Rico',
            self::ASM => 'American Samoa',
            self::UMI_BI => 'Baker Island',
            self::GUM => 'Guam',
            self::UMI_HI => 'Howland Island',
            self::UMI_JI => 'Jarvis Island',
            self::UMI_JA => 'Johnston Atoll',
            self::UMI_KR => 'Kingman Reef',
            self::UMI_MI => 'Midway Islands',
            self::UMI_NI => 'Navassa Island',
            self::UMI_PA => 'Palmyra Atoll',
            self::VIR => 'U.S. Virgin Islands',
            self::UMI_WI => 'Wake Island',
            self::HKG => 'Hong Kong',
            self::MAC => 'Macau',
            self::FRO => 'Faroe Islands',
            self::GRL => 'Greenland',
            self::GUF => 'French Guiana',
            self::MTQ => 'Martinique',
            self::REU => 'Reunion',
            self::ALA => 'Aland',
            self::ABW => 'Aruba',
            self::ANT => 'Netherlands Antilles',
            self::SJM => 'Svalbard',
            self::ASC => 'Ascension',
            self::TAA => 'Tristan da Cunha',
            self::ATA_AAT => 'Australian Antarctic Territory',
            self::ATA_RD => 'Ross Dependency',
            self::ATA_PI => 'Peter I Island',
            self::ATA_QML => 'Queen Maud Land',
            self::ATA_BAT => 'British Antarctic Territory',
        ];
        return $countriesById;
    }

    public static function getCountryLabel($id_country) {
        $label = null;
        $countriesById = self::getCountriesLabelById();
        if (isset($countriesById[$id_country])) {
            $label = $countriesById[$id_country];
        }
        return $label;
    }

    /**
     * @return mixed
     */
    public function getIso() {
        return $this->iso;
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
    public function getIdCurrency() {
        return $this->id_currency;
    }

    /**
     * @return mixed
     */
    public function getIso3() {
        return $this->iso3;
    }

    /**
     * @return mixed
     */
    public function getPrefix() {
        return $this->prefix;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIso($value) {
        $this->iso = $value;
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
    public function setIdCurrency($value) {
        $this->id_currency = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIso3($value) {
        $this->iso3 = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setPrefix($value) {
        $this->prefix = $value;
        return $this;
    }

}
