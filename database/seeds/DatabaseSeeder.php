<?php

use Illuminate\Database\Seeder;

 

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    
     function makeTestData($non_etab,$street,$street_number,$postal_code,$city,$country,$latitude,$longitude,$email,$site_url,$type_cuisine,$descn){
        
        $company_id = hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        $id_location_index = hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        $id_user_owner = hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        $id_business_type = \App\Models\Restaurant::TYPE_BUSINESS_RESTAURANT;
        $id_establishment = hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        $id_address = hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        $id_business_category = hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        
        $id = hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4())); 
        
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
            'id' => $id_business_category, 
            'name' => 'Cuisine Française',
            'type' => 1,  //const type de plat 
        ]);    
        
    }
    
    public function run()
    {    

        DatabaseSeeder::makeTestData('Restaurant le Pradier','Rue Pradier',6,1201,'Genève','Suisse',46.2095666,6.1437003,'info@kalonzo.ch','perdu.com','original','1 desciption');
        
        DatabaseSeeder::makeTestData('Broadway Restaurant','chemin Malombré' ,18,1202,'Genève','Suisse',46.4119911,6.0023839,'restaurantbroadway.com','Restaurant Franconien ','desciption','');

        DatabaseSeeder::makeTestData('Restaurant Le Nabab ','Avenue de Genève',252,1220,'Divonnes-les-Bains','France',46.3533643,6.1400721,'lenabab-restaurant.fr','Cuisine Indienne','1 desciption','');

        
        


    }
}
