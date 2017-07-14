<?php

use Illuminate\Database\Seeder;

 

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    
     function makeTestData($non_etab,$street,$street_number,$postal_code,$city,$country,$latitude,$longitude,$email,$site_url,$type_cuisine,$descn, $id_business_category){
        
        $company_id = hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        $id_location_index = hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        $id_user_owner = hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        $id_business_type = \App\Models\Restaurant::TYPE_BUSINESS_RESTAURANT;
        $id_establishment = hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        $id_address = hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
           
      DB::table('users')->insert([
            'id' =>   $id_user_owner,
            'gender' => 1 , //créer une constante pour le genre 
            'name' => str_random(10),
            'lastname' => str_random(10),
            'password' => 'admin1234',
            'id_address' => $id_address,
            'id_inbox' => 0,   //Créer la inbox
            'latitude' => 46.658954,
            'longitude' => 6.486621,
            'id_company' => $company_id
        ]);     
      DB::table('address')->insert([
            'id' => $id_address, 
            'street_number' => $street_number ,
            'street' => $street,
            'address_additional' => '',
            'postal_code' => $postal_code,
            'city' => $city,
            'country' => $country,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'id_location_index' => $id_location_index 
        ]);
             DB::table('companies')->insert([
            'id' => $company_id, 
            'id_logo' => 0 ,
            'name' => 'Broadway' 
        ]);
             
             
             DB::table('establishments')->insert([
            'id' => $id_establishment, 
            'name' => $non_etab,
            'email' => $email,   
            'id_address' => $id_address ,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'DS_ranking' => 2 ,
            'id_logo' => 0,
            'star' => 3.5,
            'site_url' => $site_url,
            'Description' => 'Il fallait bin commencer par quelque part !! C\'est dans ces grande ligne',
            'average_price_min' => 10,
            'average_price_max' => 60,
            'id_user_owner' => $id_user_owner,
            'id_business_type' => $id_business_type
        ]);
             
             DB::table('establishment_business_categories')->insert([
            'id' => hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4())), 
            'id_establishment' => $id_establishment,
            'id_business_category' => $id_business_category
        ]);            
             DB::table('dishes')->insert([
            'id' => hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4())), 
            'name' => str_random(10),
            'description' => str_random(10).'@dinerscope.ch',   
            'price' => 30 ,
            'id_establishment'=>$id_establishment,
            'id_photo' => 0 
        ]);    
         
            DB::table('business_categories')->insert([
            'id' => hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4())), 
            'name' => $type_cuisine,
            'type' => 1,  //const type de cuisinne
        ]);    
        
    }
    
    public function run()
    {    

           $id= hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        
        DatabaseSeeder::makeTestData('Broadway Restaurant','chemin Malombré ',18,1202,'Genève','Suisse',46.1954749,6.1496726,'restaurantbroadway.com','Restaurant Franconien ','descn','',$id);
        DatabaseSeeder::makeTestData('Restaurant Le Pradier','Rue Pradier',6,1201,'Genève','Suisse',46.1945955,6.1453122,'lepradier.com','Restaurant Franconien ','descn','','',$id);
        DatabaseSeeder::makeTestData('Restaurant Chausse-Coqs','Rue Micheli-du-Crest',18,1205,'Genève','Suisse',46.1945955,6.1453122,'chausse-coqs.ch','Restaurant Franconien ','descn','','',$id);
        $id= hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        DatabaseSeeder::makeTestData('Pékin Palace','Rue des Alpes',22,1201,'Genève','Suisse',46.2109976,6.1425921,'pekin-palace.thefork.rest','Restaurant Chinois ','descn','',$id);
        DatabaseSeeder::makeTestData('Restaurant Wang','Rue des Eaux-Vives',9,1207,'Genève','Suisse',46.2033257,6.1550633,'restaurant-wang.ch','Restaurant Chinois ','descn','',$id);
        $id= hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        DatabaseSeeder::makeTestData('Matsuri','Rue de la Confédération',8,1204,'Genève','Suisse',46.2035711,6.1424213,'matsuri.ch','Restaurant Japonais ','descn','',$id);
        $id= hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        DatabaseSeeder::makeTestData('Gaùcho Churrascaria','Chemin Malombré ',1,1206,'Genève','Suisse',46.196326,6.15203,'churrascaria-gaucho.com','Restaurant Brésilien ','descn','',$id);
        $id= hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        DatabaseSeeder::makeTestData('Thaï tastes café & restaurant','Rue de la Servette',16,1201,'Genève','Suisse',46.2102704,6.1356,'thaitastes .ch','Restaurant Thaïlandais ','descn','',$id); 
        $id= hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        DatabaseSeeder::makeTestData('Contact - Bar et Restaurant','Rue du Prieuré',8,1202,'Genève','Suisse',46.2972433,6.1230715,'jimma.ch','Restaurant Ethiopien ','descn','',$id);
        $id= hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        DatabaseSeeder::makeTestData('Chez Sami','Rue de fribourg ',11,1201,'Genève','Suisse',46.3390482,6.2137802,'chezsami.ch','Restaurant Libanais','descn','',$id);
        DatabaseSeeder::makeTestData('Restaurant Arabesque','Quai Wilson',47,1201,'Genève','Suisse',46.2148921,6.1488857,'restaurantarabesque.com','Restaurant Libanais','descn','',$id);
        $id= hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        DatabaseSeeder::makeTestData('Le Léman','Rue de Rive ',28,1260,'Nyon','Suisse',46.3803758,6.240229,'restorive-nyon.ch','Restaurant Suisse','descn','',$id);
        $id= hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        DatabaseSeeder::makeTestData('L Auberge du Château','Place du Château',8,1260,'Nyon','Suisse',46.3819953,6.2385886,'aubergeduchateau.ch','Restaurant Italien','descn','',$id);
        DatabaseSeeder::makeTestData('Le Grand Café - Hôtel Real','Place de Savoie ',1,1260,'Nyon','Suisse',46.3806361,6.2393026,'hotlerealnyon.ch','Restaurant Italien','descn','',$id);
        $id= hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        DatabaseSeeder::makeTestData('Café du Raisin','Gran Rue',26,1268,'Begnins','Suisse',46.4153124,6.2117013,'','Restaurant des Saisons','descn','',$id);
        $id= hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        DatabaseSeeder::makeTestData('Khãnã Mandir','Place du Marché',1,1260,'Nyon','Suisse',46.381897,6.2363523,'khanamandir.ch','Restaurant Indien','descn','',$id);
        $id= hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        DatabaseSeeder::makeTestData('Le Club House','Avenue du Mont-Blanc',38,1196,'Gland','Suisse',46.4139564,6.2736606,'leclubhouse.ch','Bar Lounge','descn','',$id);
        DatabaseSeeder::makeTestData('Café des Moulins','Rue de la Colombière',12,1260,'Nyon','Suisse',46.3899031,6.2151437,'restorive-nyon.ch','Bar Lounge','descn','',$id);
        $id= hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        DatabaseSeeder::makeTestData('Hôtel Restaurant La Truite','Grand-Rue',203,1220,'Divonnes-les-Bains','France',46.3296795,6.1153798,'hotelrestaurantlatruite.com','Cuisine Traditionnelle','descn','',$id);
        $id= hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        DatabaseSeeder::makeTestData('Linstant Restaurant ','Place Perdtemps',9,1220,'Divonnes-les-Bains','France',46.357373,6.117848,'restaurantdivonne-les-bains.fr','Cuisine des Saisons','descn','',$id);
        DatabaseSeeder::makeTestData('Château de Divonne','Rue des Bains',115,1220,'Divonnes-les-Bains','France',46.3563213,6.1317597,'château-divonne.com','Cuisine Gastronomique','descn','',$id);
        $id= hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        DatabaseSeeder::makeTestData('Restaurant Le Nabab ','Avenue de Genève ',252,1220,'Divonnes-les-Bains','France',46.3533643,6.1400721,'lenabab-restaurant.fr','Cuisine Indienne','descn','',$id);

    }
}
