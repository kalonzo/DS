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
                    $stop = false;
                    if (!empty($sheets)) {
                        $nbError = 0;
                        $nbSucces = 0;
                        $nbRest = 0;
                        $nbMaj = 0;
                        $i = 0;
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
                            $description = null;
                            $service = null;
                            $ambiance = null;
                            $status = null;
                            $lat = null;
                            $lng = null;
                            $openingHours[] = array();
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
                                        } elseif ($col_slug === 'district') {
                                            $district = $cellContent;
                                        } elseif ($col_slug === 'localite') {
                                            $city = $cellContent;
                                        } elseif ($col_slug === 'canton_departements') {
                                            $region = $cellContent;
                                        } elseif ($col_slug === 'pays') {
                                            $country = $cellContent;
                                        } elseif ($col_slug === 'telephone') {
                                            $phonePro = $cellContent;
                                        } elseif ($col_slug === 'email') {
                                            $email = $cellContent;
                                        } elseif ($col_slug === 'site_web') {
                                            $siteWeb = $cellContent;
                                        } elseif ($col_slug === 'type_de_cuisine') {
                                            $cookingType = explode('-', $cellContent);
                                        } elseif ($col_slug === 'specialites') {
                                            $speciality = explode('-', $cellContent);
                                        } elseif ($col_slug === 'description_detaillee') {
                                            $description = $cellContent;
                                        } elseif ($col_slug === 'services') {
                                            $service = explode('-', $cellContent);
                                        } elseif ($col_slug === 'cadre_ambiance') {
                                            $ambiance = explode('-', $cellContent);
                                            //jour de la semaine
                                        } elseif ($col_slug === 'lundi1') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'lundi2') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'lund13') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'lund14') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'mardi1') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'mardi2') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'mardi3') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'mardi4') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'mercredi1') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'mercredi2') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'mercredi3') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'mercredi4') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'jeudi1') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'jeudi2') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'jeudi3') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'jeudi3') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'jeudi4') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'vendredi1') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'vendredi2') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'vendredi3') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'vendredi4') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'samedi1') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'samedi2') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'samedi3') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'samedi4') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'dimanche1') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'dimanche2') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'dimanche3') {
                                            $openingHours[] = $cellContent;
                                        } elseif ($col_slug === 'dimanche4') {
                                            $openingHours[] = $cellContent;
                                        }
                                    }
                                }

                                $addressEstablishment = Address::where('street_number', '=', $streetNumber)->where('street', '=', $street)
                                                ->where('postal_code', '=', $postalCode)->where('city', '=', $city)->first();
                                $establishmentName = Establishment::where('name', '=', $nameEstablishment)->first();

                                //On vérifie que la requête soit suffisamment compléte pour la geolocalisation
                                if ((!checkModel($establishmentName) && !checkModel($addressEstablishment) && !empty($nameEstablishment) && !empty($street) && !empty($streetNumber) && !empty($postalCode) && !empty($city))) {
                                    $i = $i + 1;
                                    $data = self::getLatLng($nameEstablishment, $street, $streetNumber, $postalCode, $country, $city);
                                    if (isset($data['results'][0]['geometry']['location']['lat'])) {
                                        $lat = $data['results'][0]['geometry']['location']['lat'];
                                        $lng = $data['results'][0]['geometry']['location']['lng'];
                                        //$streetNumber = $data['results'][0]['address_components']['street_number']['short_name'];
                                        //$street = $data['results'][0]['address_components']['route']['short_name'];
                                        // $city = $data['results'][0]['address_components']['locality']['short_name'];
                                        //$department = $data['results'][0]['address_components']['administrative_area_level_1']['short_name'];
                                        // $country = $data['results'][0]['address_components']['country']['long_name'];
                                        //$postalCode = $data['results'][0]['address_components'][6]['long_name'];
                                        //print_r('$department->' . $department . ' $country->' . $country . ' city->' . $postalCode);

                                        $addressEstablishment = Address::where('street_number', '=', $streetNumber)->where('street', '=', $street)
                                                        ->where('postal_code', '=', $postalCode)->where('city', '=', $city)->first();
                                        if (!checkModel($addressEstablishment)) {
                                            $status = Establishment::STATUS_ACTIVE;
                                            self::insertETS($nameEstablishment, $street, $street_2, $streetNumber, $postalCode, $region, $district, $city, $country, $lat, $lng, $email, $siteWeb, $description, $cookingType, $speciality, $service, $ambiance, $phonePro, $openingHours, $status, null, null);
                                            $nbSucces = $nbSucces + 1;
                                            $stop = false;
                                            // print_r('La ligne ' . $nameEstablishment . ' est insérer<br>');
                                        }
                                    } else {
                                        // echo ('<h1>Busy API</h1><br>');
                                        //echo('La ligne ' . $nameEstablishment . ' n\'as pas été enregistré en base <br>');
                                        $nbRest = $nbRest + 1;
                                        $stop = true;
                                        /**
                                         * print_r('La ligne ' . $nameEstablishment . ' doit être localiser<br>');
                                          $status = Establishment::STATUS_TO_LOCALIZE;
                                          self::insertETS($nameEstablishment, $street, $street_2, $streetNumber, $postalCode, $region, $district, $city,
                                          $country, $lat, $lng, $email, $siteWeb, $description, $cookingType, $speciality, $service, $ambiance,
                                          $phonePro,$openingHours, $status, null, null);
                                         * 
                                         */
                                    }
                                } elseif ((!checkModel($addressEstablishment) && isset($nameEstablishment))) {
                                    $i = $i + 1;
                                    $nbError = $nbError + 1;
                                    /**
                                      $status = Establishment::STATUS_INCOMPLETE;
                                      self::insertETS($nameEstablishment, $street, $street_2, $streetNumber, $postalCode, $region, $district, $city,
                                      $country, $lat, $lng, $email, $siteWeb, $description, $cookingType, $speciality, $service, $ambiance,
                                      $phonePro,$openingHours, $status, null, null);
                                     * 
                                     */
                                } elseif (checkModel($addressEstablishment)) {
                                    $i = $i + 1;
                                    //$nbMaj = $nbMaj + 1 ;
                                    /**
                                      $establishment = Establishment::where('id_address', '=', $addressEstablishment->getId())->first();
                                      if (checkModel($establishment)) {
                                      self::insertETS($nameEstablishment, $street, $street_2, $streetNumber, $postalCode, $region, $district, $city,
                                      $country, $lat, $lng, $email, $siteWeb, $description, $cookingType, $speciality, $service, $ambiance,
                                      $phonePro,$openingHours, $status, $establishment, $addressEstablishment);
                                      // print_r('La ligne ' . $nameEstablishment . ' à été mise à jour<br>');
                                      }
                                     * 
                                     */
                                } elseif (isset($nameEstablishment) && $stop === true) {
                                    $i = $i + 1;
                                    $nbRest = $nbRest + 1;
                                    // print_r('La ligne ' . $nameEstablishment . ' n\'as pas pu être traité <br>');
                                }
                            }
                        }

                        echo '<h2> Résultat pour cette Import</h2>';

                        print_r('Nombre de ligne insérer Actif ' . $nbSucces . '<br>');
                        print_r('Nombre de ligne à compléter ' . $nbRest . '<br>');
                        print_r('Nombre de ligne incompléte ' . $nbError . '<br>');
                        print_r('Nombre de ligne traité ' . $i . '<br>');
                        ?> 
                        <a type="button" name="nom" value="Retour à la séléction Excel"  href="https://dinerscope/admin/establishment/import" >
                            retour
                        </a>
                        <input type="button" value="Rafraichir" id="refresh" onclick="{
                                    location.reload()
                                }" />
                        <?php
                    }
                });
                Storage::delete($relPath);
            }
        }
    }

    public function getLatLng($street, $streetNumber, $postalCode, $country, $city) {
        $url = 'http://maps.google.com/maps/api/geocode/json?sensor=false&address='
                . urlencode($street . ' ' . $streetNumber . ' ' . $country . ' ' . $postalCode . ' ' . $city);
        try {
            $json = file_get_contents($url);
            $data = json_decode($json, true);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        //print_r($json);
        return $data;
    }

    /**
     * 
     * @param StoreEstablishment $request
     * @param type $day
     * @param type $startTime
     * @param type $endTime
     * @param Establishment $establishment
     */
    public function insertOpeningHours($openingHours, $establishmentId) {
        try {

            //insére succesivement les horaires en base
            $i=0;
            foreach ($openingHours as $hour) {
                print_r($hour);
                echo $hour[$i].'<br>';
                $i = $i +1;
            }
            die();
            //insertion des horaires
            $ets = \App\Models\OpeningHour::create([
                        'id' => UuidTools::generateUuid(),
                        'day' => $nameEstablishment,
                        'start_time' => $email,
                        'end_time' => $addressEstablishment->id,
                        'start_date' => $lat,
                        'end_date' => $lng,
                        'id_establishment' => $establishmentId,
                        'no_break' => 0,
                        'closed' => $siteWeb,
                        'day_order' => $description,
            ]);
        } catch (Exception $e) {
            print_r($e->getMessage());
            die();
        }
        return $openingHours;
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
    function insertETS($nameEstablishment, $street, $street_2, $streetNumber, $postalCode, $region, $district, $city, $country, $lat, $lng, $email, $siteWeb, $description, $cookingType, $speciality, $service, $ambiance, $phone, $openingsHours, $status, $establishment, $address) {
        $idEstablishment = UuidTools::generateUuid();
        $idAddress = UuidTools::generateUuid();
        $idLocationIndex = 0;

        $countryId = null;
        switch ($country) {
            case 'Switzerland': $countryId = \App\Models\Country::CHE;
                $prefix = '+41';
                $idCurrency = \App\Models\Currency::CHF;
                break;
            case 'France': $countryId = \App\Models\Country::FRA;
                $prefix = '+33';
                $idCurrency = \App\Models\Currency::EUR;
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
                        'id_currency' => $idCurrency,
            ]);

            self::insertOpeningHours($openingsHours,$ets->getId());
            
                    //Insertion numéro principal PRO
                    $callNumber = \App\Models\CallNumber::where('number', '=', $phone)->where('id_establishment', '=', $ets->getId())->first();
            if (!checkModel($callNumber)) {
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
            } else {
                $callNumber->update([
                    'label' => 'PRO',
                    'type' => \App\Models\CallNumber::TYPE_PHONE_PRO,
                    'main' => 1,
                    'id_country' => $countryId,
                    'prefix' => $prefix,
                    'number' => $phone,
                    'id_establishment' => $ets->getId()
                ]);
                $callNumber->save();
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
            $ets->save();
        }

        if (isset($cookingType)) {
            foreach ($cookingType as $business) {
                self::linkBusinessCategory($ets->getId(), $business, BusinessCategory::TYPE_COOKING_TYPE);
            }
        }
        if (isset($speciality)) {
            foreach ($speciality as $business) {
                self::linkBusinessCategory($ets->getId(), $business, BusinessCategory::TYPE_FOOD_SPECIALTY);
            }
        }
        if (isset($ambiance)) {
            foreach ($ambiance as $business) {
                self::linkBusinessCategory($ets->getId(), $business, BusinessCategory::TYPE_RESTAURANT_AMBIENCE);
            }
        }
        if (isset($service)) {
            foreach ($service as $business) {
                self::linkBusinessCategory($ets->getId(), $business, BusinessCategory::TYPE_SERVICES);
            }
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
        $businessModel = \App\Models\BusinessCategory::where('name', '=', $name)->where('type', '=', $type)->first();
        if (checkModel($businessModel)) {
            self::feedEstablishmentBusinessCategory($businessModel->getId(), $idEstablishment);
        } else {
            $specialityModel = \App\Models\BusinessCategory::create([
                        'id' => UuidTools::generateUuid(),
                        'name' => $name,
                        'type' => $type,
                        'status' => BusinessCategory::STATUS_TO_CHECK
            ]);
            self::feedEstablishmentBusinessCategory($specialityModel->getId(), $idEstablishment);
        }
    }

    public function feedEstablishmentBusinessCategory($idBusinessCategory, $idEstablishment) {
        $businessCategory = \App\Models\EstablishmentBusinessCategory::where('id_establishment', '=', $idEstablishment)
                        ->where('id_business_category', '=', $idBusinessCategory)->first();
        if (!checkModel($businessCategory)) {
            \App\Models\EstablishmentBusinessCategory::create([
                'id' => UuidTools::generateUuid(),
                'id_establishment' => $idEstablishment,
                'id_business_category' => $idBusinessCategory
            ]);
        }
    }

}
