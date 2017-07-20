<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    
    
    function insertCurrency($symbol, $short_label, $label) {

        $id = \App\Utilities\UuidTools::generateUuid();

        DB::table('currencies')->insert([
            'id' => $id,
            'symbol' => $symbol, //créer une constante pour le genre 
            'short_label' => $short_label,
            'label' => $label
        ]);
    }
    
    function insertCountries($iso2, $iso3, $label, $prefix,$id_currency) {

        $id = \App\Utilities\UuidTools::generateUuid();

        DB::table('countries')->insert([
            'id' => $id,
            'iso' => $iso2, //créer une constante pour le genre 
            'iso3' => $iso3,
            'label' => $label,
            'prefix' => $prefix,
            'id_currency' => $id_currency
        ]);
    }

    public function run() {
        
        CountriesTableSeeder::insertCurrency('','AED','UAE Dirham');
        CountriesTableSeeder::insertCurrency('؋','AFN','Afghani');
        CountriesTableSeeder::insertCurrency('Lek','ALL','Lek');
        CountriesTableSeeder::insertCurrency('','AMD','Armenian Dram');
        CountriesTableSeeder::insertCurrency('ƒ','ANG','Netherlands Antillian Guilder');
        CountriesTableSeeder::insertCurrency('','AOA','Kwanza');
        CountriesTableSeeder::insertCurrency('$','ARS','Argentine Peso');
        CountriesTableSeeder::insertCurrency('$','AUD','Australian Dollar');
        CountriesTableSeeder::insertCurrency('ƒ','AWG','Aruban Guilder');
        CountriesTableSeeder::insertCurrency('ман','AZN','Azerbaijanian Manat');
        CountriesTableSeeder::insertCurrency('KM','BAM','Convertible Marks');
        CountriesTableSeeder::insertCurrency('$','BBD','Barbados Dollar');
        CountriesTableSeeder::insertCurrency('','BDT','Taka');
        CountriesTableSeeder::insertCurrency('лв','BGN','Bulgarian Lev');
        CountriesTableSeeder::insertCurrency('','BHD','Bahraini Dinar');
        CountriesTableSeeder::insertCurrency('','BIF','Burundi Franc');
        CountriesTableSeeder::insertCurrency('$','BMD','Bermudian Dollar (customarily known as Bermuda Dollar)');
        CountriesTableSeeder::insertCurrency('$','BND','Brunei Dollar');
        CountriesTableSeeder::insertCurrency('$b','BOB','Boliviano Mvdol');
        CountriesTableSeeder::insertCurrency('R$','BRL','Brazilian Real');
        CountriesTableSeeder::insertCurrency('$','BSD','Bahamian Dollar');
        CountriesTableSeeder::insertCurrency('P','BWP','Pula');
        CountriesTableSeeder::insertCurrency('p.','BYR','Belarussian Ruble');
        CountriesTableSeeder::insertCurrency('BZ$','BZD','Belize Dollar');
        CountriesTableSeeder::insertCurrency('$','CAD','Canadian Dollar');
        CountriesTableSeeder::insertCurrency('','CDF','Congolese Franc');
        CountriesTableSeeder::insertCurrency('CHF','CHF','Swiss Franc');
        CountriesTableSeeder::insertCurrency('$','CLP','Chilean Peso Unidades de fomento');
        CountriesTableSeeder::insertCurrency('¥','CNY','Yuan Renminbi');
        CountriesTableSeeder::insertCurrency('$','COP','Colombian Peso Unidad de Valor Real');
        CountriesTableSeeder::insertCurrency('₡','CRC','Costa Rican Colon');
        CountriesTableSeeder::insertCurrency('₱','CUP','Cuban Peso Peso Convertible');
        CountriesTableSeeder::insertCurrency('','CVE','Cape Verde Escudo');
        CountriesTableSeeder::insertCurrency('Kč','CZK','Czech Koruna');
        CountriesTableSeeder::insertCurrency('','DJF','Djibouti Franc');
        CountriesTableSeeder::insertCurrency('kr','DKK','Danish Krone');
        CountriesTableSeeder::insertCurrency('RD$','DOP','Dominican Peso');
        CountriesTableSeeder::insertCurrency('','DZD','Algerian Dinar');
        CountriesTableSeeder::insertCurrency('','EEK','Kroon');
        CountriesTableSeeder::insertCurrency('£','EGP','Egyptian Pound');
        CountriesTableSeeder::insertCurrency('','ERN','Nakfa');
        CountriesTableSeeder::insertCurrency('','ETB','Ethiopian Birr');
        CountriesTableSeeder::insertCurrency('€','EUR','Euro');
        CountriesTableSeeder::insertCurrency('$','FJD','Fiji Dollar');
        CountriesTableSeeder::insertCurrency('£','FKP','Falkland Islands Pound');
        CountriesTableSeeder::insertCurrency('£','GBP','Pound Sterling');
        CountriesTableSeeder::insertCurrency('','GEL','Lari');
        CountriesTableSeeder::insertCurrency('','GHS','Cedi');
        CountriesTableSeeder::insertCurrency('£','GIP','Gibraltar Pound');
        CountriesTableSeeder::insertCurrency('','GMD','Dalasi');
        CountriesTableSeeder::insertCurrency('','GNF','Guinea Franc');
        CountriesTableSeeder::insertCurrency('Q','GTQ','Quetzal');
        CountriesTableSeeder::insertCurrency('$','GYD','Guyana Dollar');
        CountriesTableSeeder::insertCurrency('$','HKD','Hong Kong Dollar');
        CountriesTableSeeder::insertCurrency('L','HNL','Lempira');
        CountriesTableSeeder::insertCurrency('kn','HRK','Croatian Kuna');
        CountriesTableSeeder::insertCurrency('','USD','Gourde US Dollar');
        CountriesTableSeeder::insertCurrency('Ft','HUF','Forint');
        CountriesTableSeeder::insertCurrency('Rp','IDR','Rupiah');
        CountriesTableSeeder::insertCurrency('₪','ILS','New Israeli Sheqel');
        CountriesTableSeeder::insertCurrency('','INR','Indian Rupee');
        CountriesTableSeeder::insertCurrency('','INR','Indian Rupee Ngultrum');
        CountriesTableSeeder::insertCurrency('','IQD','Iraqi Dinar');
        CountriesTableSeeder::insertCurrency('﷼','IRR','Iranian Rial');
        CountriesTableSeeder::insertCurrency('kr','ISK','Iceland Krona');
        CountriesTableSeeder::insertCurrency('J$','JMD','Jamaican Dollar');
        CountriesTableSeeder::insertCurrency('','JOD','Jordanian Dinar');
        CountriesTableSeeder::insertCurrency('¥','JPY','Yen');
        CountriesTableSeeder::insertCurrency('','KES','Kenyan Shilling');
        CountriesTableSeeder::insertCurrency('лв','KGS','Som');
        CountriesTableSeeder::insertCurrency('៛','KHR','Riel');
        CountriesTableSeeder::insertCurrency('','KMF','Comoro Franc');
        CountriesTableSeeder::insertCurrency('₩','KPW','North Korean Won');
        CountriesTableSeeder::insertCurrency('₩','KRW','Won');
        CountriesTableSeeder::insertCurrency('','KWD','Kuwaiti Dinar');
        CountriesTableSeeder::insertCurrency('$','KYD','Cayman Islands Dollar');
        CountriesTableSeeder::insertCurrency('лв','KZT','Tenge');
        CountriesTableSeeder::insertCurrency('₭','LAK','Kip');
        CountriesTableSeeder::insertCurrency('£','LBP','Lebanese Pound');
        CountriesTableSeeder::insertCurrency('₨','LKR','Sri Lanka Rupee');
        CountriesTableSeeder::insertCurrency('$','LRD','Liberian Dollar');
        CountriesTableSeeder::insertCurrency('Lt','LTL','Lithuanian Litas');
        CountriesTableSeeder::insertCurrency('Ls','LVL','Latvian Lats');
        CountriesTableSeeder::insertCurrency('','LYD','Libyan Dinar');
        CountriesTableSeeder::insertCurrency('','MAD','Moroccan Dirham');
        CountriesTableSeeder::insertCurrency('','MDL','Moldovan Leu');
        CountriesTableSeeder::insertCurrency('','MGA','Malagasy Ariary');
        CountriesTableSeeder::insertCurrency('ден','MKD','Denar');
        CountriesTableSeeder::insertCurrency('','MMK','Kyat');
        CountriesTableSeeder::insertCurrency('₮','MNT','Tugrik');
        CountriesTableSeeder::insertCurrency('','MOP','Pataca');
        CountriesTableSeeder::insertCurrency('','MRO','Ouguiya');
        CountriesTableSeeder::insertCurrency('₨','MUR','Mauritius Rupee');
        CountriesTableSeeder::insertCurrency('','MVR','Rufiyaa');
        CountriesTableSeeder::insertCurrency('','MWK','Kwacha');
        CountriesTableSeeder::insertCurrency('$','MXN','Mexican Peso Mexican Unidad de Inversion (UDI)');
        CountriesTableSeeder::insertCurrency('RM','MYR','Malaysian Ringgit');
        CountriesTableSeeder::insertCurrency('MT','MZN','Metical');
        CountriesTableSeeder::insertCurrency('₦','NGN','Naira');
        CountriesTableSeeder::insertCurrency('C$','NIO','Cordoba Oro');
        CountriesTableSeeder::insertCurrency('kr','NOK','Norwegian Krone');
        CountriesTableSeeder::insertCurrency('₨','NPR','Nepalese Rupee');
        CountriesTableSeeder::insertCurrency('$','NZD','New Zealand Dollar');
        CountriesTableSeeder::insertCurrency('﷼','OMR','Rial Omani');
        CountriesTableSeeder::insertCurrency('B/.','USD','Balboa US Dollar');
        CountriesTableSeeder::insertCurrency('S/.','PEN','Nuevo Sol');
        CountriesTableSeeder::insertCurrency('','PGK','Kina');
        CountriesTableSeeder::insertCurrency('Php','PHP','Philippine Peso');
        CountriesTableSeeder::insertCurrency('₨','PKR','Pakistan Rupee');
        CountriesTableSeeder::insertCurrency('zł','PLN','Zloty');
        CountriesTableSeeder::insertCurrency('Gs','PYG','Guarani');
        CountriesTableSeeder::insertCurrency('﷼','QAR','Qatari Rial');
        CountriesTableSeeder::insertCurrency('lei','RON','New Leu');
        CountriesTableSeeder::insertCurrency('Дин.','RSD','Serbian Dinar');
        CountriesTableSeeder::insertCurrency('руб','RUB','Russian Ruble');
        CountriesTableSeeder::insertCurrency('','RWF','Rwanda Franc');
        CountriesTableSeeder::insertCurrency('﷼','SAR','Saudi Riyal');
        CountriesTableSeeder::insertCurrency('$','SBD','Solomon Islands Dollar');
        CountriesTableSeeder::insertCurrency('₨','SCR','Seychelles Rupee');
        CountriesTableSeeder::insertCurrency('','SDG','Sudanese Pound');
        CountriesTableSeeder::insertCurrency('kr','SEK','Swedish Krona');
        CountriesTableSeeder::insertCurrency('$','SGD','Singapore Dollar');
        CountriesTableSeeder::insertCurrency('£','SHP','Saint Helena Pound');
        CountriesTableSeeder::insertCurrency('','SLL','Leone');
        CountriesTableSeeder::insertCurrency('S','SOS','Somali Shilling');
        CountriesTableSeeder::insertCurrency('$','SRD','Surinam Dollar');
        CountriesTableSeeder::insertCurrency('','STD','Dobra');
        CountriesTableSeeder::insertCurrency('$','USD','El Salvador Colon US Dollar');
        CountriesTableSeeder::insertCurrency('£','SYP','Syrian Pound');
        CountriesTableSeeder::insertCurrency('','SZL','Lilangeni');
        CountriesTableSeeder::insertCurrency('฿','THB','Baht');
        CountriesTableSeeder::insertCurrency('','TJS','Somoni');
        CountriesTableSeeder::insertCurrency('','TMT','Manat');
        CountriesTableSeeder::insertCurrency('','TND','Tunisian Dinar');
        CountriesTableSeeder::insertCurrency('','TOP','Pa\'anga');
        CountriesTableSeeder::insertCurrency('TL','TRY','Turkish Lira');
        CountriesTableSeeder::insertCurrency('TT$','TTD','Trinidad and Tobago Dollar');
        CountriesTableSeeder::insertCurrency('NT$','TWD','New Taiwan Dollar');
        CountriesTableSeeder::insertCurrency('','TZS','Tanzanian Shilling');
        CountriesTableSeeder::insertCurrency('₴','UAH','Hryvnia');
        CountriesTableSeeder::insertCurrency('','UGX','Uganda Shilling');
        CountriesTableSeeder::insertCurrency('$','USD','US Dollar');
        CountriesTableSeeder::insertCurrency('$U','UYU','Peso Uruguayo Uruguay Peso en Unidades Indexadas');
        CountriesTableSeeder::insertCurrency('лв','UZS','Uzbekistan Sum');
        CountriesTableSeeder::insertCurrency('Bs','VEF','Bolivar Fuerte');
        CountriesTableSeeder::insertCurrency('₫','VND','Dong');
        CountriesTableSeeder::insertCurrency('','VUV','Vatu');
        CountriesTableSeeder::insertCurrency('','WST','Tala');
        CountriesTableSeeder::insertCurrency('','XAF','CFA Franc BEAC');
        CountriesTableSeeder::insertCurrency('','XAG','Silver');
        CountriesTableSeeder::insertCurrency('','XAU','Gold');
        CountriesTableSeeder::insertCurrency('','XBA','Bond Markets Units European Composite Unit (EURCO)');
        CountriesTableSeeder::insertCurrency('','XBB','European Monetary Unit (E.M.U.-6)');
        CountriesTableSeeder::insertCurrency('','XBC','European Unit of Account 9(E.U.A.-9)');
        CountriesTableSeeder::insertCurrency('','XBD','European Unit of Account 17(E.U.A.-17)');
        CountriesTableSeeder::insertCurrency('$','XCD','East Caribbean Dollar');
        CountriesTableSeeder::insertCurrency('','XDR','SDR');
        CountriesTableSeeder::insertCurrency('','XFU','UIC-Franc');
        CountriesTableSeeder::insertCurrency('','XOF','CFA Franc BCEAO');
        CountriesTableSeeder::insertCurrency('','XPD','Palladium');
        CountriesTableSeeder::insertCurrency('','XPF','CFP Franc');
        CountriesTableSeeder::insertCurrency('','XPT','Platinum');
        CountriesTableSeeder::insertCurrency('','XTS','Codes specifically reserved for testing purposes');
        CountriesTableSeeder::insertCurrency('﷼','YER','Yemeni Rial');
        CountriesTableSeeder::insertCurrency('R','ZAR','Rand');
        CountriesTableSeeder::insertCurrency('','ZAR','Rand Loti');
        CountriesTableSeeder::insertCurrency('','ZAR','Rand Namibia Dollar');
        CountriesTableSeeder::insertCurrency('','ZMK','Zambian Kwacha');
        CountriesTableSeeder::insertCurrency('','ZWL','Zimbabwe Dollar');



        
        
        
        
        CountriesTableSeeder::insertCountries('AF','AFG','Afghanistan',93,0);
        CountriesTableSeeder::insertCountries('AL','ALB','Albania',355,0);
        CountriesTableSeeder::insertCountries('DZ','DZA','Algeria',213,0);
        CountriesTableSeeder::insertCountries('AD','AND','Andorra',376,0);
        CountriesTableSeeder::insertCountries('AO','AGO','Angola',244,0);
        CountriesTableSeeder::insertCountries('AG','ATG','Antigua and Barbuda',-267,0);
        CountriesTableSeeder::insertCountries('AR','ARG','Argentina',54,0);
        CountriesTableSeeder::insertCountries('AM','ARM','Armenia',374,0);
        CountriesTableSeeder::insertCountries('AU','AUS','Australia',61,0);
        CountriesTableSeeder::insertCountries('AT','AUT','Austria',43,0);
        CountriesTableSeeder::insertCountries('AZ','AZE','Azerbaijan',994,0);
        CountriesTableSeeder::insertCountries('BS','BHS','Bahamas, The',-241,0);
        CountriesTableSeeder::insertCountries('BH','BHR','Bahrain',973,0);
        CountriesTableSeeder::insertCountries('BD','BGD','Bangladesh',880,0);
        CountriesTableSeeder::insertCountries('BB','BRB','Barbados',-245,0);
        CountriesTableSeeder::insertCountries('BY','BLR','Belarus',375,0);
        CountriesTableSeeder::insertCountries('BE','BEL','Belgium',32,0);
        CountriesTableSeeder::insertCountries('BZ','BLZ','Belize',501,0);
        CountriesTableSeeder::insertCountries('BJ','BEN','Benin',229,0);
        CountriesTableSeeder::insertCountries('BT','BTN','Bhutan',975,0);
        CountriesTableSeeder::insertCountries('BO','BOL','Bolivia',591,0);
        CountriesTableSeeder::insertCountries('BA','BIH','Bosnia and Herzegovina',387,0);
        CountriesTableSeeder::insertCountries('BW','BWA','Botswana',267,0);
        CountriesTableSeeder::insertCountries('BR','BRA','Brazil',55,0);
        CountriesTableSeeder::insertCountries('BN','BRN','Brunei',673,0);
        CountriesTableSeeder::insertCountries('BG','BGR','Bulgaria',359,0);
        CountriesTableSeeder::insertCountries('BF','BFA','Burkina Faso',226,0);
        CountriesTableSeeder::insertCountries('BI','BDI','Burundi',257,0);
        CountriesTableSeeder::insertCountries('KH','KHM','Cambodia',855,0);
        CountriesTableSeeder::insertCountries('CM','CMR','Cameroon',237,0);
        CountriesTableSeeder::insertCountries('CA','CAN','Canada',1,0);
        CountriesTableSeeder::insertCountries('CV','CPV','Cape Verde',238,0);
        CountriesTableSeeder::insertCountries('CF','CAF','Central African Republic',236,0);
        CountriesTableSeeder::insertCountries('TD','TCD','Chad',235,0);
        CountriesTableSeeder::insertCountries('CL','CHL','Chile',56,0);
        CountriesTableSeeder::insertCountries('CN','CHN','China',86,0);
        CountriesTableSeeder::insertCountries('CO','COL','Colombia',57,0);
        CountriesTableSeeder::insertCountries('KM','COM','Comoros',269,0);
        CountriesTableSeeder::insertCountries('CD','COD','Congo, (Congo Â– Kinshasa)',243,0);
        CountriesTableSeeder::insertCountries('CG','COG','Congo, (Congo Â– Brazzaville)',242,0);
        CountriesTableSeeder::insertCountries('CR','CRI','Costa Rica',506,0);
        CountriesTableSeeder::insertCountries('CI','CIV','Cote d\'Ivoire (Ivory Coast)',225,0);
        CountriesTableSeeder::insertCountries('HR','HRV','Croatia',385,0);
        CountriesTableSeeder::insertCountries('CU','CUB','Cuba',53,0);
        CountriesTableSeeder::insertCountries('CY','CYP','Cyprus',357,0);
        CountriesTableSeeder::insertCountries('CZ','CZE','Czech Republic',420,0);
        CountriesTableSeeder::insertCountries('DK','DNK','Denmark',45,0);
        CountriesTableSeeder::insertCountries('DJ','DJI','Djibouti',253,0);
        CountriesTableSeeder::insertCountries('DM','DMA','Dominica',-766,0);
        CountriesTableSeeder::insertCountries('DO','DOM','Dominican Republic',+1-809 and 1-829,0);
        CountriesTableSeeder::insertCountries('EC','ECU','Ecuador',593,0);
        CountriesTableSeeder::insertCountries('EG','EGY','Egypt',20,0);
        CountriesTableSeeder::insertCountries('SV','SLV','El Salvador',503,0);
        CountriesTableSeeder::insertCountries('GQ','GNQ','Equatorial Guinea',240,0);
        CountriesTableSeeder::insertCountries('ER','ERI','Eritrea',291,0);
        CountriesTableSeeder::insertCountries('EE','EST','Estonia',372,0);
        CountriesTableSeeder::insertCountries('ET','ETH','Ethiopia',251,0);
        CountriesTableSeeder::insertCountries('FJ','FJI','Fiji',679,0);
        CountriesTableSeeder::insertCountries('FI','FIN','Finland',358,0);
        CountriesTableSeeder::insertCountries('FR','FRA','France',33,0);
        CountriesTableSeeder::insertCountries('GA','GAB','Gabon',241,0);
        CountriesTableSeeder::insertCountries('GM','GMB','Gambia, The',220,0);
        CountriesTableSeeder::insertCountries('GE','GEO','Georgia',995,0);
        CountriesTableSeeder::insertCountries('DE','DEU','Germany',49,0);
        CountriesTableSeeder::insertCountries('GH','GHA','Ghana',233,0);
        CountriesTableSeeder::insertCountries('GR','GRC','Greece',30,0);
        CountriesTableSeeder::insertCountries('GD','GRD','Grenada',-472,0);
        CountriesTableSeeder::insertCountries('GT','GTM','Guatemala',502,0);
        CountriesTableSeeder::insertCountries('GN','GIN','Guinea',224,0);
        CountriesTableSeeder::insertCountries('GW','GNB','Guinea-Bissau',245,0);
        CountriesTableSeeder::insertCountries('GY','GUY','Guyana',592,0);
        CountriesTableSeeder::insertCountries('HT','HTI','Haiti',509,0);
        CountriesTableSeeder::insertCountries('HN','HND','Honduras',504,0);
        CountriesTableSeeder::insertCountries('HU','HUN','Hungary',36,0);
        CountriesTableSeeder::insertCountries('IS','ISL','Iceland',354,0);
        CountriesTableSeeder::insertCountries('IN','IND','India',91,0);
        CountriesTableSeeder::insertCountries('ID','IDN','Indonesia',62,0);
        CountriesTableSeeder::insertCountries('IR','IRN','Iran',98,0);
        CountriesTableSeeder::insertCountries('IQ','IRQ','Iraq',964,0);
        CountriesTableSeeder::insertCountries('IE','IRL','Ireland',353,0);
        CountriesTableSeeder::insertCountries('IL','ISR','Israel',972,0);
        CountriesTableSeeder::insertCountries('IT','ITA','Italy',39,0);
        CountriesTableSeeder::insertCountries('JM','JAM','Jamaica',-875,0);
        CountriesTableSeeder::insertCountries('JP','JPN','Japan',81,0);
        CountriesTableSeeder::insertCountries('JO','JOR','Jordan',962,0);
        CountriesTableSeeder::insertCountries('KZ','KAZ','Kazakhstan',7,0);
        CountriesTableSeeder::insertCountries('KE','KEN','Kenya',254,0);
        CountriesTableSeeder::insertCountries('KI','KIR','Kiribati',686,0);
        CountriesTableSeeder::insertCountries('KP','PRK','Korea, North',850,0);
        CountriesTableSeeder::insertCountries('KR','KOR','Korea, South',82,0);
        CountriesTableSeeder::insertCountries('KW','KWT','Kuwait',965,0);
        CountriesTableSeeder::insertCountries('KG','KGZ','Kyrgyzstan',996,0);
        CountriesTableSeeder::insertCountries('LA','LAO','Laos',856,0);
        CountriesTableSeeder::insertCountries('LV','LVA','Latvia',371,0);
        CountriesTableSeeder::insertCountries('LB','LBN','Lebanon',961,0);
        CountriesTableSeeder::insertCountries('LS','LSO','Lesotho',266,0);
        CountriesTableSeeder::insertCountries('LR','LBR','Liberia',231,0);
        CountriesTableSeeder::insertCountries('LY','LBY','Libya',218,0);
        CountriesTableSeeder::insertCountries('LI','LIE','Liechtenstein',423,0);
        CountriesTableSeeder::insertCountries('LT','LTU','Lithuania',370,0);
        CountriesTableSeeder::insertCountries('LU','LUX','Luxembourg',352,0);
        CountriesTableSeeder::insertCountries('MK','MKD','Macedonia',389,0);
        CountriesTableSeeder::insertCountries('MG','MDG','Madagascar',261,0);
        CountriesTableSeeder::insertCountries('MW','MWI','Malawi',265,0);
        CountriesTableSeeder::insertCountries('MY','MYS','Malaysia',60,0);
        CountriesTableSeeder::insertCountries('MV','MDV','Maldives',960,0);
        CountriesTableSeeder::insertCountries('ML','MLI','Mali',223,0);
        CountriesTableSeeder::insertCountries('MT','MLT','Malta',356,0);
        CountriesTableSeeder::insertCountries('MH','MHL','Marshall Islands',692,0);
        CountriesTableSeeder::insertCountries('MR','MRT','Mauritania',222,0);
        CountriesTableSeeder::insertCountries('MU','MUS','Mauritius',230,0);
        CountriesTableSeeder::insertCountries('MX','MEX','Mexico',52,0);
        CountriesTableSeeder::insertCountries('FM','FSM','Micronesia',691,0);
        CountriesTableSeeder::insertCountries('MD','MDA','Moldova',373,0);
        CountriesTableSeeder::insertCountries('MC','MCO','Monaco',377,0);
        CountriesTableSeeder::insertCountries('MN','MNG','Mongolia',976,0);
        CountriesTableSeeder::insertCountries('ME','MNE','Montenegro',382,0);
        CountriesTableSeeder::insertCountries('MA','MAR','Morocco',212,0);
        CountriesTableSeeder::insertCountries('MZ','MOZ','Mozambique',258,0);
        CountriesTableSeeder::insertCountries('MM','MMR','Myanmar (Burma)',95,0);
        CountriesTableSeeder::insertCountries('NA','NAM','Namibia',264,0);
        CountriesTableSeeder::insertCountries('NR','NRU','Nauru',674,0);
        CountriesTableSeeder::insertCountries('NP','NPL','Nepal',977,0);
        CountriesTableSeeder::insertCountries('NL','NLD','Netherlands',31,0);
        CountriesTableSeeder::insertCountries('NZ','NZL','New Zealand',64,0);
        CountriesTableSeeder::insertCountries('NI','NIC','Nicaragua',505,0);
        CountriesTableSeeder::insertCountries('NE','NER','Niger',227,0);
        CountriesTableSeeder::insertCountries('NG','NGA','Nigeria',234,0);
        CountriesTableSeeder::insertCountries('NO','NOR','Norway',47,0);
        CountriesTableSeeder::insertCountries('OM','OMN','Oman',968,0);
        CountriesTableSeeder::insertCountries('PK','PAK','Pakistan',92,0);
        CountriesTableSeeder::insertCountries('PW','PLW','Palau',680,0);
        CountriesTableSeeder::insertCountries('PA','PAN','Panama',507,0);
        CountriesTableSeeder::insertCountries('PG','PNG','Papua New Guinea',675,0);
        CountriesTableSeeder::insertCountries('PY','PRY','Paraguay',595,0);
        CountriesTableSeeder::insertCountries('PE','PER','Peru',51,0);
        CountriesTableSeeder::insertCountries('PH','PHL','Philippines',63,0);
        CountriesTableSeeder::insertCountries('PL','POL','Poland',48,0);
        CountriesTableSeeder::insertCountries('PT','PRT','Portugal',351,0);
        CountriesTableSeeder::insertCountries('QA','QAT','Qatar',974,0);
        CountriesTableSeeder::insertCountries('RO','ROU','Romania',40,0);
        CountriesTableSeeder::insertCountries('RU','RUS','Russia',7,0);
        CountriesTableSeeder::insertCountries('RW','RWA','Rwanda',250,0);
        CountriesTableSeeder::insertCountries('KN','KNA','Saint Kitts and Nevis',-868,0);
        CountriesTableSeeder::insertCountries('LC','LCA','Saint Lucia',-757,0);
        CountriesTableSeeder::insertCountries('VC','VCT','Saint Vincent and the Grenadines',-783,0);
        CountriesTableSeeder::insertCountries('WS','WSM','Samoa',685,0);
        CountriesTableSeeder::insertCountries('SM','SMR','San Marino',378,0);
        CountriesTableSeeder::insertCountries('ST','STP','Sao Tome and Principe',239,0);
        CountriesTableSeeder::insertCountries('SA','SAU','Saudi Arabia',966,0);
        CountriesTableSeeder::insertCountries('SN','SEN','Senegal',221,0);
        CountriesTableSeeder::insertCountries('RS','SRB','Serbia',381,0);
        CountriesTableSeeder::insertCountries('SC','SYC','Seychelles',248,0);
        CountriesTableSeeder::insertCountries('SL','SLE','Sierra Leone',232,0);
        CountriesTableSeeder::insertCountries('SG','SGP','Singapore',65,0);
        CountriesTableSeeder::insertCountries('SK','SVK','Slovakia',421,0);
        CountriesTableSeeder::insertCountries('SI','SVN','Slovenia',386,0);
        CountriesTableSeeder::insertCountries('SB','SLB','Solomon Islands',677,0);
        CountriesTableSeeder::insertCountries('SO','SOM','Somalia',252,0);
        CountriesTableSeeder::insertCountries('ZA','ZAF','South Africa',27,0);
        CountriesTableSeeder::insertCountries('ES','ESP','Spain',34,0);
        CountriesTableSeeder::insertCountries('LK','LKA','Sri Lanka',94,0);
        CountriesTableSeeder::insertCountries('SD','SDN','Sudan',249,0);
        CountriesTableSeeder::insertCountries('SR','SUR','Suriname',597,0);
        CountriesTableSeeder::insertCountries('SZ','SWZ','Swaziland',268,0);
        CountriesTableSeeder::insertCountries('SE','SWE','Sweden',46,0);
        CountriesTableSeeder::insertCountries('CH','CHE','Switzerland',41,0);
        CountriesTableSeeder::insertCountries('SY','SYR','Syria',963,0);
        CountriesTableSeeder::insertCountries('TJ','TJK','Tajikistan',992,0);
        CountriesTableSeeder::insertCountries('TZ','TZA','Tanzania',255,0);
        CountriesTableSeeder::insertCountries('TH','THA','Thailand',66,0);
        CountriesTableSeeder::insertCountries('TL','TLS','Timor-Leste (East Timor)',670,0);
        CountriesTableSeeder::insertCountries('TG','TGO','Togo',228,0);
        CountriesTableSeeder::insertCountries('TO','TON','Tonga',676,0);
        CountriesTableSeeder::insertCountries('TT','TTO','Trinidad and Tobago',-867,0);
        CountriesTableSeeder::insertCountries('TN','TUN','Tunisia',216,0);
        CountriesTableSeeder::insertCountries('TR','TUR','Turkey',90,0);
        CountriesTableSeeder::insertCountries('TM','TKM','Turkmenistan',993,0);
        CountriesTableSeeder::insertCountries('TV','TUV','Tuvalu',688,0);
        CountriesTableSeeder::insertCountries('UG','UGA','Uganda',256,0);
        CountriesTableSeeder::insertCountries('UA','UKR','Ukraine',380,0);
        CountriesTableSeeder::insertCountries('AE','ARE','United Arab Emirates',971,0);
        CountriesTableSeeder::insertCountries('GB','GBR','United Kingdom',44,0);
        CountriesTableSeeder::insertCountries('US','USA','United States',1,0);
        CountriesTableSeeder::insertCountries('UY','URY','Uruguay',598,0);
        CountriesTableSeeder::insertCountries('UZ','UZB','Uzbekistan',998,0);
        CountriesTableSeeder::insertCountries('VU','VUT','Vanuatu',678,0);
        CountriesTableSeeder::insertCountries('VA','VAT','Vatican City',379,0);
        CountriesTableSeeder::insertCountries('VE','VEN','Venezuela',58,0);
        CountriesTableSeeder::insertCountries('VN','VNM','Vietnam',84,0);
        CountriesTableSeeder::insertCountries('YE','YEM','Yemen',967,0);
        CountriesTableSeeder::insertCountries('ZM','ZMB','Zambia',260,0);
        CountriesTableSeeder::insertCountries('ZW','ZWE','Zimbabwe',263,0);
        CountriesTableSeeder::insertCountries('GE','GEO','Abkhazia',995,0);
        CountriesTableSeeder::insertCountries('TW','TWN','China, Republic of (Taiwan)',886,0);
        CountriesTableSeeder::insertCountries('AZ','AZE','Nagorno-Karabakh',277,0);
        CountriesTableSeeder::insertCountries('CY','CYP','Northern Cyprus',-302,0);
        CountriesTableSeeder::insertCountries('MD','MDA','Pridnestrovie (Transnistria)',-160,0);
        CountriesTableSeeder::insertCountries('SO','SOM','Somaliland',252,0);
        CountriesTableSeeder::insertCountries('GE','GEO','South Ossetia',995,0);
        CountriesTableSeeder::insertCountries('AU','AUS','Ashmore and Cartier Islands',0,0);
        CountriesTableSeeder::insertCountries('CX','CXR','Christmas Island',61,0);
        CountriesTableSeeder::insertCountries('CC','CCK','Cocos (Keeling) Islands',61,0);
        CountriesTableSeeder::insertCountries('AU','AUS','Coral Sea Islands',0,0);
        CountriesTableSeeder::insertCountries('HM','HMD','Heard Island and McDonald Islands',0,0);
        CountriesTableSeeder::insertCountries('NF','NFK','Norfolk Island',672,0);
        CountriesTableSeeder::insertCountries('NC','NCL','New Caledonia',687,0);
        CountriesTableSeeder::insertCountries('PF','PYF','French Polynesia',689,0);
        CountriesTableSeeder::insertCountries('YT','MYT','Mayotte',262,0);
        CountriesTableSeeder::insertCountries('GP','GLP','Saint Barthelemy',590,0);
        CountriesTableSeeder::insertCountries('GP','GLP','Saint Martin',590,0);
        CountriesTableSeeder::insertCountries('PM','SPM','Saint Pierre and Miquelon',508,0);
        CountriesTableSeeder::insertCountries('WF','WLF','Wallis and Futuna',681,0);
        CountriesTableSeeder::insertCountries('TF','ATF','French Southern and Antarctic Lands',0,0);
        CountriesTableSeeder::insertCountries('PF','PYF','Clipperton Island',0,0);
        CountriesTableSeeder::insertCountries('BV','BVT','Bouvet Island',0,0);
        CountriesTableSeeder::insertCountries('CK','COK','Cook Islands',682,0);
        CountriesTableSeeder::insertCountries('NU','NIU','Niue',683,0);
        CountriesTableSeeder::insertCountries('TK','TKL','Tokelau',690,0);
        CountriesTableSeeder::insertCountries('GG','GGY','Guernsey',44,0);
        CountriesTableSeeder::insertCountries('IM','IMN','Isle of Man',44,0);
        CountriesTableSeeder::insertCountries('JE','JEY','Jersey',44,0);
        CountriesTableSeeder::insertCountries('AI','AIA','Anguilla',-263,0);
        CountriesTableSeeder::insertCountries('BM','BMU','Bermuda',-440,0);
        CountriesTableSeeder::insertCountries('IO','IOT','British Indian Ocean Territory',246,0);
        CountriesTableSeeder::insertCountries('','','British Sovereign Base Areas',357,0);
        CountriesTableSeeder::insertCountries('VG','VGB','British Virgin Islands',-283,0);
        CountriesTableSeeder::insertCountries('KY','CYM','Cayman Islands',-344,0);
        CountriesTableSeeder::insertCountries('FK','FLK','Falkland Islands (Islas Malvinas)',500,0);
        CountriesTableSeeder::insertCountries('GI','GIB','Gibraltar',350,0);
        CountriesTableSeeder::insertCountries('MS','MSR','Montserrat',-663,0);
        CountriesTableSeeder::insertCountries('PN','PCN','Pitcairn Islands',0,0);
        CountriesTableSeeder::insertCountries('SH','SHN','Saint Helena',290,0);
        CountriesTableSeeder::insertCountries('GS','SGS','South Georgia & South Sandwich Islands',0,0);
        CountriesTableSeeder::insertCountries('TC','TCA','Turks and Caicos Islands',-648,0);
        CountriesTableSeeder::insertCountries('MP','MNP','Northern Mariana Islands',-669,0);
        CountriesTableSeeder::insertCountries('PR','PRI','Puerto Rico',+1-787 and 1-939,0);
        CountriesTableSeeder::insertCountries('AS','ASM','American Samoa',-683,0);
        CountriesTableSeeder::insertCountries('UM','UMI','Baker Island',0,0);
        CountriesTableSeeder::insertCountries('GU','GUM','Guam',-670,0);
        CountriesTableSeeder::insertCountries('UM','UMI','Howland Island',0,0);
        CountriesTableSeeder::insertCountries('UM','UMI','Jarvis Island',0,0);
        CountriesTableSeeder::insertCountries('UM','UMI','Johnston Atoll',0,0);
        CountriesTableSeeder::insertCountries('UM','UMI','Kingman Reef',0,0);
        CountriesTableSeeder::insertCountries('UM','UMI','Midway Islands',0,0);
        CountriesTableSeeder::insertCountries('UM','UMI','Navassa Island',0,0);
        CountriesTableSeeder::insertCountries('UM','UMI','Palmyra Atoll',0,0);
        CountriesTableSeeder::insertCountries('VI','VIR','U.S. Virgin Islands',-339,0);
        CountriesTableSeeder::insertCountries('UM','UMI','Wake Island',0,0);
        CountriesTableSeeder::insertCountries('HK','HKG','Hong Kong',852,0);
        CountriesTableSeeder::insertCountries('MO','MAC','Macau',853,0);
        CountriesTableSeeder::insertCountries('FO','FRO','Faroe Islands',298,0);
        CountriesTableSeeder::insertCountries('GL','GRL','Greenland',299,0);
        CountriesTableSeeder::insertCountries('GF','GUF','French Guiana',594,0);
        CountriesTableSeeder::insertCountries('GP','GLP','Guadeloupe',590,0);
        CountriesTableSeeder::insertCountries('MQ','MTQ','Martinique',596,0);
        CountriesTableSeeder::insertCountries('RE','REU','Reunion',262,0);
        CountriesTableSeeder::insertCountries('AX','ALA','Aland',340,0);
        CountriesTableSeeder::insertCountries('AW','ABW','Aruba',297,0);
        CountriesTableSeeder::insertCountries('AN','ANT','Netherlands Antilles',599,0);
        CountriesTableSeeder::insertCountries('SJ','SJM','Svalbard',47,0);
        CountriesTableSeeder::insertCountries('AC','ASC','Ascension',247,0);
        CountriesTableSeeder::insertCountries('TA','TAA','Tristan da Cunha',290,0);
        CountriesTableSeeder::insertCountries('AQ','ATA','Australian Antarctic Territory',0,0);
        CountriesTableSeeder::insertCountries('AQ','ATA','Ross Dependency',0,0);
        CountriesTableSeeder::insertCountries('AQ','ATA','Peter I Island',0,0);
        CountriesTableSeeder::insertCountries('AQ','ATA','Queen Maud Land',0,0);
        CountriesTableSeeder::insertCountries('AQ','ATA','British Antarctic Territory',0,0);

        
    }

}
