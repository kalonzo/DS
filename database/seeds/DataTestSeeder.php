<?php

use Illuminate\Database\Seeder;

class DataTestSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        /*         * **************************** FOOD SPECIALTIES *************************************************************************** */
        $id = \App\Utilities\UuidTools::generateUuid();
        DB::table('business_categories')->insert([
            'id' => $id,
            'name' => 'Hamburger',
            'type' => \App\Models\BusinessCategory::TYPE_FOOD_SPECIALTY,
        ]);

        $id = \App\Utilities\UuidTools::generateUuid();
        DB::table('business_categories')->insert([
            'id' => $id,
            'name' => 'Pizza aux feu de bois',
            'type' => \App\Models\BusinessCategory::TYPE_FOOD_SPECIALTY,
        ]);

        $id = \App\Utilities\UuidTools::generateUuid();
        DB::table('business_categories')->insert([
            'id' => $id,
            'name' => 'Poulet Masalah',
            'type' => \App\Models\BusinessCategory::TYPE_FOOD_SPECIALTY,
        ]);


        /*         * **************************** PAYMENT METHODS *************************************************************************** */
        App\Models\BuyableItem::insert([
            'id' => \App\Utilities\UuidTools::generateUuid(),
            'designation' => 'Standard',
            'status' => App\Models\BuyableItem::STATUS_ACTIVE,
            'type' => App\Models\BuyableItem::TYPE_PRO_SUBSCRIPTION,
//            'unit_price_HT',
            'unit_price_TTC' => 250,
//            'vat_rate',
//            'price_HT',
            'price_TTC' => 250,
            'net_price' => 250,
//            'id_object',
//            'type_object',
            'description' => 'Abonnement basique',
//            'start_date',
//            'end_date',
            'id_business_type' => \App\Models\BusinessType::TYPE_BUSINESS_RESTAURANT,
//            'id_geographical_zone',
            'color' => '#028f6c',
            'id_currency' => App\Models\Currency::CHF
        ]);

        App\Models\BuyableItem::insert([
            'id' => \App\Utilities\UuidTools::generateUuid(),
            'designation' => 'Silver',
            'status' => App\Models\BuyableItem::STATUS_ACTIVE,
            'type' => App\Models\BuyableItem::TYPE_PRO_SUBSCRIPTION,
//            'unit_price_HT',
            'unit_price_TTC' => 350,
//            'vat_rate',
//            'price_HT',
            'price_TTC' => 350,
            'net_price' => 350,
//            'id_object',
//            'type_object',
            'description' => 'Abonnement silver',
//            'start_date',
//            'end_date',
            'id_business_type' => \App\Models\BusinessType::TYPE_BUSINESS_RESTAURANT,
//            'id_geographical_zone',
            'color' => '#483e35',
            'id_currency' => App\Models\Currency::CHF
        ]);

        App\Models\BuyableItem::insert([
            'id' => \App\Utilities\UuidTools::generateUuid(),
            'designation' => 'Gold',
            'status' => App\Models\BuyableItem::STATUS_ACTIVE,
            'type' => App\Models\BuyableItem::TYPE_PRO_SUBSCRIPTION,
//            'unit_price_HT',
            'unit_price_TTC' => 450,
//            'vat_rate',
//            'price_HT',
            'price_TTC' => 450,
            'net_price' => 450,
//            'id_object',
//            'type_object',
            'description' => 'Abonnement gold',
//            'start_date',
//            'end_date',
            'id_business_type' => \App\Models\BusinessType::TYPE_BUSINESS_RESTAURANT,
//            'id_geographical_zone',
            'color' => '#0069a3',
            'id_currency' => App\Models\Currency::CHF
        ]);

        App\Models\BuyableItem::insert([
            'id' => \App\Utilities\UuidTools::generateUuid(),
            'designation' => 'Premium',
            'status' => App\Models\BuyableItem::STATUS_ACTIVE,
            'type' => App\Models\BuyableItem::TYPE_PRO_SUBSCRIPTION,
//            'unit_price_HT',
            'unit_price_TTC' => 600,
//            'vat_rate',
//            'price_HT',
            'price_TTC' => 600,
            'net_price' => 600,
//            'id_object',
//            'type_object',
            'description' => 'Abonnement premium',
//            'start_date',
//            'end_date',
            'id_business_type' => \App\Models\BusinessType::TYPE_BUSINESS_RESTAURANT,
//            'id_geographical_zone',
            'color' => '#013a4b',
            'id_currency' => App\Models\Currency::CHF
        ]);


        /*         * **************************** RESTAURANTS *************************************************************************** */
        $id = \App\Utilities\UuidTools::generateUuid();

        self::makeTestData('Broadway Restaurant', 'chemin Malombré ', 18, 1202, 'Genève', 'Switzerland', 46.1954749, 6.1496726, 'restaurantbroadway.com', '', 'Franconienne', 'descn', $id, null);

        self::makeTestData('Restaurant Le Pradier', 'Rue Pradier', 6, 1201, 'Genève', 'Switzerland', 46.1945955, 6.1453122, 'lepradier.com', '', 'Franconienne', 'descn', $id, null);

        self::makeTestData('Restaurant Chausse-Coqs', 'Rue Micheli-du-Crest', 18, 1205, 'Genève', 'Switzerland', 46.1945955, 6.1453122, 'chausse-coqs.ch', '', 'Franconienne', 'descn', $id, null);

        $id = \App\Utilities\UuidTools::generateUuid();

        self::makeTestData('Pékin Palace', 'Rue des Alpes', 22, 1201, 'Genève', 'Switzerland', 46.2109976, 6.1425921, 'pekin-palace.thefork.rest', '', 'Chinoise', 'descn', $id, null);

        self::makeTestData('Restaurant Wang', 'Rue des Eaux-Vives', 9, 1207, 'Genève', 'Switzerland', 46.2033257, 6.1550633, 'restaurant-wang.ch', '', 'Chinoise', 'descn', $id, null);

        $id = \App\Utilities\UuidTools::generateUuid();

        self::makeTestData('Matsuri', 'Rue de la Confédération', 8, 1204, 'Genève', 'Switzerland', 46.2035711, 6.1424213, 'matsuri.ch', '', 'Japonaise', 'descn', $id, null);

        $id = \App\Utilities\UuidTools::generateUuid();

        self::makeTestData('Gaùcho Churrascaria', 'Chemin Malombré ', 1, 1206, 'Genève', 'Switzerland', 46.196326, 6.15203, 'churrascaria-gaucho.com', '', 'Brésilienne', 'descn', $id, null);

        $id = \App\Utilities\UuidTools::generateUuid();

        self::makeTestData('Thaï tastes café & restaurant', 'Rue de la Servette', 16, 1201, 'Genève', 'Switzerland', 46.2102704, 6.1356, 'thaitastes .ch', '', 'Thaïlandaise', 'descn', $id, null);

        $id = \App\Utilities\UuidTools::generateUuid();

        self::makeTestData('Contact - Bar et Restaurant', 'Rue du Prieuré', 8, 1202, 'Genève', 'Switzerland', 46.2972433, 6.1230715, 'jimma.ch', '', 'Ethiopienne', 'descn', $id, null);

        self::makeTestData('Chez Sami', 'Rue de fribourg ', 11, 1201, 'Genève', 'Switzerland', 46.3390482, 6.2137802, 'chezsami.ch', '', 'Libanaise', 'descn', $id, null);


        self::makeTestData('Restaurant Arabesque', 'Quai Wilson', 47, 1201, 'Genève', 'Switzerland', 46.2148921, 6.1488857, '', 'restaurantarabesque.com', 'Libanaise', 'descn', $id, null);

        $id = \App\Utilities\UuidTools::generateUuid();

        self::makeTestData('Le Léman', 'Rue de Rive ', 28, 1260, 'Nyon', 'Switzerland', 46.3803758, 6.240229, 'restorive-nyon.ch', '', 'Suisse', 'descn', $id, null);

        $id = \App\Utilities\UuidTools::generateUuid();

        self::makeTestData('L Auberge du Château', 'Place du Château', 8, 1260, 'Nyon', 'Switzerland', 46.3819953, 6.2385886, 'aubergeduchateau.ch', '', 'Italienne', 'descn', $id, null);

        self::makeTestData('Le Grand Café - Hôtel Real', 'Place de Savoie ', 1, 1260, 'Nyon', 'Switzerland', 46.3806361, 6.2393026, 'hotlerealnyon.ch', '', 'Italienne', 'descn', $id, null);

        $id = \App\Utilities\UuidTools::generateUuid();

        self::makeTestData('Café du Raisin', 'Gran Rue', 26, 1268, 'Begnins', 'Switzerland', 46.4153124, 6.2117013, '', '', 'Régionale', 'descn', $id, null);

        $id = \App\Utilities\UuidTools::generateUuid();

        self::makeTestData('Khãnã Mandir', 'Place du Marché', 1, 1260, 'Nyon', 'Switzerland', 46.381897, 6.2363523, 'khanamandir.ch', '', 'Indienne', 'descn', $id, null);

        $id = \App\Utilities\UuidTools::generateUuid();

        self::makeTestData('Hôtel Restaurant La Truite', 'Grand-Rue', 203, 1220, 'Divonnes-les-Bains', 'France', 46.3296795, 6.1153798, '', 'hotelrestaurantlatruite.com', 'Traditionnelle / Classique', 'descn', $id, null);

        $id = \App\Utilities\UuidTools::generateUuid();
        self::makeTestData('Linstant Restaurant ', 'Place Perdtemps', 9, 1220, 'Divonnes-les-Bains', 'France', 46.357373, 6.117848, '', 'restaurantdivonne-les-bains.fr', 'Traditionnelle / Classique', 'descn', $id, null);

        $id = \App\Utilities\UuidTools::generateUuid();
        self::makeTestData('Château de Divonne', 'Rue des Bains', 115, 1220, 'Divonnes-les-Bains', 'France', 46.3563213, 6.1317597, '', 'château-divonne.com', 'Gastronomique', 'descn', $id, null);

        $id = \App\Utilities\UuidTools::generateUuid();
        self::makeTestData('Restaurant Le Nabab ', 'Avenue de Genève ', 252, 1220, 'Divonnes-les-Bains', 'France', 46.3533643, 6.1400721, '', 'lenabab-restaurant.fr', 'Indienne', 'descn', $id, null);
        self::makeTestData('Café des Moulins', 'Rue de la Colombière', 12, 1260, 'Nyon', 'Switzerland', 46.3899031, 6.2151437, 'restorive-nyon.ch', '', 'Européenne', 'descn', $id, null);
    }

    /**
     * 
     * @param type $non_etab
     * @param type $street
     * @param type $street_number
     * @param type $postal_code
     * @param type $city
     * @param type $country
     * @param type $latitude
     * @param type $longitude
     * @param type $email
     * @param type $site_url
     * @param type $type_cuisine
     * @param type $descn
     * @param type $id_business_categoryRun the database seeds.
     *
     * @return void
     */
    function makeTestData($non_etab, $street, $street_number, $postal_code, $city, $country, $latitude, $longitude, $email, $site_url, $type_cuisine, $descn, $id_business_category) {

        $id_user_owner = \App\Utilities\UuidTools::generateUuid();
        $id_establishment = \App\Utilities\UuidTools::generateUuid();
        $id_address = \App\Utilities\UuidTools::generateUuid();

        $idLocationIndex = $this->getIdLocationIndex($postal_code, $city, $latitude, $longitude, $country);
        $countryId = null;
        switch ($country) {
            default :
            case 'Afghanistan': $countryId = App\Models\Country::AFG;
                break;
            case 'Albania': $countryId = App\Models\Country::ALB;
                break;
            case 'Algeria': $countryId = App\Models\Country::DZA;
                break;
            case 'Angola': $countryId = App\Models\Country::AGO;
                break;
            case 'Antigua and Barbuda': $countryId = App\Models\Country::ATG;
                break;
            case 'Argentina': $countryId = App\Models\Country::ARG;
                break;
            case 'Armenia': $countryId = App\Models\Country::ARM;
                break;
            case 'Australia': $countryId = App\Models\Country::AUS;
                break;
            case 'Austria': $countryId = App\Models\Country::AUT;
                break;
            case 'Azerbaijan': $countryId = App\Models\Country::AZE;
                break;
            case 'Bahamas, The': $countryId = App\Models\Country::BHS;
                break;
            case 'Bahrain': $countryId = App\Models\Country::BHR;
                break;
            case 'Bangladesh': $countryId = App\Models\Country::BGD;
                break;
            case 'Barbados': $countryId = App\Models\Country::BRB;
                break;
            case 'Belarus': $countryId = App\Models\Country::BLR;
                break;
            case 'Belgium': $countryId = App\Models\Country::BEL;
                break;
            case 'Belize': $countryId = App\Models\Country::BLZ;
                break;
            case 'Benin': $countryId = App\Models\Country::BEN;
                break;
            case 'Bhutan': $countryId = App\Models\Country::BTN;
                break;
            case 'Bolivia': $countryId = App\Models\Country::BOL;
                break;
            case 'Bosnia and Herzegovina': $countryId = App\Models\Country::BIH;
                break;
            case 'Botswana': $countryId = App\Models\Country::BWA;
                break;
            case 'Brazil': $countryId = App\Models\Country::BRA;
                break;
            case 'Brunei': $countryId = App\Models\Country::BRN;
                break;
            case 'Bulgaria': $countryId = App\Models\Country::BGR;
                break;
            case 'Burkina Faso': $countryId = App\Models\Country::BFA;
                break;
            case 'Burundi': $countryId = App\Models\Country::BDI;
                break;
            case 'Cambodia': $countryId = App\Models\Country::KHM;
                break;
            case 'Cameroon': $countryId = App\Models\Country::CMR;
                break;
            case 'Canada': $countryId = App\Models\Country::CAN;
                break;
            case 'Cape Verde': $countryId = App\Models\Country::CPV;
                break;
            case 'Central African Republic': $countryId = App\Models\Country::CAF;
                break;
            case 'Chad': $countryId = App\Models\Country::TCD;
                break;
            case 'Chile': $countryId = App\Models\Country::CHL;
                break;
            case 'China': $countryId = App\Models\Country::CHN;
                break;
            case 'Colombia': $countryId = App\Models\Country::COL;
                break;
            case 'Comoros': $countryId = App\Models\Country::COM;
                break;
            case 'Congo, (Congo Â– Kinshasa)': $countryId = App\Models\Country::COD;
                break;
            case 'Congo, (Congo Â– Brazzaville)': $countryId = App\Models\Country::COG;
                break;
            case 'Costa Rica': $countryId = App\Models\Country::CRI;
                break;
            case 'Ivory Coast': $countryId = App\Models\Country::CIV;
                break;
            case 'Croatia': $countryId = App\Models\Country::HRV;
                break;
            case 'Cuba': $countryId = App\Models\Country::CUB;
                break;
            case 'Cyprus': $countryId = App\Models\Country::CYP;
                break;
            case 'Czech Republic': $countryId = App\Models\Country::CZE;
                break;
            case 'Denmark': $countryId = App\Models\Country::DNK;
                break;
            case 'Djibouti': $countryId = App\Models\Country::DJI;
                break;
            case 'Dominica': $countryId = App\Models\Country::DMA;
                break;
            case 'Dominican Republic': $countryId = App\Models\Country::DOM;
                break;
            case 'Ecuador': $countryId = App\Models\Country::ECU;
                break;
            case 'Egypt': $countryId = App\Models\Country::EGY;
                break;
            case 'El Salvador': $countryId = App\Models\Country::SLV;
                break;
            case 'Equatorial Guinea': $countryId = App\Models\Country::GNQ;
                break;
            case 'Eritrea': $countryId = App\Models\Country::ERI;
                break;
            case 'Estonia': $countryId = App\Models\Country::EST;
                break;
            case 'Ethiopia': $countryId = App\Models\Country::ETH;
                break;
            case 'Fiji': $countryId = App\Models\Country::FJI;
                break;
            case 'Finland': $countryId = App\Models\Country::FIN;
                break;
            case 'France': $countryId = App\Models\Country::FRA;
                break;
            case 'Gabon': $countryId = App\Models\Country::GAB;
                break;
            case 'Gambia, The': $countryId = App\Models\Country::GMB;
                break;
            case 'Georgia': $countryId = App\Models\Country::GEO;
                break;
            case 'Germany': $countryId = App\Models\Country::DEU;
                break;
            case 'Ghana': $countryId = App\Models\Country::GHA;
                break;
            case 'Greece': $countryId = App\Models\Country::GRC;
                break;
            case 'Grenada': $countryId = App\Models\Country::GRD;
                break;
            case 'Guatemala': $countryId = App\Models\Country::GTM;
                break;
            case 'Guinea': $countryId = App\Models\Country::GIN;
                break;
            case 'Guinea-Bissau': $countryId = App\Models\Country::GNB;
                break;
            case 'Guyana': $countryId = App\Models\Country::GUY;
                break;
            case 'Haiti': $countryId = App\Models\Country::HTI;
                break;
            case 'Honduras': $countryId = App\Models\Country::HND;
                break;
            case 'Hungary': $countryId = App\Models\Country::HUN;
                break;
            case 'Iceland': $countryId = App\Models\Country::ISL;
                break;
            case 'India': $countryId = App\Models\Country::IND;
                break;
            case 'Indonesia': $countryId = App\Models\Country::IDN;
                break;
            case 'Iran': $countryId = App\Models\Country::IRN;
                break;
            case 'Iraq': $countryId = App\Models\Country::IRQ;
                break;
            case 'Ireland': $countryId = App\Models\Country::IRL;
                break;
            case 'Israel': $countryId = App\Models\Country::ISR;
                break;
            case 'Italy': $countryId = App\Models\Country::ITA;
                break;
            case 'Jamaica': $countryId = App\Models\Country::JAM;
                break;
            case 'Japan': $countryId = App\Models\Country::JPN;
                break;
            case 'Jordan': $countryId = App\Models\Country::JOR;
                break;
            case 'Kazakhstan': $countryId = App\Models\Country::KAZ;
                break;
            case 'Kenya': $countryId = App\Models\Country::KEN;
                break;
            case 'Kiribati': $countryId = App\Models\Country::KIR;
                break;
            case 'Korea, North': $countryId = App\Models\Country::PRK;
                break;
            case 'Korea, South': $countryId = App\Models\Country::KOR;
                break;
            case 'Kuwait': $countryId = App\Models\Country::KWT;
                break;
            case 'Kyrgyzstan': $countryId = App\Models\Country::KGZ;
                break;
            case 'Laos': $countryId = App\Models\Country::LAO;
                break;
            case 'Latvia': $countryId = App\Models\Country::LVA;
                break;
            case 'Lebanon': $countryId = App\Models\Country::LBN;
                break;
            case 'Lesotho': $countryId = App\Models\Country::LSO;
                break;
            case 'Liberia': $countryId = App\Models\Country::LBR;
                break;
            case 'Libya': $countryId = App\Models\Country::LBY;
                break;
            case 'Liechtenstein': $countryId = App\Models\Country::LIE;
                break;
            case 'Lithuania': $countryId = App\Models\Country::LTU;
                break;
            case 'Luxembourg': $countryId = App\Models\Country::LUX;
                break;
            case 'Macedonia': $countryId = App\Models\Country::MKD;
                break;
            case 'Madagascar': $countryId = App\Models\Country::MDG;
                break;
            case 'Malawi': $countryId = App\Models\Country::MWI;
                break;
            case 'Malaysia': $countryId = App\Models\Country::MYS;
                break;
            case 'Maldives': $countryId = App\Models\Country::MDV;
                break;
            case 'Mali': $countryId = App\Models\Country::MLI;
                break;
            case 'Malta': $countryId = App\Models\Country::MLT;
                break;
            case 'Marshall Islands': $countryId = App\Models\Country::MHL;
                break;
            case 'Mauritania': $countryId = App\Models\Country::MRT;
                break;
            case 'Mauritius': $countryId = App\Models\Country::MUS;
                break;
            case 'Mexico': $countryId = App\Models\Country::MEX;
                break;
            case 'Micronesia': $countryId = App\Models\Country::FSM;
                break;
            case 'Moldova': $countryId = App\Models\Country::MDA;
                break;
            case 'Monaco': $countryId = App\Models\Country::MCO;
                break;
            case 'Mongolia': $countryId = App\Models\Country::MNG;
                break;
            case 'Montenegro': $countryId = App\Models\Country::MNE;
                break;
            case 'Morocco': $countryId = App\Models\Country::MAR;
                break;
            case 'Mozambique': $countryId = App\Models\Country::MOZ;
                break;
            case 'Myanmar (Burma)': $countryId = App\Models\Country::MMR;
                break;
            case 'Namibia': $countryId = App\Models\Country::NAM;
                break;
            case 'Nauru': $countryId = App\Models\Country::NRU;
                break;
            case 'Nepal': $countryId = App\Models\Country::NPL;
                break;
            case 'Netherlands': $countryId = App\Models\Country::NLD;
                break;
            case 'New Zealand': $countryId = App\Models\Country::NZL;
                break;
            case 'Nicaragua': $countryId = App\Models\Country::NIC;
                break;
            case 'Niger': $countryId = App\Models\Country::NER;
                break;
            case 'Nigeria': $countryId = App\Models\Country::NGA;
                break;
            case 'Norway': $countryId = App\Models\Country::NOR;
                break;
            case 'Oman': $countryId = App\Models\Country::OMN;
                break;
            case 'Pakistan': $countryId = App\Models\Country::PAK;
                break;
            case 'Palau': $countryId = App\Models\Country::PLW;
                break;
            case 'Panama': $countryId = App\Models\Country::PAN;
                break;
            case 'Papua New Guinea': $countryId = App\Models\Country::PNG;
                break;
            case 'Paraguay': $countryId = App\Models\Country::PRY;
                break;
            case 'Peru': $countryId = App\Models\Country::PER;
                break;
            case 'Philippines': $countryId = App\Models\Country::PHL;
                break;
            case 'Poland': $countryId = App\Models\Country::POL;
                break;
            case 'Portugal': $countryId = App\Models\Country::PRT;
                break;
            case 'Qatar': $countryId = App\Models\Country::QAT;
                break;
            case 'Romania': $countryId = App\Models\Country::ROU;
                break;
            case 'Russia': $countryId = App\Models\Country::RUS;
                break;
            case 'Rwanda': $countryId = App\Models\Country::RWA;
                break;
            case 'Saint Kitts and Nevis': $countryId = App\Models\Country::KNA;
                break;
            case 'Saint Lucia': $countryId = App\Models\Country::LCA;
                break;
            case 'Saint Vincent and the Grenadines': $countryId = App\Models\Country::VCT;
                break;
            case 'Samoa': $countryId = App\Models\Country::WSM;
                break;
            case 'San Marino': $countryId = App\Models\Country::SMR;
                break;
            case 'Sao Tome and Principe': $countryId = App\Models\Country::STP;
                break;
            case 'Saudi Arabia': $countryId = App\Models\Country::SAU;
                break;
            case 'Senegal': $countryId = App\Models\Country::SEN;
                break;
            case 'Serbia': $countryId = App\Models\Country::SRB;
                break;
            case 'Seychelles': $countryId = App\Models\Country::SYC;
                break;
            case 'Sierra Leone': $countryId = App\Models\Country::SLE;
                break;
            case 'Singapore': $countryId = App\Models\Country::SGP;
                break;
            case 'Slovakia': $countryId = App\Models\Country::SVK;
                break;
            case 'Slovenia': $countryId = App\Models\Country::SVN;
                break;
            case 'Solomon Islands': $countryId = App\Models\Country::SLB;
                break;
            case 'Somalia': $countryId = App\Models\Country::SOM;
                break;
            case 'South Africa': $countryId = App\Models\Country::ZAF;
                break;
            case 'Spain': $countryId = App\Models\Country::ESP;
                break;
            case 'Sri Lanka': $countryId = App\Models\Country::LKA;
                break;
            case 'Sudan': $countryId = App\Models\Country::SDN;
                break;
            case 'Suriname': $countryId = App\Models\Country::SUR;
                break;
            case 'Swaziland': $countryId = App\Models\Country::SWZ;
                break;
            case 'Sweden': $countryId = App\Models\Country::SWE;
                break;
            case 'Switzerland': $countryId = App\Models\Country::CHE;
                break;
            case 'Syria': $countryId = App\Models\Country::SYR;
                break;
            case 'Tajikistan': $countryId = App\Models\Country::TJK;
                break;
            case 'Tanzania': $countryId = App\Models\Country::TZA;
                break;
            case 'Thailand': $countryId = App\Models\Country::THA;
                break;
            case 'Timor-Leste (East Timor)': $countryId = App\Models\Country::TLS;
                break;
            case 'Togo': $countryId = App\Models\Country::TGO;
                break;
            case 'Tonga': $countryId = App\Models\Country::TON;
                break;
            case 'Trinidad and Tobago': $countryId = App\Models\Country::TTO;
                break;
            case 'Tunisia': $countryId = App\Models\Country::TUN;
                break;
            case 'Turkey': $countryId = App\Models\Country::TUR;
                break;
            case 'Turkmenistan': $countryId = App\Models\Country::TKM;
                break;
            case 'Tuvalu': $countryId = App\Models\Country::TUV;
                break;
            case 'Uganda': $countryId = App\Models\Country::UGA;
                break;
            case 'Ukraine': $countryId = App\Models\Country::UKR;
                break;
            case 'United Arab Emirates': $countryId = App\Models\Country::ARE;
                break;
            case 'United Kingdom': $countryId = App\Models\Country::GBR;
                break;
            case 'United States': $countryId = App\Models\Country::USA;
                break;
            case 'Uruguay': $countryId = App\Models\Country::URY;
                break;
            case 'Uzbekistan': $countryId = App\Models\Country::UZB;
                break;
            case 'Vanuatu': $countryId = App\Models\Country::VUT;
                break;
            case 'Vatican City': $countryId = App\Models\Country::VAT;
                break;
            case 'Venezuela': $countryId = App\Models\Country::VEN;
                break;
            case 'Vietnam': $countryId = App\Models\Country::VNM;
                break;
            case 'Yemen': $countryId = App\Models\Country::YEM;
                break;
            case 'Zambia': $countryId = App\Models\Country::ZMB;
                break;
            case 'Zimbabwe': $countryId = App\Models\Country::ZWE;
                break;
            case 'Abkhazia': $countryId = App\Models\Country::GEO;
                break;
            case 'China, Republic of (Taiwan)': $countryId = App\Models\Country::TWN;
                break;
            case 'Nagorno-Karabakh': $countryId = App\Models\Country::AZE;
                break;
            case 'Northern Cyprus': $countryId = App\Models\Country::CYP;
                break;
            case 'Pridnestrovie (Transnistria)': $countryId = App\Models\Country::MDA;
                break;
            case 'Somaliland': $countryId = App\Models\Country::SOM;
                break;
            case 'South Ossetia': $countryId = App\Models\Country::GEO;
                break;
            case 'Ashmore and Cartier Islands': $countryId = App\Models\Country::AUS;
                break;
            case 'Christmas Island': $countryId = App\Models\Country::CXR;
                break;
            case 'Cocos (Keeling) Islands': $countryId = App\Models\Country::CCK;
                break;
            case 'Coral Sea Islands': $countryId = App\Models\Country::AUS;
                break;
            case 'Heard Island and McDonald Islands': $countryId = App\Models\Country::HMD;
                break;
            case 'Norfolk Island': $countryId = App\Models\Country::NFK;
                break;
            case 'New Caledonia': $countryId = App\Models\Country::NCL;
                break;
            case 'French Polynesia': $countryId = App\Models\Country::PYF;
                break;
            case 'Mayotte': $countryId = App\Models\Country::MYT;
                break;
            case 'Saint Barthelemy': $countryId = App\Models\Country::GLP;
                break;
            case 'Saint Martin': $countryId = App\Models\Country::GLP;
                break;
            case 'Saint Pierre and Miquelon': $countryId = App\Models\Country::SPM;
                break;
            case 'Wallis and Futuna': $countryId = App\Models\Country::WLF;
                break;
            case 'French Southern and Antarctic Lands': $countryId = App\Models\Country::ATF;
                break;
            case 'Clipperton Island': $countryId = App\Models\Country::PYF;
                break;
            case 'Bouvet Island': $countryId = App\Models\Country::BVT;
                break;
            case 'Cook Islands': $countryId = App\Models\Country::COK;
                break;
            case 'Niue': $countryId = App\Models\Country::NIU;
                break;
            case 'Tokelau': $countryId = App\Models\Country::TKL;
                break;
            case 'Guernsey': $countryId = App\Models\Country::GGY;
                break;
            case 'Isle of Man': $countryId = App\Models\Country::IMN;
                break;
            case 'Jersey': $countryId = App\Models\Country::JEY;
                break;
            case 'Anguilla': $countryId = App\Models\Country::AIA;
                break;
            case 'Bermuda': $countryId = App\Models\Country::BMU;
                break;
            case 'British Indian Ocean Territory': $countryId = App\Models\Country::IOT;
                break;
//case 'British Sovereign Base Areas':                     $countryId = App\Models\Country::;                     break;
            case 'British Virgin Islands': $countryId = App\Models\Country::VGB;
                break;
            case 'Cayman Islands': $countryId = App\Models\Country::CYM;
                break;
            case 'Falkland Islands (Islas Malvinas)': $countryId = App\Models\Country::FLK;
                break;
            case 'Gibraltar': $countryId = App\Models\Country::GIB;
                break;
            case 'Montserrat': $countryId = App\Models\Country::MSR;
                break;
            case 'Pitcairn Islands': $countryId = App\Models\Country::PCN;
                break;
            case 'Saint Helena': $countryId = App\Models\Country::SHN;
                break;
            case 'South Georgia & South Sandwich Islands': $countryId = App\Models\Country::SGS;
                break;
            case 'Turks and Caicos Islands': $countryId = App\Models\Country::TCA;
                break;
            case 'Northern Mariana Islands': $countryId = App\Models\Country::MNP;
                break;
            case 'Puerto Rico': $countryId = App\Models\Country::PRI;
                break;
            case 'American Samoa': $countryId = App\Models\Country::ASM;
                break;
            case 'Baker Island': $countryId = App\Models\Country::UMI;
                break;
            case 'Guam': $countryId = App\Models\Country::GUM;
                break;
            case 'Howland Island': $countryId = App\Models\Country::UMI;
                break;
            case 'Jarvis Island': $countryId = App\Models\Country::UMI;
                break;
            case 'Johnston Atoll': $countryId = App\Models\Country::UMI;
                break;
            case 'Kingman Reef': $countryId = App\Models\Country::UMI;
                break;
            case 'Midway Islands': $countryId = App\Models\Country::UMI;
                break;
            case 'Navassa Island': $countryId = App\Models\Country::UMI;
                break;
            case 'Palmyra Atoll': $countryId = App\Models\Country::UMI;
                break;
            case 'U.S. Virgin Islands': $countryId = App\Models\Country::VIR;
                break;
            case 'Wake Island': $countryId = App\Models\Country::UMI;
                break;
            case 'Hong Kong': $countryId = App\Models\Country::HKG;
                break;
            case 'Macau': $countryId = App\Models\Country::MAC;
                break;
            case 'Faroe Islands': $countryId = App\Models\Country::FRO;
                break;
            case 'Greenland': $countryId = App\Models\Country::GRL;
                break;
            case 'French Guiana': $countryId = App\Models\Country::GUF;
                break;
            case 'Guadeloupe': $countryId = App\Models\Country::GLP;
                break;
            case 'Martinique': $countryId = App\Models\Country::MTQ;
                break;
            case 'Reunion': $countryId = App\Models\Country::REU;
                break;
            case 'Aland': $countryId = App\Models\Country::ALA;
                break;
            case 'Aruba': $countryId = App\Models\Country::ABW;
                break;
            case 'Netherlands Antilles': $countryId = App\Models\Country::ANT;
                break;
            case 'Svalbard': $countryId = App\Models\Country::SJM;
                break;
            case 'Ascension': $countryId = App\Models\Country::ASC;
                break;
            case 'Tristan da Cunha': $countryId = App\Models\Country::TAA;
                break;
            case 'Australian Antarctic Territory': $countryId = App\Models\Country::ATA;
                break;
            case 'Ross Dependency': $countryId = App\Models\Country::ATA;
                break;
            case 'Peter I Island': $countryId = App\Models\Country::ATA;
                break;
            case 'Queen Maud Land': $countryId = App\Models\Country::ATA;
                break;
            case 'British Antarctic Territory': $countryId = App\Models\Country::ATA;
                break;
        }

        DB::table('address')->insert([
            'id' => $id_address,
            'street_number' => $street_number,
            'street' => $street,
            'address_additional' => '',
            'postal_code' => $postal_code,
            'city_slug' => str_slug($city),
            'city' => $city,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'id_location_index' => $idLocationIndex,
            'id_country' => $countryId
        ]);

        DB::table('users')->insert([
            'id' => $id_user_owner,
            'gender' => 1, //créer une constante pour le genre 
            'name' => str_random(10),
            'lastname' => str_random(10),
            'password' => 'admin1234',
            'id_address' => $id_address,
            'id_inbox' => 0, //Créer la inbox
            'latitude' => 0,
            'longitude' => 0,
            'id_company' => 0
        ]);

        DB::table('establishments')->insert([
            'id' => $id_establishment,
            'name' => $non_etab,
            'email' => $email,
            'id_address' => $id_address,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'DS_ranking' => 2,
            'id_logo' => 0,
            'star' => 3.5,
            'site_url' => $site_url,
            'Description' => '',
            'average_price_min' => 10,
            'average_price_max' => 60,
            'id_user_owner' => $id_user_owner,
            'id_business_type' => 1,
            'url_id' => \App\Models\Establishment::generateStaticUrlId(\App\Utilities\UuidTools::getUuid($id_establishment)),
            'slug' => str_slug($non_etab),
        ]);

        $idBusinessCategory = self::getBusinessCategoryId($type_cuisine, 1);


        DB::table('establishment_business_categories')->insert([
            'id' => \App\Utilities\UuidTools::generateUuid(),
            'id_establishment' => $id_establishment,
            'id_business_category' => $idBusinessCategory
        ]);
    }

    function getBusinessCategoryId($name, $type) {
        try {
            $business_category = App\Models\BusinessCategory::where('name', $name)
                            ->where('type', $type)->first();
        } catch (Exception $ex) {
            
        }

        return $business_category->id;
    }

    function getIdLocationIndex($postalCode, $city, $lat, $lng, $countryName) {
        $idLocationIndex = 0;
        $locationIndex = App\Models\LocationIndex::where('city', '=', $city)->where('postal_code', '=', $postalCode)->first();
        if (checkModel($locationIndex)) {
            $idLocationIndex = $locationIndex->getId();
        } else {
            $countryId = null;
            switch ($countryName) {
                default :
                case 'Afghanistan': $countryId = App\Models\Country::AFG;
                    break;
                case 'Albania': $countryId = App\Models\Country::ALB;
                    break;
                case 'Algeria': $countryId = App\Models\Country::DZA;
                    break;
                case 'Angola': $countryId = App\Models\Country::AGO;
                    break;
                case 'Antigua and Barbuda': $countryId = App\Models\Country::ATG;
                    break;
                case 'Argentina': $countryId = App\Models\Country::ARG;
                    break;
                case 'Armenia': $countryId = App\Models\Country::ARM;
                    break;
                case 'Australia': $countryId = App\Models\Country::AUS;
                    break;
                case 'Austria': $countryId = App\Models\Country::AUT;
                    break;
                case 'Azerbaijan': $countryId = App\Models\Country::AZE;
                    break;
                case 'Bahamas, The': $countryId = App\Models\Country::BHS;
                    break;
                case 'Bahrain': $countryId = App\Models\Country::BHR;
                    break;
                case 'Bangladesh': $countryId = App\Models\Country::BGD;
                    break;
                case 'Barbados': $countryId = App\Models\Country::BRB;
                    break;
                case 'Belarus': $countryId = App\Models\Country::BLR;
                    break;
                case 'Belgium': $countryId = App\Models\Country::BEL;
                    break;
                case 'Belize': $countryId = App\Models\Country::BLZ;
                    break;
                case 'Benin': $countryId = App\Models\Country::BEN;
                    break;
                case 'Bhutan': $countryId = App\Models\Country::BTN;
                    break;
                case 'Bolivia': $countryId = App\Models\Country::BOL;
                    break;
                case 'Bosnia and Herzegovina': $countryId = App\Models\Country::BIH;
                    break;
                case 'Botswana': $countryId = App\Models\Country::BWA;
                    break;
                case 'Brazil': $countryId = App\Models\Country::BRA;
                    break;
                case 'Brunei': $countryId = App\Models\Country::BRN;
                    break;
                case 'Bulgaria': $countryId = App\Models\Country::BGR;
                    break;
                case 'Burkina Faso': $countryId = App\Models\Country::BFA;
                    break;
                case 'Burundi': $countryId = App\Models\Country::BDI;
                    break;
                case 'Cambodia': $countryId = App\Models\Country::KHM;
                    break;
                case 'Cameroon': $countryId = App\Models\Country::CMR;
                    break;
                case 'Canada': $countryId = App\Models\Country::CAN;
                    break;
                case 'Cape Verde': $countryId = App\Models\Country::CPV;
                    break;
                case 'Central African Republic': $countryId = App\Models\Country::CAF;
                    break;
                case 'Chad': $countryId = App\Models\Country::TCD;
                    break;
                case 'Chile': $countryId = App\Models\Country::CHL;
                    break;
                case 'China': $countryId = App\Models\Country::CHN;
                    break;
                case 'Colombia': $countryId = App\Models\Country::COL;
                    break;
                case 'Comoros': $countryId = App\Models\Country::COM;
                    break;
                case 'Congo, (Congo Â– Kinshasa)': $countryId = App\Models\Country::COD;
                    break;
                case 'Congo, (Congo Â– Brazzaville)': $countryId = App\Models\Country::COG;
                    break;
                case 'Costa Rica': $countryId = App\Models\Country::CRI;
                    break;
                case 'Ivory Coast': $countryId = App\Models\Country::CIV;
                    break;
                case 'Croatia': $countryId = App\Models\Country::HRV;
                    break;
                case 'Cuba': $countryId = App\Models\Country::CUB;
                    break;
                case 'Cyprus': $countryId = App\Models\Country::CYP;
                    break;
                case 'Czech Republic': $countryId = App\Models\Country::CZE;
                    break;
                case 'Denmark': $countryId = App\Models\Country::DNK;
                    break;
                case 'Djibouti': $countryId = App\Models\Country::DJI;
                    break;
                case 'Dominica': $countryId = App\Models\Country::DMA;
                    break;
                case 'Dominican Republic': $countryId = App\Models\Country::DOM;
                    break;
                case 'Ecuador': $countryId = App\Models\Country::ECU;
                    break;
                case 'Egypt': $countryId = App\Models\Country::EGY;
                    break;
                case 'El Salvador': $countryId = App\Models\Country::SLV;
                    break;
                case 'Equatorial Guinea': $countryId = App\Models\Country::GNQ;
                    break;
                case 'Eritrea': $countryId = App\Models\Country::ERI;
                    break;
                case 'Estonia': $countryId = App\Models\Country::EST;
                    break;
                case 'Ethiopia': $countryId = App\Models\Country::ETH;
                    break;
                case 'Fiji': $countryId = App\Models\Country::FJI;
                    break;
                case 'Finland': $countryId = App\Models\Country::FIN;
                    break;
                case 'France': $countryId = App\Models\Country::FRA;
                    break;
                case 'Gabon': $countryId = App\Models\Country::GAB;
                    break;
                case 'Gambia, The': $countryId = App\Models\Country::GMB;
                    break;
                case 'Georgia': $countryId = App\Models\Country::GEO;
                    break;
                case 'Germany': $countryId = App\Models\Country::DEU;
                    break;
                case 'Ghana': $countryId = App\Models\Country::GHA;
                    break;
                case 'Greece': $countryId = App\Models\Country::GRC;
                    break;
                case 'Grenada': $countryId = App\Models\Country::GRD;
                    break;
                case 'Guatemala': $countryId = App\Models\Country::GTM;
                    break;
                case 'Guinea': $countryId = App\Models\Country::GIN;
                    break;
                case 'Guinea-Bissau': $countryId = App\Models\Country::GNB;
                    break;
                case 'Guyana': $countryId = App\Models\Country::GUY;
                    break;
                case 'Haiti': $countryId = App\Models\Country::HTI;
                    break;
                case 'Honduras': $countryId = App\Models\Country::HND;
                    break;
                case 'Hungary': $countryId = App\Models\Country::HUN;
                    break;
                case 'Iceland': $countryId = App\Models\Country::ISL;
                    break;
                case 'India': $countryId = App\Models\Country::IND;
                    break;
                case 'Indonesia': $countryId = App\Models\Country::IDN;
                    break;
                case 'Iran': $countryId = App\Models\Country::IRN;
                    break;
                case 'Iraq': $countryId = App\Models\Country::IRQ;
                    break;
                case 'Ireland': $countryId = App\Models\Country::IRL;
                    break;
                case 'Israel': $countryId = App\Models\Country::ISR;
                    break;
                case 'Italy': $countryId = App\Models\Country::ITA;
                    break;
                case 'Jamaica': $countryId = App\Models\Country::JAM;
                    break;
                case 'Japan': $countryId = App\Models\Country::JPN;
                    break;
                case 'Jordan': $countryId = App\Models\Country::JOR;
                    break;
                case 'Kazakhstan': $countryId = App\Models\Country::KAZ;
                    break;
                case 'Kenya': $countryId = App\Models\Country::KEN;
                    break;
                case 'Kiribati': $countryId = App\Models\Country::KIR;
                    break;
                case 'Korea, North': $countryId = App\Models\Country::PRK;
                    break;
                case 'Korea, South': $countryId = App\Models\Country::KOR;
                    break;
                case 'Kuwait': $countryId = App\Models\Country::KWT;
                    break;
                case 'Kyrgyzstan': $countryId = App\Models\Country::KGZ;
                    break;
                case 'Laos': $countryId = App\Models\Country::LAO;
                    break;
                case 'Latvia': $countryId = App\Models\Country::LVA;
                    break;
                case 'Lebanon': $countryId = App\Models\Country::LBN;
                    break;
                case 'Lesotho': $countryId = App\Models\Country::LSO;
                    break;
                case 'Liberia': $countryId = App\Models\Country::LBR;
                    break;
                case 'Libya': $countryId = App\Models\Country::LBY;
                    break;
                case 'Liechtenstein': $countryId = App\Models\Country::LIE;
                    break;
                case 'Lithuania': $countryId = App\Models\Country::LTU;
                    break;
                case 'Luxembourg': $countryId = App\Models\Country::LUX;
                    break;
                case 'Macedonia': $countryId = App\Models\Country::MKD;
                    break;
                case 'Madagascar': $countryId = App\Models\Country::MDG;
                    break;
                case 'Malawi': $countryId = App\Models\Country::MWI;
                    break;
                case 'Malaysia': $countryId = App\Models\Country::MYS;
                    break;
                case 'Maldives': $countryId = App\Models\Country::MDV;
                    break;
                case 'Mali': $countryId = App\Models\Country::MLI;
                    break;
                case 'Malta': $countryId = App\Models\Country::MLT;
                    break;
                case 'Marshall Islands': $countryId = App\Models\Country::MHL;
                    break;
                case 'Mauritania': $countryId = App\Models\Country::MRT;
                    break;
                case 'Mauritius': $countryId = App\Models\Country::MUS;
                    break;
                case 'Mexico': $countryId = App\Models\Country::MEX;
                    break;
                case 'Micronesia': $countryId = App\Models\Country::FSM;
                    break;
                case 'Moldova': $countryId = App\Models\Country::MDA;
                    break;
                case 'Monaco': $countryId = App\Models\Country::MCO;
                    break;
                case 'Mongolia': $countryId = App\Models\Country::MNG;
                    break;
                case 'Montenegro': $countryId = App\Models\Country::MNE;
                    break;
                case 'Morocco': $countryId = App\Models\Country::MAR;
                    break;
                case 'Mozambique': $countryId = App\Models\Country::MOZ;
                    break;
                case 'Myanmar (Burma)': $countryId = App\Models\Country::MMR;
                    break;
                case 'Namibia': $countryId = App\Models\Country::NAM;
                    break;
                case 'Nauru': $countryId = App\Models\Country::NRU;
                    break;
                case 'Nepal': $countryId = App\Models\Country::NPL;
                    break;
                case 'Netherlands': $countryId = App\Models\Country::NLD;
                    break;
                case 'New Zealand': $countryId = App\Models\Country::NZL;
                    break;
                case 'Nicaragua': $countryId = App\Models\Country::NIC;
                    break;
                case 'Niger': $countryId = App\Models\Country::NER;
                    break;
                case 'Nigeria': $countryId = App\Models\Country::NGA;
                    break;
                case 'Norway': $countryId = App\Models\Country::NOR;
                    break;
                case 'Oman': $countryId = App\Models\Country::OMN;
                    break;
                case 'Pakistan': $countryId = App\Models\Country::PAK;
                    break;
                case 'Palau': $countryId = App\Models\Country::PLW;
                    break;
                case 'Panama': $countryId = App\Models\Country::PAN;
                    break;
                case 'Papua New Guinea': $countryId = App\Models\Country::PNG;
                    break;
                case 'Paraguay': $countryId = App\Models\Country::PRY;
                    break;
                case 'Peru': $countryId = App\Models\Country::PER;
                    break;
                case 'Philippines': $countryId = App\Models\Country::PHL;
                    break;
                case 'Poland': $countryId = App\Models\Country::POL;
                    break;
                case 'Portugal': $countryId = App\Models\Country::PRT;
                    break;
                case 'Qatar': $countryId = App\Models\Country::QAT;
                    break;
                case 'Romania': $countryId = App\Models\Country::ROU;
                    break;
                case 'Russia': $countryId = App\Models\Country::RUS;
                    break;
                case 'Rwanda': $countryId = App\Models\Country::RWA;
                    break;
                case 'Saint Kitts and Nevis': $countryId = App\Models\Country::KNA;
                    break;
                case 'Saint Lucia': $countryId = App\Models\Country::LCA;
                    break;
                case 'Saint Vincent and the Grenadines': $countryId = App\Models\Country::VCT;
                    break;
                case 'Samoa': $countryId = App\Models\Country::WSM;
                    break;
                case 'San Marino': $countryId = App\Models\Country::SMR;
                    break;
                case 'Sao Tome and Principe': $countryId = App\Models\Country::STP;
                    break;
                case 'Saudi Arabia': $countryId = App\Models\Country::SAU;
                    break;
                case 'Senegal': $countryId = App\Models\Country::SEN;
                    break;
                case 'Serbia': $countryId = App\Models\Country::SRB;
                    break;
                case 'Seychelles': $countryId = App\Models\Country::SYC;
                    break;
                case 'Sierra Leone': $countryId = App\Models\Country::SLE;
                    break;
                case 'Singapore': $countryId = App\Models\Country::SGP;
                    break;
                case 'Slovakia': $countryId = App\Models\Country::SVK;
                    break;
                case 'Slovenia': $countryId = App\Models\Country::SVN;
                    break;
                case 'Solomon Islands': $countryId = App\Models\Country::SLB;
                    break;
                case 'Somalia': $countryId = App\Models\Country::SOM;
                    break;
                case 'South Africa': $countryId = App\Models\Country::ZAF;
                    break;
                case 'Spain': $countryId = App\Models\Country::ESP;
                    break;
                case 'Sri Lanka': $countryId = App\Models\Country::LKA;
                    break;
                case 'Sudan': $countryId = App\Models\Country::SDN;
                    break;
                case 'Suriname': $countryId = App\Models\Country::SUR;
                    break;
                case 'Swaziland': $countryId = App\Models\Country::SWZ;
                    break;
                case 'Sweden': $countryId = App\Models\Country::SWE;
                    break;
                case 'Switzerland': $countryId = App\Models\Country::CHE;
                    break;
                case 'Syria': $countryId = App\Models\Country::SYR;
                    break;
                case 'Tajikistan': $countryId = App\Models\Country::TJK;
                    break;
                case 'Tanzania': $countryId = App\Models\Country::TZA;
                    break;
                case 'Thailand': $countryId = App\Models\Country::THA;
                    break;
                case 'Timor-Leste (East Timor)': $countryId = App\Models\Country::TLS;
                    break;
                case 'Togo': $countryId = App\Models\Country::TGO;
                    break;
                case 'Tonga': $countryId = App\Models\Country::TON;
                    break;
                case 'Trinidad and Tobago': $countryId = App\Models\Country::TTO;
                    break;
                case 'Tunisia': $countryId = App\Models\Country::TUN;
                    break;
                case 'Turkey': $countryId = App\Models\Country::TUR;
                    break;
                case 'Turkmenistan': $countryId = App\Models\Country::TKM;
                    break;
                case 'Tuvalu': $countryId = App\Models\Country::TUV;
                    break;
                case 'Uganda': $countryId = App\Models\Country::UGA;
                    break;
                case 'Ukraine': $countryId = App\Models\Country::UKR;
                    break;
                case 'United Arab Emirates': $countryId = App\Models\Country::ARE;
                    break;
                case 'United Kingdom': $countryId = App\Models\Country::GBR;
                    break;
                case 'United States': $countryId = App\Models\Country::USA;
                    break;
                case 'Uruguay': $countryId = App\Models\Country::URY;
                    break;
                case 'Uzbekistan': $countryId = App\Models\Country::UZB;
                    break;
                case 'Vanuatu': $countryId = App\Models\Country::VUT;
                    break;
                case 'Vatican City': $countryId = App\Models\Country::VAT;
                    break;
                case 'Venezuela': $countryId = App\Models\Country::VEN;
                    break;
                case 'Vietnam': $countryId = App\Models\Country::VNM;
                    break;
                case 'Yemen': $countryId = App\Models\Country::YEM;
                    break;
                case 'Zambia': $countryId = App\Models\Country::ZMB;
                    break;
                case 'Zimbabwe': $countryId = App\Models\Country::ZWE;
                    break;
                case 'Abkhazia': $countryId = App\Models\Country::GEO;
                    break;
                case 'China, Republic of (Taiwan)': $countryId = App\Models\Country::TWN;
                    break;
                case 'Nagorno-Karabakh': $countryId = App\Models\Country::AZE;
                    break;
                case 'Northern Cyprus': $countryId = App\Models\Country::CYP;
                    break;
                case 'Pridnestrovie (Transnistria)': $countryId = App\Models\Country::MDA;
                    break;
                case 'Somaliland': $countryId = App\Models\Country::SOM;
                    break;
                case 'South Ossetia': $countryId = App\Models\Country::GEO;
                    break;
                case 'Ashmore and Cartier Islands': $countryId = App\Models\Country::AUS;
                    break;
                case 'Christmas Island': $countryId = App\Models\Country::CXR;
                    break;
                case 'Cocos (Keeling) Islands': $countryId = App\Models\Country::CCK;
                    break;
                case 'Coral Sea Islands': $countryId = App\Models\Country::AUS;
                    break;
                case 'Heard Island and McDonald Islands': $countryId = App\Models\Country::HMD;
                    break;
                case 'Norfolk Island': $countryId = App\Models\Country::NFK;
                    break;
                case 'New Caledonia': $countryId = App\Models\Country::NCL;
                    break;
                case 'French Polynesia': $countryId = App\Models\Country::PYF;
                    break;
                case 'Mayotte': $countryId = App\Models\Country::MYT;
                    break;
                case 'Saint Barthelemy': $countryId = App\Models\Country::GLP;
                    break;
                case 'Saint Martin': $countryId = App\Models\Country::GLP;
                    break;
                case 'Saint Pierre and Miquelon': $countryId = App\Models\Country::SPM;
                    break;
                case 'Wallis and Futuna': $countryId = App\Models\Country::WLF;
                    break;
                case 'French Southern and Antarctic Lands': $countryId = App\Models\Country::ATF;
                    break;
                case 'Clipperton Island': $countryId = App\Models\Country::PYF;
                    break;
                case 'Bouvet Island': $countryId = App\Models\Country::BVT;
                    break;
                case 'Cook Islands': $countryId = App\Models\Country::COK;
                    break;
                case 'Niue': $countryId = App\Models\Country::NIU;
                    break;
                case 'Tokelau': $countryId = App\Models\Country::TKL;
                    break;
                case 'Guernsey': $countryId = App\Models\Country::GGY;
                    break;
                case 'Isle of Man': $countryId = App\Models\Country::IMN;
                    break;
                case 'Jersey': $countryId = App\Models\Country::JEY;
                    break;
                case 'Anguilla': $countryId = App\Models\Country::AIA;
                    break;
                case 'Bermuda': $countryId = App\Models\Country::BMU;
                    break;
                case 'British Indian Ocean Territory': $countryId = App\Models\Country::IOT;
                    break;
                case 'British Virgin Islands': $countryId = App\Models\Country::VGB;
                    break;
                case 'Cayman Islands': $countryId = App\Models\Country::CYM;
                    break;
                case 'Falkland Islands (Islas Malvinas)': $countryId = App\Models\Country::FLK;
                    break;
                case 'Gibraltar': $countryId = App\Models\Country::GIB;
                    break;
                case 'Montserrat': $countryId = App\Models\Country::MSR;
                    break;
                case 'Pitcairn Islands': $countryId = App\Models\Country::PCN;
                    break;
                case 'Saint Helena': $countryId = App\Models\Country::SHN;
                    break;
                case 'South Georgia & South Sandwich Islands': $countryId = App\Models\Country::SGS;
                    break;
                case 'Turks and Caicos Islands': $countryId = App\Models\Country::TCA;
                    break;
                case 'Northern Mariana Islands': $countryId = App\Models\Country::MNP;
                    break;
                case 'Puerto Rico': $countryId = App\Models\Country::PRI;
                    break;
                case 'American Samoa': $countryId = App\Models\Country::ASM;
                    break;
                case 'Baker Island': $countryId = App\Models\Country::UMI;
                    break;
                case 'Guam': $countryId = App\Models\Country::GUM;
                    break;
                case 'Howland Island': $countryId = App\Models\Country::UMI;
                    break;
                case 'Jarvis Island': $countryId = App\Models\Country::UMI;
                    break;
                case 'Johnston Atoll': $countryId = App\Models\Country::UMI;
                    break;
                case 'Kingman Reef': $countryId = App\Models\Country::UMI;
                    break;
                case 'Midway Islands': $countryId = App\Models\Country::UMI;
                    break;
                case 'Navassa Island': $countryId = App\Models\Country::UMI;
                    break;
                case 'Palmyra Atoll': $countryId = App\Models\Country::UMI;
                    break;
                case 'U.S. Virgin Islands': $countryId = App\Models\Country::VIR;
                    break;
                case 'Wake Island': $countryId = App\Models\Country::UMI;
                    break;
                case 'Hong Kong': $countryId = App\Models\Country::HKG;
                    break;
                case 'Macau': $countryId = App\Models\Country::MAC;
                    break;
                case 'Faroe Islands': $countryId = App\Models\Country::FRO;
                    break;
                case 'Greenland': $countryId = App\Models\Country::GRL;
                    break;
                case 'French Guiana': $countryId = App\Models\Country::GUF;
                    break;
                case 'Guadeloupe': $countryId = App\Models\Country::GLP;
                    break;
                case 'Martinique': $countryId = App\Models\Country::MTQ;
                    break;
                case 'Reunion': $countryId = App\Models\Country::REU;
                    break;
                case 'Aland': $countryId = App\Models\Country::ALA;
                    break;
                case 'Aruba': $countryId = App\Models\Country::ABW;
                    break;
                case 'Netherlands Antilles': $countryId = App\Models\Country::ANT;
                    break;
                case 'Svalbard': $countryId = App\Models\Country::SJM;
                    break;
                case 'Ascension': $countryId = App\Models\Country::ASC;
                    break;
                case 'Tristan da Cunha': $countryId = App\Models\Country::TAA;
                    break;
                case 'Australian Antarctic Territory': $countryId = App\Models\Country::ATA;
                    break;
                case 'Ross Dependency': $countryId = App\Models\Country::ATA;
                    break;
                case 'Peter I Island': $countryId = App\Models\Country::ATA;
                    break;
                case 'Queen Maud Land': $countryId = App\Models\Country::ATA;
                    break;
                case 'British Antarctic Territory': $countryId = App\Models\Country::ATA;
                    break;
            }
            $locationIndex = App\Models\LocationIndex::insert([
                        'id' => \App\Utilities\UuidTools::generateUuid(),
                        'postal_code' => $postalCode,
                        'city' => $city,
                        'latitude' => $lat,
                        'longitude' => $lng,
                        'id_country' => $countryId
            ]);
            if (checkModel($locationIndex)) {
                $idLocationIndex = $locationIndex->getId();
            }
        }
        return $idLocationIndex;
    }

}
