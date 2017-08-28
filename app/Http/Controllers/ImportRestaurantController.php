<?php

namespace App\Http\Controllers;

use App\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use View;
use App\Models\Address;
use App\Models\Country;
use App\Models\LocationIndex;
//use ;
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
                            $phone = null;
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

                            foreach ($sheet as $numRow => $row) {
                                if ($numRow > 0) { //&& $numRow < 10
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
                                    $phone = null;
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
                                            $phone = $cellContent;
                                        } elseif ($col_slug === 'telephone_professionnel') {
                                            $phonePro = $cellContent;
                                        } elseif ($col_slug === 'email') {
                                            $email = $cellContent;
                                        } elseif ($col_slug === 'site_web') {
                                            $siteWeb = $cellContent;
                                        } elseif ($col_slug === 'type_de_cuisine') {
                                            $cookingType = $cellContent;
                                        } elseif ($col_slug === 'specialites') {
                                            $speciality = $cellContent;
                                        } elseif ($col_slug === 'description_detaillee') {
                                            $description = $cellContent;
                                        } elseif ($col_slug === 'services') {
                                            $service = $cellContent;
                                        } elseif ($col_slug === 'cadre_ambiance') {
                                            $ambiance = $cellContent;
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
                                if ((!checkModel($addressEstablishment) && isset($nameEstablishment) && isset($street) && isset($streetNumber) && isset($postalCode) && isset($city))) {//&& isset($country)
                                    $data = self::getLatLng($nameEstablishment, $street, $streetNumber, $postalCode, $country, $city);
                                    if (isset($data['results'][0]['geometry']['location']['lat'])) {
                                        $lat = $data['results'][0]['geometry']['location']['lat'];
                                        $lng = $data['results'][0]['geometry']['location']['lng'];
                                        //$streetNumber = $data['results'][0]['address_components'][0]['short_name'];
                                        //$street = $data['results'][0]['address_components'][1]['short_name'];
                                        //$city = $data['results'][0]['address_components'][2]['short_name'];
                                        //$department = $data['results'][0]['address_components'][3]['short_name'];
                                        // $country = $data['results'][0]['address_components'][5]['long_name'];
                                        // $postalCode = $data['results'][0]['address_components'][6]['long_name'];
                                        //die($data['results'][0]['address_components'][6]['short_name']);
                                        $status = Establishment::STATUS_ACTIVE;
                                        //TODO insertion de la ligne dans la base 
                                        self::insertETS($nameEstablishment, $street, $street_2, $streetNumber, $postalCode, $region, $district, $city, $country, $lat, $lng, $email, $siteWeb, $description, $cookingType, $speciality, $ambiance, $status);
                                    } else {
                                        $status = Establishment::STATUS_INCOMPLETE;
                                        self::insertETS($nameEstablishment, $street, $street_2, $streetNumber, $postalCode, $region, $district, $city, $country, $lat, $lng, $email, $siteWeb, $description, $cookingType, $speciality, $ambiance, $status);
                                    }
                                } elseif ((!checkModel($addressEstablishment) && isset($nameEstablishment))) {
                                    $status = Establishment::STATUS_INCOMPLETE;
                                    self::insertETS($nameEstablishment, $street, $street_2, $streetNumber, $postalCode, $region, $district, $city, $country, $lat, $lng, $email, $siteWeb, $description, $cookingType, $speciality, $ambiance, $status);
                                    //self::insertETS($nameEstablishment, $street, $street_2, $streetNumber, $postalCode, $region, $district, $city, $country, $lat, $lng, $email, $siteWeb, $description, $cookingType, $speciality, $ambiance, $status);
                                } elseif (checkModel($addressEstablishment)) {
                                    print_r('la ligne existe déja ' . $nameEstablishment);
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
                . urlencode($street . ' ' . $streetNumber .
                        ' ' . $country . ' ' . $postalCode . ' ' . $city);
        $json = file_get_contents($url);
        $data = json_decode($json, true);
        //print_r($json);
        /**
          foreach ($data['results'] as $result => $value) {
          print_r($result);
          foreach ($value as $key => $geo) {
          print_r($key);
          echo '<br>';
          print_r($geo);
          echo '<br>';
          }
          }
         * 
         */
        return $data;
    }

    function insertETS($nameEstablishment, $street, $street_2, $streetNumber, $postalCode, $region, $district, $city, $country, $lat, $lng, $email, $siteWeb, $description, $cookingType, $speciality, $ambiance, $status) {
        $idEstablishment = UuidTools::generateUuid();
        $idAddress = UuidTools::generateUuid();
        $countryId = 0;
        $idLocationIndex = 0;

        if ($status == 1) {
            $idLocationIndex = $this->getIdLocationIndex($postalCode, $city, $lat, $lng, $country);
            $countryId = Country::where('label', $country)->first()->getId();
        }

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
                        ->where('street_number', '=', $streetNumber)->where('postal_code', '=', $postalCode)->where('city', '=', $city)->first();

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
        $idBusinessCategory = self::getBusinessCategoryId($cookingType, BusinessCategory::TYPE_COOKING_TYPE);
        //print_r($idBusinessCategory . '-' . $idEstablishment);
        
        \App\Models\EstablishmentBusinessCategory::create([
            'id' => UuidTools::generateUuid(),
            'id_establishment' => $ets->getId(),
            'id_business_category' => $idBusinessCategory
        ]);
    }

    function updateETS($nameEstablishment, $street, $street_2, $streetNumber, $postalCode, $region, $district, $city, $country, $lat, $lng, $email, $siteWeb, $description, $cookingType, $speciality, $ambiance, $status, $establishment) {
        $countryId = 0;
        $idLocationIndex = 0;

        if ($status == 1) {
            $idLocationIndex = $this->getIdLocationIndex($postalCode, $city, $lat, $lng, $country);
            $countryId = Country::where('label', $country)->first()->getId();
        }

        if (!empty($postalCode) && !empty($city) && checkModel($countryId)) {
            $locationIndex = LocationIndex::where('city', '=', $city)->where('postal_code', '=', $postalCode)->first();
            if (checkModel($locationIndex)) {
                $idLocation = $locationIndex->getId();
            } else {
                $locationIndex = LocationIndex::create([
                            'id' => \App\Utilities\UuidTools::generateUuid(),
                            'postal_code' => $postalCode,
                            'city' => $city,
                            'latitude' => $lat,
                            'longitude' => $lng,
                            'id_country' => $countryId
                ]);
                if (checkModel($locationIndex)) {
                    $idLocation = $locationIndex->getId();
                }
            }
        }
        if (checkModelId($idLocation)) {
            $address = Address::find(UuidTools::getUuid($establishment->getIdAddress()));
            if (checkModel($address)) {
                // Update establishment address
                $address->update([
                    'street' => $street,
                    'street_number' => $streetNumber,
                    'address_additional' => $street_2,
                    'region' => $region,
                    'district' => $district,
                    'postal_code' => $postalCode,
                    'po_box' => $poBox,
                    'city' => $city,
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'id_country' => $countryId,
                    'country' => $country,
                    'id_location_index' => $idLocation,
                ]);

                // Update establishment
                $establishment->update([
                    'name' => $nameEstablishment,
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'email' => $email,
                    'site_url' => $siteWeb,
                    'description' => $description,
                    'id_location_index' => $idLocation,
                ]);
            }
        }
    }

    function getIdLocationIndex($postalCode, $city, $lat, $lng, $countryName) {
        $idLocationIndex = 0;
        $locationIndex = LocationIndex::where('city', '=', $city)->where('postal_code', '=', $postalCode)->first();
        if (checkModel($locationIndex)) {
            $idLocationIndex = $locationIndex->getId();
        } else {
            $countryId = null;
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

    function getBusinessCategoryId($name, $type) {
        $idBusinessCategory = 0;
        $business_category = \App\Models\BusinessCategory::where('name', $name)
                        ->where('type', $type)->first();
        if (checkModel($business_category)) {
            $idBusinessCategory = $business_category->id;
        }
        return $idBusinessCategory;
    }

}
