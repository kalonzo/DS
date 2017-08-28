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
            'type' => App\Models\BuyableItem::TYPE_PRO_SUBSCRIPTION_LEVEL1,
//            'unit_price_HT',
            'unit_price_TTC' => 250,
            'vat_rate' => 8,
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
            'type' => App\Models\BuyableItem::TYPE_PRO_SUBSCRIPTION_LEVEL2,
//            'unit_price_HT',
            'unit_price_TTC' => 350,
            'vat_rate' => 8,
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
            'type' => App\Models\BuyableItem::TYPE_PRO_SUBSCRIPTION_LEVEL3,
//            'unit_price_HT',
            'unit_price_TTC' => 450,
            'vat_rate' => 8,
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
            'type' => App\Models\BuyableItem::TYPE_PRO_SUBSCRIPTION_LEVEL4,
//            'unit_price_HT',
            'unit_price_TTC' => 600,
            'vat_rate' => 8,
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
            case 'Switzerland': $countryId = App\Models\Country::CHE;
                break;
            case 'France': $countryId = App\Models\Country::FRA;
                break;
        }

       $address = \App\Models\Address::create([
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

       $ets =  \App\Models\Establishment::create([
            'id' => $id_establishment,
            'name' => $non_etab,
            'email' => $email,
            'id_address' => $address->getId(),
            'latitude' => $latitude,
            'longitude' => $longitude,
            'DS_ranking' => 2,
            'id_logo' => 0,
            'star' => 3.5,
            'status' => \App\Models\Establishment::STATUS_ACTIVE,
            'site_url' => $site_url,
            'Description' => '',
            'average_price_min' => 10,
            'average_price_max' => 60,
            'id_user_owner' => 0,
            'id_business_type' => 1,
            'url_id' => \App\Models\Establishment::generateStaticUrlId(\App\Utilities\UuidTools::getUuid($id_establishment)),
            'slug' => str_slug($non_etab),
        ]);

        $idBusinessCategory = self::getBusinessCategoryId($type_cuisine, 1);


        \App\Models\EstablishmentBusinessCategory::create([
            'id' => \App\Utilities\UuidTools::generateUuid(),
            'id_establishment' => $ets->getId(),
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
                case 'Switzerland': $countryId = App\Models\Country::CHE;
                    break;
                case 'France': $countryId = App\Models\Country::FRA;
                    break;                
            }
            $locationIndex = App\Models\LocationIndex::create([
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
