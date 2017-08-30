<?php
namespace App\Http\Controllers;

use App\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use View;
use App\Models\Address;
use App\Models\Country;
use App\Models\LocationIndex;
use App\Models\Establishment;
use App\Utilities\UuidTools;
use App\Models\BusinessCategory;
use Illuminate\Support\Facades\DB;

class ImportRestaurantController extends Controller {

    /**
     * 
     * @return View
     */
    public function index() {
        $view = View::make('establishment.import');
        return $view;
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function import(Request $request) {
        $file = \Illuminate\Support\Facades\Request::file('excel');
        if (!empty($file)) {
            if ($file->isValid()) {
                $relPath = $file->store('/import_tmp');
                $absolutePath = Storage::path($relPath);

                Excel::load($absolutePath, function($reader) {
                    $sheets = $reader->all();
                    if (!empty($sheets)) {
                        foreach ($sheets as $sheet) {
                            $nameEstablishment = null;
                            $street = null;
                            $streetNumber = null;
                            $street_2 = null;
                            $poBox = null;
                            $postalCode = null;
                            $region = null;
                            $district = null;
                            $cookingType = null;
                            $speciality = null;
                            $country = null;
                            $phonePro = null;
                            $email = null;
                            $siteWeb = null;
                            $city = null;
                            $department = null;
                            $description = null;
                            $service = null;
                            $ambiance = null;
                            $status = null;
                            $lat = null;
                            $lng = null;
                            $lundi = null;
                            $mardi = null;
                            $mercredi = null;
                            $jeudi = null;
                            $vendredi = null;
                            $samedi = null;
                            $dimanche = null;
                            foreach ($sheet as $numRow => $row) {
                                if ($numRow > 0) { //&& $numRow < 10
                                    foreach ($row as $col_slug => $cellContent) {
                                        if ($col_slug === 'nom_etab.') {
                                            $nameEstablishment = $cellContent;
                                        } elseif ($col_slug === 'adresse_1') {
                                            $street = $cellContent;
                                        } elseif ($col_slug === 'numero') {
                                            $streetNumber = $cellContent;
                                        } elseif ($col_slug === 'adresse_2') {
                                            $street_2 = $cellContent;
                                        } elseif ($col_slug === 'boite_postal') {
                                            $poBox = $cellContent;
                                        } elseif ($col_slug === 'npa') {
                                            $postalCode = $cellContent;
                                        } elseif ($col_slug === 'region') {
                                            $region = $cellContent;
                                        } elseif ($col_slug === 'district') {
                                            $district = $cellContent;
                                        } elseif ($col_slug === 'localite') {
                                            $city = $cellContent;
                                        } elseif ($col_slug === 'canton_departements') {
                                            $department = $cellContent;
                                        } elseif ($col_slug === 'pays') {
                                            $country = $cellContent;
                                        } elseif ($col_slug === 'telephone') {
                                            $phonePro = $cellContent;
                                        } elseif ($col_slug === 'email') {
                                            $email = $cellContent;
                                        } elseif ($col_slug === 'site_web') {
                                            $siteWeb = $cellContent;
                                        } elseif ($col_slug === 'type_de_cuisine') {
                                            $cookingType = explode(';', $cellContent) ;
                                        } elseif ($col_slug === 'specialites') {
                                            $speciality = explode(';', $cellContent) ;
                                        } elseif ($col_slug === 'description_detaillee') {
                                            $description = $cellContent;
                                        } elseif ($col_slug === 'services') {
                                            $service = explode(';', $cellContent) ;
                                        } elseif ($col_slug === 'cadre_ambiance') {
                                            $ambiance = explode(';',$cellContent) ;
                                        } elseif ($col_slug === 'lundi') {
                                            $lundi = $cellContent;
                                        } elseif ($col_slug === 'mardi') {
                                            $mardi = $cellContent;
                                        } elseif ($col_slug === 'mercredi') {
                                            $mercredi = $cellContent;
                                        } elseif ($col_slug === 'jeudi') {
                                            $jeudi = $cellContent;
                                        } elseif ($col_slug === 'vendredi') {
                                            $vendredi = $cellContent;
                                        } elseif ($col_slug === 'samedi') {
                                            $samedi = $cellContent;
                                        } elseif ($col_slug === 'dimanche') {
                                            $dimanche = $cellContent;
                                        }
                                    }
                                }

                                $addressEstablishment = Address::where('street_number', '=', $streetNumber)->where('street', '=', $street)
                                                ->where('postal_code', '=', $postalCode)->where('city', '=', $city)->first();

                                //On vérifie que la requête soit suffisamment compléte pour la geolocalisation
                                if ((!checkModel($addressEstablishment) && isset($nameEstablishment) && isset($street) && isset($streetNumber) 
                                        && isset($postalCode) && isset($city))) {
                                    $data = self::getLatLng($nameEstablishment, $street, $streetNumber, $postalCode, $country, $city);
                                    if (isset($data['results'][0]['geometry']['location']['lat'])) {
                                        $lat = $data['results'][0]['geometry']['location']['lat'];
                                        $lng = $data['results'][0]['geometry']['location']['lng'];
                                        $streetNumber = $data['results'][0]['address_components'][0]['short_name'];
                                        $street = $data['results'][0]['address_components'][1]['short_name'];
                                        $city = $data['results'][0]['address_components'][2]['short_name'];
                                        $department = $data['results'][0]['address_components'][3]['short_name'];
                                       //$country = $data['results'][0]['address_components'][5]['long_name'];
                                        //$postalCode = $data['results'][0]['address_components'][6]['long_name'];
                                        //print_r('$department->' . $department . ' $country->' . $country . ' city->' . $postalCode);
                                        $status = Establishment::STATUS_ACTIVE;
                                        
                                        $addressEstablishment = Address::where('street_number', '=', $streetNumber)->where('street', '=', $street)
                                                ->where('postal_code', '=', $postalCode)->where('city', '=', $city)->first(); 
                                        if(!checkModel($addressEstablishment)){
                                             self::insertETS($nameEstablishment, $street, $street_2, $streetNumber, $postalCode, $region, $district, 
                                                $city, $country, $lat, $lng, $email, $siteWeb, $description, $cookingType, $speciality, $service, 
                                                $ambiance, $phonePro, $status, null, null);
                                                print_r('La ligne ' . $nameEstablishment . ' est insérer<br>');
                                        }
                                    } else {
                                        print_r('La ligne ' . $nameEstablishment . ' est incomplete<br>');
                                        $status = Establishment::STATUS_INCOMPLETE;
                                        self::insertETS($nameEstablishment, $street, $street_2, $streetNumber, $postalCode, $region, $district, 
                                                $city, $country, $lat, $lng, $email, $siteWeb, $description, $cookingType, $speciality, $service, 
                                                $ambiance, $phonePro, $status, null, null);
                                    }
                                } elseif ((!checkModel($addressEstablishment) && isset($nameEstablishment))) {
                                    $status = Establishment::STATUS_INCOMPLETE;
                                    self::insertETS($nameEstablishment, $street, $street_2, $streetNumber, $postalCode, $region, $district, 
                                            $city, $country, $lat, $lng, $email, $siteWeb, $description, $cookingType, $speciality, $service, 
                                            $ambiance, $phonePro, $status, null, null);
                                } elseif (checkModel($addressEstablishment)) {
                                    $establishment = Establishment::where('id_address', '=', $addressEstablishment->getId())->first();
                                    if (checkModel($establishment)) {
                                        self::insertETS($nameEstablishment, $street, $street_2, $streetNumber, $postalCode, $region, $district, 
                                                $city, $country, $lat, $lng, $email, $siteWeb, $description, $cookingType, $speciality, $service, 
                                                $ambiance, $phonePro, $status, $establishment, $addressEstablishment);
                                        print_r('La ligne ' . $nameEstablishment . ' à été mise à jour<br>');
                                    }
                                }
                            }
                        }
                    }
                });
                Storage::delete($relPath);
            }
        }
    }

    public function getLatLng($street, $streetNumber, $postalCode, $country, $city) {
        $url = 'http://maps.google.com/maps/api/geocode/json?sensor=false&address='
                . urlencode($street . ' ' . $streetNumber . ' ' . $country . ' ' . $postalCode . ' ' . $city);
        $json = file_get_contents($url);
        $data = json_decode($json, true);
        //print_r($json);
        return $data;
    }

    /**
     * 
     * @param type $nameEstablishment
     * @param type $street
     * @param type $street_2
     * @param type $streetNumber
     * @param type $postalCode
     * @param type $region
     * @param type $district
     * @param type $city
     * @param type $country
     * @param type $lat
     * @param type $lng
     * @param type $email
     * @param type $siteWeb
     * @param type $description
     * @param type $cookingType
     * @param type $speciality
     * @param type $service
     * @param type $ambiance
     * @param type $phone
     * @param type $status
     * @param Establishment $establishment
     * @param Address $address
     */
    function insertETS($nameEstablishment, $street, $street_2, $streetNumber, $postalCode, $region, $district, $city, $country, $lat, $lng, 
            $email, $siteWeb, $description, $cookingType, $speciality, $service, $ambiance, $phone, $status, $establishment, $address) {
        $idEstablishment = UuidTools::generateUuid();
        $idAddress = UuidTools::generateUuid();
        $idLocationIndex = 0;

        $countryId = null;
        switch ($country) {
            case 'Switzerland': $countryId = \App\Models\Country::CHE;
                $prefix = '+41';
                break;
            case 'France': $countryId = \App\Models\Country::FRA;
                $prefix = '+33';
                break;
        }

        if ($status == Establishment::STATUS_ACTIVE) {
            $idLocationIndex = $this->getIdLocationIndex($postalCode, $city, $lat, $lng, $country);
        }

        if (!checkModel($address)) {
            Address::create([
                'id' => $idAddress,
                'street_number' => $streetNumber,
                'street' => $street,
                'address_additional' => $street_2,
                'region' => $region,
                'district' => $district,
                'postal_code' => $postalCode,
                'city_slug' => str_slug($city),
                'city' => $city,
                'latitude' => $lat,
                'longitude' => $lng,
                'id_location_index' => $idLocationIndex,
                'id_country' => $countryId
            ]);
            $addressEstablishment = Address::where('street_number', '=', $streetNumber)->where('street', '=', $street)
                            ->where('postal_code', '=', $postalCode)->where('city', '=', $city)->first();

            $ets = Establishment::create([
                        'id' => $idEstablishment,
                        'name' => $nameEstablishment,
                        'email' => $email,
                        'id_address' => $addressEstablishment->id,
                        'latitude' => $lat,
                        'longitude' => $lng,
                        'DS_ranking' => 0,
                        'id_logo' => 0,
                        'site_url' => $siteWeb,
                        'description' => $description,
                        'id_user_owner' => 0,
                        'id_business_type' => Establishment::TYPE_BUSINESS_RESTAURANT,
                        'url_id' => Establishment::generateStaticUrlId(UuidTools::getUuid($idEstablishment)),
                        'status' => $status,
                        'slug' => str_slug($nameEstablishment),
            ]);
            
             //Cooking type
        //Food speciality
        foreach ($cookingType as $business){
            self::linkBusinessCategory($ets->getId(), $business, BusinessCategory::TYPE_COOKING_TYPE);
        }
        //Food speciality
        foreach ($speciality as $business){
            self::linkBusinessCategory($ets->getId(), $business, BusinessCategory::TYPE_FOOD_SPECIALTY);
        }
        //Ambiances
        foreach ($ambiance as $business){
            self::linkBusinessCategory($ets->getId(), $business, BusinessCategory::TYPE_RESTAURANT_AMBIENCE);
        }
        //Service
        foreach ($service as $business){
            self::linkBusinessCategory($ets->getId(), $business, BusinessCategory::TYPE_SERVICES);
        }
        
        //Insertion numéro principal PRO
                $callNumber = \App\Models\CallNumber::where('number','=',$phone)->where('id_establishment','=',$ets->getId())->first(); 
            if(!checkModel($callNumber)){
                            \App\Models\CallNumber::create([
                            'id' => UuidTools::generateUuid(),
                            'label' => 'PRO',
                            'type' => \App\Models\CallNumber::TYPE_PHONE_PRO,
                            'main' => 1,
                            'id_country' => $countryId,
                            'prefix' => $prefix,
                            'number' => $phone,
                            'id_establishment' => $ets->getId()
                ]);
            }else{
                $callNumber->update([
                            'label' => 'PRO',
                            'type' => \App\Models\CallNumber::TYPE_PHONE_PRO,
                            'main' => 1,
                            'id_country' => $countryId,
                            'prefix' => $prefix,
                            'number' => $phone,
                            'id_establishment' => $ets->getId()
                ]);
            }  
        } else {
            // Update establishment
            $ets = $establishment;
            $ets->update([
                'name' => $nameEstablishment,
                'email' => $email,
                'DS_ranking' => 0,
                'id_logo' => 0,
                'site_url' => $siteWeb,
                'description' => $description,
                'id_user_owner' => 0,
                'id_business_type' => Establishment::TYPE_BUSINESS_RESTAURANT,
                'url_id' => Establishment::generateStaticUrlId(UuidTools::getUuid($ets->getId())),
                'slug' => str_slug($nameEstablishment),
            ]);
        }
    }

    function getIdLocationIndex($postalCode, $city, $lat, $lng, $countryName) {
        $idLocationIndex = 0;
        $locationIndex = LocationIndex::where('city', '=', $city)->where('postal_code', '=', $postalCode)->first();
        if (checkModel($locationIndex)) {
            $idLocationIndex = $locationIndex->getId();
        } else {
            $countryId = 0;
            switch ($countryName) {
                case 'Switzerland': $countryId = Country::CHE;
                    break;
                case 'France': $countryId = Country::FRA;
                    break;
            }
            $locationIndex = LocationIndex::create([
                        'id' => UuidTools::generateUuid(),
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

    function linkBusinessCategory($idEstablishment, $name, $type) {
        $businessModel = \App\Models\BusinessCategory::where('name', '=', $name)
                        ->where('type', '=', $type)->first();
        if (checkModel($businessModel)) {
            self::feedEstablishmentBusinessCategory($businessModel->getId(), $idEstablishment);
        } else {
            $specialityModel = \App\Models\BusinessCategory::create([
                        'id' => UuidTools::generateUuid(),
                        'name' => $name,
                        'type' => BusinessCategory::STATUS_TO_CHECK,
            ]);
            self::feedEstablishmentBusinessCategory($specialityModel->getId(), $idEstablishment);
        }
    }

    public function feedEstablishmentBusinessCategory($idBusinessCategory, $idEstablishment) {
        $businessCategory = DB::table(\App\Models\EstablishmentBusinessCategory::TABLENAME)->where('id_establishment', '=', $idEstablishment)
                        ->where('id_business_category', '=', $idBusinessCategory)->first();
        if (!checkModel($businessCategory)) {
            print_r('');
            \App\Models\EstablishmentBusinessCategory::create([
                'id' => UuidTools::generateUuid(),
                'id_establishment' => $idEstablishment,
                'id_business_category' => $idBusinessCategory
            ]);
        }
    }

}
