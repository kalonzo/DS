<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder {

    private static $locationArray = array();

    public static function formattLocationIndex() {
        
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
   

    public static function insertCurrency($id, $symbol, $short_label, $label) {

        if ($id == null) {
            $id = \App\Utilities\UuidTools::generateUuid();
        }


        DB::table('currencies')->insert([
            'id' => $id,
            'symbol' => $symbol, //créer une constante pour le genre 
            'short_label' => $short_label,
            'label' => $label
        ]);
    }

    public static function insertCountries($id, $iso2, $iso3, $label, $prefix, $id_currency) {

        if ($id == null) {
            $id = \App\Utilities\UuidTools::generateUuid();
        }

        DB::table('countries')->insert([
            'id' => $id,
            'iso' => $iso2, //créer une constante pour le genre 
            'iso3' => $iso3,
            'label' => $label,
            'prefix' => $prefix,
            'id_currency' => $id_currency
        ]);
    }
    
    function run() {


        //id fixe pour les currency
        $id_eur = \App\Utilities\UuidTools::generateUuid();
        $id_chf = \App\Utilities\UuidTools::generateUuid();

        $id_swiss = \App\Utilities\UuidTools::generateUuid();
        $id_france = \App\Utilities\UuidTools::generateUuid();


                self::insertCurrency(null, '', 'AED', 'UAE Dirham');
                self::insertCurrency(null, '؋', 'AFN', 'Afghani');
                self::insertCurrency(null, 'Lek', 'ALL', 'Lek');
                self::insertCurrency(null, '', 'AMD', 'Armenian Dram');
                self::insertCurrency(null, 'ƒ', 'ANG', 'Netherlands Antillian Guilder');
                self::insertCurrency(null, '', 'AOA', 'Kwanza');
                self::insertCurrency(null, '$', 'ARS', 'Argentine Peso');
                self::insertCurrency(null, '$', 'AUD', 'Australian Dollar');
                self::insertCurrency(null, 'ƒ', 'AWG', 'Aruban Guilder');
                self::insertCurrency(null, 'ман', 'AZN', 'Azerbaijanian Manat');
                self::insertCurrency(null, 'KM', 'BAM', 'Convertible Marks');
                self::insertCurrency(null, '$', 'BBD', 'Barbados Dollar');
                self::insertCurrency(null, '', 'BDT', 'Taka');
                self::insertCurrency(null, 'лв', 'BGN', 'Bulgarian Lev');
                self::insertCurrency(null, '', 'BHD', 'Bahraini Dinar');
                self::insertCurrency(null, '', 'BIF', 'Burundi Franc');
                self::insertCurrency(null, '$', 'BMD', 'Bermudian Dollar (customarily known as Bermuda Dollar)');
                self::insertCurrency(null, '$', 'BND', 'Brunei Dollar');
                self::insertCurrency(null, '$b', 'BOB', 'Boliviano Mvdol');
                self::insertCurrency(null, 'R$', 'BRL', 'Brazilian Real');
                self::insertCurrency(null, '$', 'BSD', 'Bahamian Dollar');
                self::insertCurrency(null, 'P', 'BWP', 'Pula');
                self::insertCurrency(null, 'p.', 'BYR', 'Belarussian Ruble');
                self::insertCurrency(null, 'BZ$', 'BZD', 'Belize Dollar');
                self::insertCurrency(null, '$', 'CAD', 'Canadian Dollar');
                self::insertCurrency(null, '', 'CDF', 'Congolese Franc');
                self::insertCurrency($id_chf, 'CHF', 'CHF', 'Swiss Franc');
                self::insertCurrency(null, '$', 'CLP', 'Chilean Peso Unidades de fomento');
                self::insertCurrency(null, '¥', 'CNY', 'Yuan Renminbi');
                self::insertCurrency(null, '$', 'COP', 'Colombian Peso Unidad de Valor Real');
                self::insertCurrency(null, '₡', 'CRC', 'Costa Rican Colon');
                self::insertCurrency(null, '₱', 'CUP', 'Cuban Peso Peso Convertible');
                self::insertCurrency(null, '', 'CVE', 'Cape Verde Escudo');
                self::insertCurrency(null, 'Kč', 'CZK', 'Czech Koruna');
                self::insertCurrency(null, '', 'DJF', 'Djibouti Franc');
                self::insertCurrency(null, 'kr', 'DKK', 'Danish Krone');
                self::insertCurrency(null, 'RD$', 'DOP', 'Dominican Peso');
                self::insertCurrency(null, '', 'DZD', 'Algerian Dinar');
                self::insertCurrency(null, '', 'EEK', 'Kroon');
                self::insertCurrency(null, '£', 'EGP', 'Egyptian Pound');
                self::insertCurrency(null, '', 'ERN', 'Nakfa');
                self::insertCurrency(null, '', 'ETB', 'Ethiopian Birr');
                self::insertCurrency($id_eur, '€', 'EUR', 'Euro');
                self::insertCurrency(null, '$', 'FJD', 'Fiji Dollar');
                self::insertCurrency(null, '£', 'FKP', 'Falkland Islands Pound');
                self::insertCurrency(null, '£', 'GBP', 'Pound Sterling');
                self::insertCurrency(null, '', 'GEL', 'Lari');
                self::insertCurrency(null, '', 'GHS', 'Cedi');
                self::insertCurrency(null, '£', 'GIP', 'Gibraltar Pound');
                self::insertCurrency(null, '', 'GMD', 'Dalasi');
                self::insertCurrency(null, '', 'GNF', 'Guinea Franc');
                self::insertCurrency(null, 'Q', 'GTQ', 'Quetzal');
                self::insertCurrency(null, '$', 'GYD', 'Guyana Dollar');
                self::insertCurrency(null, '$', 'HKD', 'Hong Kong Dollar');
                self::insertCurrency(null, 'L', 'HNL', 'Lempira');
                self::insertCurrency(null, 'kn', 'HRK', 'Croatian Kuna');
                self::insertCurrency(null, '', 'USD', 'Gourde US Dollar');
                self::insertCurrency(null, 'Ft', 'HUF', 'Forint');
                self::insertCurrency(null, 'Rp', 'IDR', 'Rupiah');
                self::insertCurrency(null, '₪', 'ILS', 'New Israeli Sheqel');
                self::insertCurrency(null, '', 'INR', 'Indian Rupee');
                self::insertCurrency(null, '', 'INR', 'Indian Rupee Ngultrum');
                self::insertCurrency(null, '', 'IQD', 'Iraqi Dinar');
                self::insertCurrency(null, '﷼', 'IRR', 'Iranian Rial');
                self::insertCurrency(null, 'kr', 'ISK', 'Iceland Krona');
                self::insertCurrency(null, 'J$', 'JMD', 'Jamaican Dollar');
                self::insertCurrency(null, '', 'JOD', 'Jordanian Dinar');
                self::insertCurrency(null, '¥', 'JPY', 'Yen');
                self::insertCurrency(null, '', 'KES', 'Kenyan Shilling');
                self::insertCurrency(null, 'лв', 'KGS', 'Som');
                self::insertCurrency(null, '៛', 'KHR', 'Riel');
                self::insertCurrency(null, '', 'KMF', 'Comoro Franc');
                self::insertCurrency(null, '₩', 'KPW', 'North Korean Won');
                self::insertCurrency(null, '₩', 'KRW', 'Won');
                self::insertCurrency(null, '', 'KWD', 'Kuwaiti Dinar');
                self::insertCurrency(null, '$', 'KYD', 'Cayman Islands Dollar');
                self::insertCurrency(null, 'лв', 'KZT', 'Tenge');
                self::insertCurrency(null, '₭', 'LAK', 'Kip');
                self::insertCurrency(null, '£', 'LBP', 'Lebanese Pound');
                self::insertCurrency(null, '₨', 'LKR', 'Sri Lanka Rupee');
                self::insertCurrency(null, '$', 'LRD', 'Liberian Dollar');
                self::insertCurrency(null, 'Lt', 'LTL', 'Lithuanian Litas');
                self::insertCurrency(null, 'Ls', 'LVL', 'Latvian Lats');
                self::insertCurrency(null, '', 'LYD', 'Libyan Dinar');
                self::insertCurrency(null, '', 'MAD', 'Moroccan Dirham');
                self::insertCurrency(null, '', 'MDL', 'Moldovan Leu');
                self::insertCurrency(null, '', 'MGA', 'Malagasy Ariary');
                self::insertCurrency(null, 'ден', 'MKD', 'Denar');
                self::insertCurrency(null, '', 'MMK', 'Kyat');
                self::insertCurrency(null, '₮', 'MNT', 'Tugrik');
                self::insertCurrency(null, '', 'MOP', 'Pataca');
                self::insertCurrency(null, '', 'MRO', 'Ouguiya');
                self::insertCurrency(null, '₨', 'MUR', 'Mauritius Rupee');
                self::insertCurrency(null, '', 'MVR', 'Rufiyaa');
                self::insertCurrency(null, '', 'MWK', 'Kwacha');
                self::insertCurrency(null, '$', 'MXN', 'Mexican Peso Mexican Unidad de Inversion (UDI)');
                self::insertCurrency(null, 'RM', 'MYR', 'Malaysian Ringgit');
                self::insertCurrency(null, 'MT', 'MZN', 'Metical');
                self::insertCurrency(null, '₦', 'NGN', 'Naira');
                self::insertCurrency(null, 'C$', 'NIO', 'Cordoba Oro');
                self::insertCurrency(null, 'kr', 'NOK', 'Norwegian Krone');
                self::insertCurrency(null, '₨', 'NPR', 'Nepalese Rupee');
                self::insertCurrency(null, '$', 'NZD', 'New Zealand Dollar');
                self::insertCurrency(null, '﷼', 'OMR', 'Rial Omani');
                self::insertCurrency(null, 'B/.', 'USD', 'Balboa US Dollar');
                self::insertCurrency(null, 'S/.', 'PEN', 'Nuevo Sol');
                self::insertCurrency(null, '', 'PGK', 'Kina');
                self::insertCurrency(null, 'Php', 'PHP', 'Philippine Peso');
                self::insertCurrency(null, '₨', 'PKR', 'Pakistan Rupee');
                self::insertCurrency(null, 'zł', 'PLN', 'Zloty');
                self::insertCurrency(null, 'Gs', 'PYG', 'Guarani');
                self::insertCurrency(null, '﷼', 'QAR', 'Qatari Rial');
                self::insertCurrency(null, 'lei', 'RON', 'New Leu');
                self::insertCurrency(null, 'Дин.', 'RSD', 'Serbian Dinar');
                self::insertCurrency(null, 'руб', 'RUB', 'Russian Ruble');
                self::insertCurrency(null, '', 'RWF', 'Rwanda Franc');
                self::insertCurrency(null, '﷼', 'SAR', 'Saudi Riyal');
                self::insertCurrency(null, '$', 'SBD', 'Solomon Islands Dollar');
                self::insertCurrency(null, '₨', 'SCR', 'Seychelles Rupee');
                self::insertCurrency(null, '', 'SDG', 'Sudanese Pound');
                self::insertCurrency(null, 'kr', 'SEK', 'Swedish Krona');
                self::insertCurrency(null, '$', 'SGD', 'Singapore Dollar');
                self::insertCurrency(null, '£', 'SHP', 'Saint Helena Pound');
                self::insertCurrency(null, '', 'SLL', 'Leone');
                self::insertCurrency(null, 'S', 'SOS', 'Somali Shilling');
                self::insertCurrency(null, '$', 'SRD', 'Surinam Dollar');
                self::insertCurrency(null, '', 'STD', 'Dobra');
                self::insertCurrency(null, '$', 'USD', 'El Salvador Colon US Dollar');
                self::insertCurrency(null, '£', 'SYP', 'Syrian Pound');
                self::insertCurrency(null, '', 'SZL', 'Lilangeni');
                self::insertCurrency(null, '฿', 'THB', 'Baht');
                self::insertCurrency(null, '', 'TJS', 'Somoni');
                self::insertCurrency(null, '', 'TMT', 'Manat');
                self::insertCurrency(null, '', 'TND', 'Tunisian Dinar');
                self::insertCurrency(null, '', 'TOP', 'Pa\'anga');
                self::insertCurrency(null, 'TL', 'TRY', 'Turkish Lira');
                self::insertCurrency(null, 'TT$', 'TTD', 'Trinidad and Tobago Dollar');
                self::insertCurrency(null, 'NT$', 'TWD', 'New Taiwan Dollar');
                self::insertCurrency(null, '', 'TZS', 'Tanzanian Shilling');
                self::insertCurrency(null, '₴', 'UAH', 'Hryvnia');
                self::insertCurrency(null, '', 'UGX', 'Uganda Shilling');
                self::insertCurrency(null, '$', 'USD', 'US Dollar');
                self::insertCurrency(null, '$U', 'UYU', 'Peso Uruguayo Uruguay Peso en Unidades Indexadas');
                self::insertCurrency(null, 'лв', 'UZS', 'Uzbekistan Sum');
                self::insertCurrency(null, 'Bs', 'VEF', 'Bolivar Fuerte');
                self::insertCurrency(null, '₫', 'VND', 'Dong');
                self::insertCurrency(null, '', 'VUV', 'Vatu');
                self::insertCurrency(null, '', 'WST', 'Tala');
                self::insertCurrency(null, '', 'XAF', 'CFA Franc BEAC');
                self::insertCurrency(null, '', 'XAG', 'Silver');
                self::insertCurrency(null, '', 'XAU', 'Gold');
                self::insertCurrency(null, '', 'XBA', 'Bond Markets Units European Composite Unit (EURCO)');
                self::insertCurrency(null, '', 'XBB', 'European Monetary Unit (E.M.U.-6)');
                self::insertCurrency(null, '', 'XBC', 'European Unit of Account 9(E.U.A.-9)');
                self::insertCurrency(null, '', 'XBD', 'European Unit of Account 17(E.U.A.-17)');
                self::insertCurrency(null, '$', 'XCD', 'East Caribbean Dollar');
                self::insertCurrency(null, '', 'XDR', 'SDR');
                self::insertCurrency(null, '', 'XFU', 'UIC-Franc');
                self::insertCurrency(null, '', 'XOF', 'CFA Franc BCEAO');
                self::insertCurrency(null, '', 'XPD', 'Palladium');
                self::insertCurrency(null, '', 'XPF', 'CFP Franc');
                self::insertCurrency(null, '', 'XPT', 'Platinum');
                self::insertCurrency(null, '', 'XTS', 'Codes specifically reserved for testing purposes');
                self::insertCurrency(null, '﷼', 'YER', 'Yemeni Rial');
                self::insertCurrency(null, 'R', 'ZAR', 'Rand');
                self::insertCurrency(null, '', 'ZAR', 'Rand Loti');
                self::insertCurrency(null, '', 'ZAR', 'Rand Namibia Dollar');
                self::insertCurrency(null, '', 'ZMK', 'Zambian Kwacha');
                self::insertCurrency(null, '', 'ZWL', 'Zimbabwe Dollar');

                self::insertCountries(null, 'AF', 'AFG', 'Afghanistan', 93, 0);
                self::insertCountries(null, 'AL', 'ALB', 'Albania', 355, 0);
                self::insertCountries(null, 'DZ', 'DZA', 'Algeria', 213, 0);
                self::insertCountries(null, 'AD', 'AND', 'Andorra', 376, 0);
                self::insertCountries(null, 'AO', 'AGO', 'Angola', 244, 0);
                self::insertCountries(null, 'AG', 'ATG', 'Antigua and Barbuda', -267, 0);
                self::insertCountries(null, 'AR', 'ARG', 'Argentina', 54, 0);
                self::insertCountries(null, 'AM', 'ARM', 'Armenia', 374, 0);
                self::insertCountries(null, 'AU', 'AUS', 'Australia', 61, 0);
                self::insertCountries(null, 'AT', 'AUT', 'Austria', 43, 0);
                self::insertCountries(null, 'AZ', 'AZE', 'Azerbaijan', 994, 0);
                self::insertCountries(null, 'BS', 'BHS', 'Bahamas, The', -241, 0);
                self::insertCountries(null, 'BH', 'BHR', 'Bahrain', 973, 0);
                self::insertCountries(null, 'BD', 'BGD', 'Bangladesh', 880, 0);
                self::insertCountries(null, 'BB', 'BRB', 'Barbados', -245, 0);
                self::insertCountries(null, 'BY', 'BLR', 'Belarus', 375, 0);
                self::insertCountries(null, 'BE', 'BEL', 'Belgium', 32, 0);
                self::insertCountries(null, 'BZ', 'BLZ', 'Belize', 501, 0);
                self::insertCountries(null, 'BJ', 'BEN', 'Benin', 229, 0);
                self::insertCountries(null, 'BT', 'BTN', 'Bhutan', 975, 0);
                self::insertCountries(null, 'BO', 'BOL', 'Bolivia', 591, 0);
                self::insertCountries(null, 'BA', 'BIH', 'Bosnia and Herzegovina', 387, 0);
                self::insertCountries(null, 'BW', 'BWA', 'Botswana', 267, 0);
                self::insertCountries(null, 'BR', 'BRA', 'Brazil', 55, 0);
                self::insertCountries(null, 'BN', 'BRN', 'Brunei', 673, 0);
                self::insertCountries(null, 'BG', 'BGR', 'Bulgaria', 359, 0);
                self::insertCountries(null, 'BF', 'BFA', 'Burkina Faso', 226, 0);
                self::insertCountries(null, 'BI', 'BDI', 'Burundi', 257, 0);
                self::insertCountries(null, 'KH', 'KHM', 'Cambodia', 855, 0);
                self::insertCountries(null, 'CM', 'CMR', 'Cameroon', 237, 0);
                self::insertCountries(null, 'CA', 'CAN', 'Canada', 1, 0);
                self::insertCountries(null, 'CV', 'CPV', 'Cape Verde', 238, 0);
                self::insertCountries(null, 'CF', 'CAF', 'Central African Republic', 236, 0);
                self::insertCountries(null, 'TD', 'TCD', 'Chad', 235, 0);
                self::insertCountries(null, 'CL', 'CHL', 'Chile', 56, 0);
                self::insertCountries(null, 'CN', 'CHN', 'China', 86, 0);
                self::insertCountries(null, 'CO', 'COL', 'Colombia', 57, 0);
                self::insertCountries(null, 'KM', 'COM', 'Comoros', 269, 0);
                self::insertCountries(null, 'CD', 'COD', 'Congo, (Congo Â– Kinshasa)', 243, 0);
                self::insertCountries(null, 'CG', 'COG', 'Congo, (Congo Â– Brazzaville)', 242, 0);
                self::insertCountries(null, 'CR', 'CRI', 'Costa Rica', 506, 0);
                self::insertCountries(null, 'CI', 'CIV', 'Cote d\'Ivoire (Ivory Coast)', 225, 0);
                self::insertCountries(null, 'HR', 'HRV', 'Croatia', 385, 0);
                self::insertCountries(null, 'CU', 'CUB', 'Cuba', 53, 0);
                self::insertCountries(null, 'CY', 'CYP', 'Cyprus', 357, 0);
                self::insertCountries(null, 'CZ', 'CZE', 'Czech Republic', 420, 0);
                self::insertCountries(null, 'DK', 'DNK', 'Denmark', 45, 0);
                self::insertCountries(null, 'DJ', 'DJI', 'Djibouti', 253, 0);
                self::insertCountries(null, 'DM', 'DMA', 'Dominica', -766, 0);
                self::insertCountries(null, 'DO', 'DOM', 'Dominican Republic', +1 - 809 and 1 - 829, 0);
                self::insertCountries(null, 'EC', 'ECU', 'Ecuador', 593, 0);
                self::insertCountries(null, 'EG', 'EGY', 'Egypt', 20, 0);
                self::insertCountries(null, 'SV', 'SLV', 'El Salvador', 503, 0);
                self::insertCountries(null, 'GQ', 'GNQ', 'Equatorial Guinea', 240, 0);
                self::insertCountries(null, 'ER', 'ERI', 'Eritrea', 291, 0);
                self::insertCountries(null, 'EE', 'EST', 'Estonia', 372, 0);
                self::insertCountries(null, 'ET', 'ETH', 'Ethiopia', 251, 0);
                self::insertCountries(null, 'FJ', 'FJI', 'Fiji', 679, 0);
                self::insertCountries(null, 'FI', 'FIN', 'Finland', 358, 0);
                self::insertCountries($id_france, 'FR', 'FRA', 'France', 33, $id_eur);      
       
                self::insertCountries(null, 'GA', 'GAB', 'Gabon', 241, 0);
                self::insertCountries(null, 'GM', 'GMB', 'Gambia, The', 220, 0);
                self::insertCountries(null, 'GE', 'GEO', 'Georgia', 995, 0);
                self::insertCountries(null, 'DE', 'DEU', 'Germany', 49, 0);
                self::insertCountries(null, 'GH', 'GHA', 'Ghana', 233, 0);
                self::insertCountries(null, 'GR', 'GRC', 'Greece', 30, 0);
                self::insertCountries(null, 'GD', 'GRD', 'Grenada', -472, 0);
                self::insertCountries(null, 'GT', 'GTM', 'Guatemala', 502, 0);
                self::insertCountries(null, 'GN', 'GIN', 'Guinea', 224, 0);
                self::insertCountries(null, 'GW', 'GNB', 'Guinea-Bissau', 245, 0);
                self::insertCountries(null, 'GY', 'GUY', 'Guyana', 592, 0);
                self::insertCountries(null, 'HT', 'HTI', 'Haiti', 509, 0);
                self::insertCountries(null, 'HN', 'HND', 'Honduras', 504, 0);
                self::insertCountries(null, 'HU', 'HUN', 'Hungary', 36, 0);
                self::insertCountries(null, 'IS', 'ISL', 'Iceland', 354, 0);
                self::insertCountries(null, 'IN', 'IND', 'India', 91, 0);
                self::insertCountries(null, 'ID', 'IDN', 'Indonesia', 62, 0);
                self::insertCountries(null, 'IR', 'IRN', 'Iran', 98, 0);
                self::insertCountries(null, 'IQ', 'IRQ', 'Iraq', 964, 0);
                self::insertCountries(null, 'IE', 'IRL', 'Ireland', 353, 0);
                self::insertCountries(null, 'IL', 'ISR', 'Israel', 972, 0);
                self::insertCountries(null, 'IT', 'ITA', 'Italy', 39, 0);
                self::insertCountries(null, 'JM', 'JAM', 'Jamaica', -875, 0);
                self::insertCountries(null, 'JP', 'JPN', 'Japan', 81, 0);
                self::insertCountries(null, 'JO', 'JOR', 'Jordan', 962, 0);
                self::insertCountries(null, 'KZ', 'KAZ', 'Kazakhstan', 7, 0);
                self::insertCountries(null, 'KE', 'KEN', 'Kenya', 254, 0);
                self::insertCountries(null, 'KI', 'KIR', 'Kiribati', 686, 0);
                self::insertCountries(null, 'KP', 'PRK', 'Korea, North', 850, 0);
                self::insertCountries(null, 'KR', 'KOR', 'Korea, South', 82, 0);
                self::insertCountries(null, 'KW', 'KWT', 'Kuwait', 965, 0);
                self::insertCountries(null, 'KG', 'KGZ', 'Kyrgyzstan', 996, 0);
                self::insertCountries(null, 'LA', 'LAO', 'Laos', 856, 0);
                self::insertCountries(null, 'LV', 'LVA', 'Latvia', 371, 0);
                self::insertCountries(null, 'LB', 'LBN', 'Lebanon', 961, 0);
                self::insertCountries(null, 'LS', 'LSO', 'Lesotho', 266, 0);
                self::insertCountries(null, 'LR', 'LBR', 'Liberia', 231, 0);
                self::insertCountries(null, 'LY', 'LBY', 'Libya', 218, 0);
                self::insertCountries(null, 'LI', 'LIE', 'Liechtenstein', 423, 0);
                self::insertCountries(null, 'LT', 'LTU', 'Lithuania', 370, 0);
                self::insertCountries(null, 'LU', 'LUX', 'Luxembourg', 352, 0);
                self::insertCountries(null, 'MK', 'MKD', 'Macedonia', 389, 0);
                self::insertCountries(null, 'MG', 'MDG', 'Madagascar', 261, 0);
                self::insertCountries(null, 'MW', 'MWI', 'Malawi', 265, 0);
                self::insertCountries(null, 'MY', 'MYS', 'Malaysia', 60, 0);
                self::insertCountries(null, 'MV', 'MDV', 'Maldives', 960, 0);
                self::insertCountries(null, 'ML', 'MLI', 'Mali', 223, 0);
                self::insertCountries(null, 'MT', 'MLT', 'Malta', 356, 0);
                self::insertCountries(null, 'MH', 'MHL', 'Marshall Islands', 692, 0);
                self::insertCountries(null, 'MR', 'MRT', 'Mauritania', 222, 0);
                self::insertCountries(null, 'MU', 'MUS', 'Mauritius', 230, 0);
                self::insertCountries(null, 'MX', 'MEX', 'Mexico', 52, 0);
                self::insertCountries(null, 'FM', 'FSM', 'Micronesia', 691, 0);
                self::insertCountries(null, 'MD', 'MDA', 'Moldova', 373, 0);
                self::insertCountries(null, 'MC', 'MCO', 'Monaco', 377, 0);
                self::insertCountries(null, 'MN', 'MNG', 'Mongolia', 976, 0);
                self::insertCountries(null, 'ME', 'MNE', 'Montenegro', 382, 0);
                self::insertCountries(null, 'MA', 'MAR', 'Morocco', 212, 0);
                self::insertCountries(null, 'MZ', 'MOZ', 'Mozambique', 258, 0);
                self::insertCountries(null, 'MM', 'MMR', 'Myanmar (Burma)', 95, 0);
                self::insertCountries(null, 'NA', 'NAM', 'Namibia', 264, 0);
                self::insertCountries(null, 'NR', 'NRU', 'Nauru', 674, 0);
                self::insertCountries(null, 'NP', 'NPL', 'Nepal', 977, 0);
                self::insertCountries(null, 'NL', 'NLD', 'Netherlands', 31, 0);
                self::insertCountries(null, 'NZ', 'NZL', 'New Zealand', 64, 0);
                self::insertCountries(null, 'NI', 'NIC', 'Nicaragua', 505, 0);
                self::insertCountries(null, 'NE', 'NER', 'Niger', 227, 0);
                self::insertCountries(null, 'NG', 'NGA', 'Nigeria', 234, 0);
                self::insertCountries(null, 'NO', 'NOR', 'Norway', 47, 0);
                self::insertCountries(null, 'OM', 'OMN', 'Oman', 968, 0);
                self::insertCountries(null, 'PK', 'PAK', 'Pakistan', 92, 0);
                self::insertCountries(null, 'PW', 'PLW', 'Palau', 680, 0);
                self::insertCountries(null, 'PA', 'PAN', 'Panama', 507, 0);
                self::insertCountries(null, 'PG', 'PNG', 'Papua New Guinea', 675, 0);
                self::insertCountries(null, 'PY', 'PRY', 'Paraguay', 595, 0);
                self::insertCountries(null, 'PE', 'PER', 'Peru', 51, 0);
                self::insertCountries(null, 'PH', 'PHL', 'Philippines', 63, 0);
                self::insertCountries(null, 'PL', 'POL', 'Poland', 48, 0);
                self::insertCountries(null, 'PT', 'PRT', 'Portugal', 351, 0);
                self::insertCountries(null, 'QA', 'QAT', 'Qatar', 974, 0);
                self::insertCountries(null, 'RO', 'ROU', 'Romania', 40, 0);
                self::insertCountries(null, 'RU', 'RUS', 'Russia', 7, 0);
                self::insertCountries(null, 'RW', 'RWA', 'Rwanda', 250, 0);
                self::insertCountries(null, 'KN', 'KNA', 'Saint Kitts and Nevis', -868, 0);
                self::insertCountries(null, 'LC', 'LCA', 'Saint Lucia', -757, 0);
                self::insertCountries(null, 'VC', 'VCT', 'Saint Vincent and the Grenadines', -783, 0);
                self::insertCountries(null, 'WS', 'WSM', 'Samoa', 685, 0);
                self::insertCountries(null, 'SM', 'SMR', 'San Marino', 378, 0);
                self::insertCountries(null, 'ST', 'STP', 'Sao Tome and Principe', 239, 0);
                self::insertCountries(null, 'SA', 'SAU', 'Saudi Arabia', 966, 0);
                self::insertCountries(null, 'SN', 'SEN', 'Senegal', 221, 0);
                self::insertCountries(null, 'RS', 'SRB', 'Serbia', 381, 0);
                self::insertCountries(null, 'SC', 'SYC', 'Seychelles', 248, 0);
                self::insertCountries(null, 'SL', 'SLE', 'Sierra Leone', 232, 0);
                self::insertCountries(null, 'SG', 'SGP', 'Singapore', 65, 0);
                self::insertCountries(null, 'SK', 'SVK', 'Slovakia', 421, 0);
                self::insertCountries(null, 'SI', 'SVN', 'Slovenia', 386, 0);
                self::insertCountries(null, 'SB', 'SLB', 'Solomon Islands', 677, 0);
                self::insertCountries(null, 'SO', 'SOM', 'Somalia', 252, 0);
                self::insertCountries(null, 'ZA', 'ZAF', 'South Africa', 27, 0);
                self::insertCountries(null, 'ES', 'ESP', 'Spain', 34, 0);
                self::insertCountries(null, 'LK', 'LKA', 'Sri Lanka', 94, 0);
                self::insertCountries(null, 'SD', 'SDN', 'Sudan', 249, 0);
                self::insertCountries(null, 'SR', 'SUR', 'Suriname', 597, 0);
                self::insertCountries(null, 'SZ', 'SWZ', 'Swaziland', 268, 0);
                self::insertCountries(null, 'SE', 'SWE', 'Sweden', 46, 0);
                self::insertCountries($id_swiss, 'CH', 'CHE', 'Switzerland', 41, $id_chf);

              
        
        self::insertCountries(null, 'SY', 'SYR', 'Syria', 963, 0);
        self::insertCountries(null, 'TJ', 'TJK', 'Tajikistan', 992, 0);
        self::insertCountries(null, 'TZ', 'TZA', 'Tanzania', 255, 0);
        self::insertCountries(null, 'TH', 'THA', 'Thailand', 66, 0);
        self::insertCountries(null, 'TL', 'TLS', 'Timor-Leste (East Timor)', 670, 0);
        self::insertCountries(null, 'TG', 'TGO', 'Togo', 228, 0);
        self::insertCountries(null, 'TO', 'TON', 'Tonga', 676, 0);
        self::insertCountries(null, 'TT', 'TTO', 'Trinidad and Tobago', -867, 0);
        self::insertCountries(null, 'TN', 'TUN', 'Tunisia', 216, 0);
        self::insertCountries(null, 'TR', 'TUR', 'Turkey', 90, 0);
        self::insertCountries(null, 'TM', 'TKM', 'Turkmenistan', 993, 0);
        self::insertCountries(null, 'TV', 'TUV', 'Tuvalu', 688, 0);
        self::insertCountries(null, 'UG', 'UGA', 'Uganda', 256, 0);
        self::insertCountries(null, 'UA', 'UKR', 'Ukraine', 380, 0);
        self::insertCountries(null, 'AE', 'ARE', 'United Arab Emirates', 971, 0);
        self::insertCountries(null, 'GB', 'GBR', 'United Kingdom', 44, 0);
        self::insertCountries(null, 'US', 'USA', 'United States', 1, 0);
        self::insertCountries(null, 'UY', 'URY', 'Uruguay', 598, 0);
        self::insertCountries(null, 'UZ', 'UZB', 'Uzbekistan', 998, 0);
        self::insertCountries(null, 'VU', 'VUT', 'Vanuatu', 678, 0);
        self::insertCountries(null, 'VA', 'VAT', 'Vatican City', 379, 0);
        self::insertCountries(null, 'VE', 'VEN', 'Venezuela', 58, 0);
        self::insertCountries(null, 'VN', 'VNM', 'Vietnam', 84, 0);
        self::insertCountries(null, 'YE', 'YEM', 'Yemen', 967, 0);
        self::insertCountries(null, 'ZM', 'ZMB', 'Zambia', 260, 0);
        self::insertCountries(null, 'ZW', 'ZWE', 'Zimbabwe', 263, 0);
        self::insertCountries(null, 'GE', 'GEO', 'Abkhazia', 995, 0);
        self::insertCountries(null, 'TW', 'TWN', 'China, Republic of (Taiwan)', 886, 0);
        self::insertCountries(null, 'AZ', 'AZE', 'Nagorno-Karabakh', 277, 0);
        self::insertCountries(null, 'CY', 'CYP', 'Northern Cyprus', -302, 0);
        self::insertCountries(null, 'MD', 'MDA', 'Pridnestrovie (Transnistria)', -160, 0);
        self::insertCountries(null, 'SO', 'SOM', 'Somaliland', 252, 0);
        self::insertCountries(null, 'GE', 'GEO', 'South Ossetia', 995, 0);
        self::insertCountries(null, 'AU', 'AUS', 'Ashmore and Cartier Islands', 0, 0);
        self::insertCountries(null, 'CX', 'CXR', 'Christmas Island', 61, 0);
        self::insertCountries(null, 'CC', 'CCK', 'Cocos (Keeling) Islands', 61, 0);
        self::insertCountries(null, 'AU', 'AUS', 'Coral Sea Islands', 0, 0);
        self::insertCountries(null, 'HM', 'HMD', 'Heard Island and McDonald Islands', 0, 0);
        self::insertCountries(null, 'NF', 'NFK', 'Norfolk Island', 672, 0);
        self::insertCountries(null, 'NC', 'NCL', 'New Caledonia', 687, 0);
        self::insertCountries(null, 'PF', 'PYF', 'French Polynesia', 689, 0);
        self::insertCountries(null, 'YT', 'MYT', 'Mayotte', 262, 0);
        self::insertCountries(null, 'GP', 'GLP', 'Saint Barthelemy', 590, 0);
        self::insertCountries(null, 'GP', 'GLP', 'Saint Martin', 590, 0);
        self::insertCountries(null, 'PM', 'SPM', 'Saint Pierre and Miquelon', 508, 0);
        self::insertCountries(null, 'WF', 'WLF', 'Wallis and Futuna', 681, 0);
        self::insertCountries(null, 'TF', 'ATF', 'French Southern and Antarctic Lands', 0, 0);
        self::insertCountries(null, 'PF', 'PYF', 'Clipperton Island', 0, 0);
        self::insertCountries(null, 'BV', 'BVT', 'Bouvet Island', 0, 0);
        self::insertCountries(null, 'CK', 'COK', 'Cook Islands', 682, 0);
        self::insertCountries(null, 'NU', 'NIU', 'Niue', 683, 0);
        self::insertCountries(null, 'TK', 'TKL', 'Tokelau', 690, 0);
        self::insertCountries(null, 'GG', 'GGY', 'Guernsey', 44, 0);
        self::insertCountries(null, 'IM', 'IMN', 'Isle of Man', 44, 0);
        self::insertCountries(null, 'JE', 'JEY', 'Jersey', 44, 0);
        self::insertCountries(null, 'AI', 'AIA', 'Anguilla', -263, 0);
        self::insertCountries(null, 'BM', 'BMU', 'Bermuda', -440, 0);
        self::insertCountries(null, 'IO', 'IOT', 'British Indian Ocean Territory', 246, 0);
        self::insertCountries(null, '', '', 'British Sovereign Base Areas', 357, 0);
        self::insertCountries(null, 'VG', 'VGB', 'British Virgin Islands', -283, 0);
        self::insertCountries(null, 'KY', 'CYM', 'Cayman Islands', -344, 0);
        self::insertCountries(null, 'FK', 'FLK', 'Falkland Islands (Islas Malvinas)', 500, 0);
        self::insertCountries(null, 'GI', 'GIB', 'Gibraltar', 350, 0);
        self::insertCountries(null, 'MS', 'MSR', 'Montserrat', -663, 0);
        self::insertCountries(null, 'PN', 'PCN', 'Pitcairn Islands', 0, 0);
        self::insertCountries(null, 'SH', 'SHN', 'Saint Helena', 290, 0);
        self::insertCountries(null, 'GS', 'SGS', 'South Georgia & South Sandwich Islands', 0, 0);
        self::insertCountries(null, 'TC', 'TCA', 'Turks and Caicos Islands', -648, 0);
        self::insertCountries(null, 'MP', 'MNP', 'Northern Mariana Islands', -669, 0);
        self::insertCountries(null, 'PR', 'PRI', 'Puerto Rico', +1 - 787 and 1 - 939, 0);
        self::insertCountries(null, 'AS', 'ASM', 'American Samoa', -683, 0);
        self::insertCountries(null, 'UM', 'UMI', 'Baker Island', 0, 0);
        self::insertCountries(null, 'GU', 'GUM', 'Guam', -670, 0);
        self::insertCountries(null, 'UM', 'UMI', 'Howland Island', 0, 0);
        self::insertCountries(null, 'UM', 'UMI', 'Jarvis Island', 0, 0);
        self::insertCountries(null, 'UM', 'UMI', 'Johnston Atoll', 0, 0);
        self::insertCountries(null, 'UM', 'UMI', 'Kingman Reef', 0, 0);
        self::insertCountries(null, 'UM', 'UMI', 'Midway Islands', 0, 0);
        self::insertCountries(null, 'UM', 'UMI', 'Navassa Island', 0, 0);
        self::insertCountries(null, 'UM', 'UMI', 'Palmyra Atoll', 0, 0);
        self::insertCountries(null, 'VI', 'VIR', 'U.S. Virgin Islands', -339, 0);
        self::insertCountries(null, 'UM', 'UMI', 'Wake Island', 0, 0);
        self::insertCountries(null, 'HK', 'HKG', 'Hong Kong', 852, 0);
        self::insertCountries(null, 'MO', 'MAC', 'Macau', 853, 0);
        self::insertCountries(null, 'FO', 'FRO', 'Faroe Islands', 298, 0);
        self::insertCountries(null, 'GL', 'GRL', 'Greenland', 299, 0);
        self::insertCountries(null, 'GF', 'GUF', 'French Guiana', 594, 0);
        self::insertCountries(null, 'GP', 'GLP', 'Guadeloupe', 590, 0);
        self::insertCountries(null, 'MQ', 'MTQ', 'Martinique', 596, 0);
        self::insertCountries(null, 'RE', 'REU', 'Reunion', 262, 0);
        self::insertCountries(null, 'AX', 'ALA', 'Aland', 340, 0);
        self::insertCountries(null, 'AW', 'ABW', 'Aruba', 297, 0);
        self::insertCountries(null, 'AN', 'ANT', 'Netherlands Antilles', 599, 0);
        self::insertCountries(null, 'SJ', 'SJM', 'Svalbard', 47, 0);
        self::insertCountries(null, 'AC', 'ASC', 'Ascension', 247, 0);
        self::insertCountries(null, 'TA', 'TAA', 'Tristan da Cunha', 290, 0);
        self::insertCountries(null, 'AQ', 'ATA', 'Australian Antarctic Territory', 0, 0);
        self::insertCountries(null, 'AQ', 'ATA', 'Ross Dependency', 0, 0);
        self::insertCountries(null, 'AQ', 'ATA', 'Peter I Island', 0, 0);
        self::insertCountries(null, 'AQ', 'ATA', 'Queen Maud Land', 0, 0);
        self::insertCountries(null, 'AQ', 'ATA', 'British Antarctic Territory', 0, 0);
    }

}
