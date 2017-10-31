<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\BusinessCategory;
use App\Models\Establishment;
use App\Models\EstablishmentBusinessCategory;
use App\Models\Promotion;
use App\Models\Restaurant;
use App\Models\Utilities\LatLng;
use App\Utilities\DbQueryTools;
use App\Utilities\GeolocTools;
use App\Utilities\StorageHelper;
use App\Utilities\StringTools;
use App\Utilities\UuidTools;
use Eloquent;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use View;

/**
 * Description of SearchController
 *
 * @author Nico
 */
class SearchController {

    const NB_QUICK_RESULTS_PER_TYPE = 5;
    const DEFAULT_DISTANCE_KM_SEARCH = 5;
    const DEFAULT_PRICE_CHF_SEARCH = 60;
    const DEFAULT_DISPLAY_BY = 24;
    const QUICK_SEARCH_SECTION_DISTANCE = 1;
    const QUICK_SEARCH_SECTION_NAME = 2;
    const QUICK_SEARCH_SECTION_COOKING_TYPE = 3;
    const SEARCH_ORDER_BY_PROXIMITY = 1;
    const SEARCH_ORDER_BY_NAME = 2;
    const SEARCH_ORDER_BY_COOKING_TYPE = 3;

    public static $nbElementsPerPageChoices = array(24, 48, 96);

    public static function quickSearch($terms) {
        $results = array();
        $userLat = SessionController::getInstance()->getUserLat();
        $userLng = SessionController::getInstance()->getUserLng();
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        $userLatLng = new LatLng($userLat, $userLng);
        if (!$userLatLng->isValid()) {
            $userLatLng = GeolocationController::getRawInitialGeolocation();
        }

        if (!empty($terms) && $userLatLng->isValid()) {
            $businessCategoryType1 = null;
            switch ($typeEts) {
                case \App\Models\BusinessType::TYPE_BUSINESS_RESTAURANT:
                    $businessCategoryType1 = BusinessCategory::TYPE_COOKING_TYPE;
                    break;
            }
            
            $rawDistanceEstablishments = array();
            $namedEstablishments = array();
            $attempt = 1;
            $nbResults = 0;
            $searchDistance = self::DEFAULT_DISTANCE_KM_SEARCH;
            do{
                switch($attempt){
                    case 1:
                        $searchDistance = self::DEFAULT_DISTANCE_KM_SEARCH;
                        break;
                    case 2:
                        $searchDistance = 20;
                        break;
                    case 3:
                        $searchDistance = 50;
                        break;
                }
                
                $rawDistanceEstablishmentsQuery = Establishment::select([
                            Establishment::TABLENAME.'.*'
                            , DB::raw(DbQueryTools::genRawSqlForDistanceCalculation($userLatLng, Establishment::TABLENAME))
                        ])
                        ->where('name', 'LIKE', "%$terms%")
                        ->where('id_business_type', '=', $typeEts)
                        ->where(Establishment::TABLENAME . '.status', '=', Establishment::STATUS_ACTIVE)
                        ->where(Establishment::TABLENAME . '.business_status', '>=', 50)
                ;
                $geolocLimitSuccess = DbQueryTools::setGeolocLimits($rawDistanceEstablishmentsQuery, $userLatLng, $searchDistance, Establishment::TABLENAME);
                $nbResults = $rawDistanceEstablishmentsQuery->count();
                if ($attempt === 3 || ($geolocLimitSuccess && $nbResults >= (self::NB_QUICK_RESULTS_PER_TYPE / 2))) {
                    $namedEstablishments = with(clone $rawDistanceEstablishmentsQuery)->orderBy('name')->limit(self::NB_QUICK_RESULTS_PER_TYPE)->get();
                    $rawDistanceEstablishments = $rawDistanceEstablishmentsQuery->orderBy('rawDistance')->limit(self::NB_QUICK_RESULTS_PER_TYPE)->get();
                }
                $attempt++;
            } while($nbResults < (self::NB_QUICK_RESULTS_PER_TYPE / 2) && $attempt < 4);

            if(!empty($rawDistanceEstablishments)){
                // TOP RESULTS
                $counter = 0;
                foreach ($rawDistanceEstablishments as $rawDistanceEstablishment) {
                    if($counter < 3){
                        $distance = $rawDistanceEstablishment->rawDistance;
                        $distanceDisplay = str_replace(' ', '<br/>', StringTools::displayCleanDistance($distance));
                        $results [] = array(
                            'id' => $rawDistanceEstablishment->getUuid(),
                            'label' => $rawDistanceEstablishment->getName(),
                            'value' => $rawDistanceEstablishment->getName(),
                            'picture' => $rawDistanceEstablishment->getDefaultPicture(),
                            'avatar_bg_color' => 'none',
                            'section' => 'Top Résultats',
                            'url' => $rawDistanceEstablishment->getUrl()
                        );
                        $counter++;
                    }
                }
                foreach ($rawDistanceEstablishments as $rawDistanceEstablishment) {
                    $distance = $rawDistanceEstablishment->rawDistance;
                    $distanceDisplay = str_replace(' ', '<br/>', StringTools::displayCleanDistance($distance));
                    $results [] = array(
                        'id' => $rawDistanceEstablishment->getUuid(),
                        'label' => $rawDistanceEstablishment->getName(),
                        'value' => $rawDistanceEstablishment->getName(),
                        'avatar_bg_color' => \App\Utilities\StyleTools::genColorHexaForVisualGradient('0090ff', '00b33b', 
                                                                            ($distance/($searchDistance*1000))),
                        'avatar_text' => $distanceDisplay,
                        'section' => 'Localité',
                        'order_by' => self::SEARCH_ORDER_BY_PROXIMITY,
                        'distance' => $searchDistance,
                        'lat' => $rawDistanceEstablishment->getLatitude(),
                        'lng' => $rawDistanceEstablishment->getLongitude(),
                        'url' => $rawDistanceEstablishment->getUrl()
                    );
                }
            }
            
            if(!empty($namedEstablishments)){
                foreach ($namedEstablishments as $namedEstablishment) {
                    $results [] = array(
                        'id' => $namedEstablishment->getUuid(),
                        'label' => $namedEstablishment->getName(),
                        'value' => $namedEstablishment->getName(),
                        'picture' => $namedEstablishment->getDefaultPicture(),
                        'avatar_bg_color' => 'none',
                        'section' => 'Nom',
                        'order_by' => self::SEARCH_ORDER_BY_NAME,
                        'distance' => $searchDistance,
                        'lat' => $namedEstablishment->getLatitude(),
                        'lng' => $namedEstablishment->getLongitude(),
                        'url' => $namedEstablishment->getUrl()
                    );
                }
            }
            
            $businessCategoriesResults = array();
            $attempt = 1;
            $nbResults = 0;
            $searchDistance = self::DEFAULT_DISTANCE_KM_SEARCH;
            do{
                switch($attempt){
                    case 1:
                        $searchDistance = self::DEFAULT_DISTANCE_KM_SEARCH;
                        break;
                    case 2:
                        $searchDistance = 20;
                        break;
                    case 3:
                        $searchDistance = 50;
                        break;
                }
                // Search by business category (cooking type, ...)
                $businessCategoriesQuery = BusinessCategory::select([
                                DB::raw('count(' . EstablishmentBusinessCategory::TABLENAME . '.id_establishment' . ') as nb_establishment')
                                , BusinessCategory::TABLENAME . '.id as id_business_category'
                                , BusinessCategory::TABLENAME . '.name'
                        ])
                        ->join(EstablishmentBusinessCategory::TABLENAME, EstablishmentBusinessCategory::TABLENAME . '.id_business_category', '=', BusinessCategory::TABLENAME . '.id')
                        ->join(Establishment::TABLENAME, EstablishmentBusinessCategory::TABLENAME . '.id_establishment', '=', Establishment::TABLENAME . '.id')
                        ->where(BusinessCategory::TABLENAME . '.name', 'LIKE', "%$terms%")
                        ->where(BusinessCategory::TABLENAME . '.type', '=', $businessCategoryType1)
                        ->where(Establishment::TABLENAME . '.id_business_type', '=', $typeEts)
                        ->where(Establishment::TABLENAME . '.status', '=', Establishment::STATUS_ACTIVE)
                        ->where(Establishment::TABLENAME . '.business_status', '>=', 50)
                        ->groupBy(BusinessCategory::TABLENAME . '.id')
                        ->orderBy(BusinessCategory::TABLENAME . '.name')
                        ->limit(self::NB_QUICK_RESULTS_PER_TYPE)
                        ;
                
                $geolocLimitSuccess = DbQueryTools::setGeolocLimits($businessCategoriesQuery, $userLatLng, $searchDistance, Establishment::TABLENAME);
                $nbResults = $businessCategoriesQuery->count();
                if ($attempt === 3 || ($geolocLimitSuccess && $nbResults >= (self::NB_QUICK_RESULTS_PER_TYPE / 2))) {
                    $businessCategoriesResults = $businessCategoriesQuery->get();
                }
                $attempt++;
            } while($nbResults < (self::NB_QUICK_RESULTS_PER_TYPE / 2) && $attempt < 4);
            
            if(!empty($businessCategoriesResults)){
                foreach ($businessCategoriesResults as $result) {
                    $uuid = UuidTools::getUuid($result->id_business_category);
                    $results [] = array(
                        'id' => $uuid,
                        'label' => $result->name,
                        'value' => $result->name,
                        'avatar_bg_color' => \App\Utilities\StyleTools::genRandomColorHexa(),
                        'avatar_text' => strtoupper($result->name[0]),
                        'text_right' => '(' . $result->nb_establishment . ')',
                        'section' => 'Type de cuisine',
                        'url' => "/search?reset=1&biz_category_1[]=".$uuid."&distance=".$searchDistance
                    );
                }
            }
        }

        return $results;
    }

    public function search(\Illuminate\Http\Request $request) {
        $view = null;
        $reset = $request->get('reset');
        if($reset){
            SessionController::getInstance()->resetSearchFilterValues();
            self::getFilterValues('distance', 50);
        }
        self::buildFilterLabels();
        $establishmentsQuery = self::buildSearchQuery();

        if (!empty($establishmentsQuery)) {
            $resultsPagination = self::buildSearchResults($establishmentsQuery);
            $filterValues = SessionController::getInstance()->getSearchFilterValues();
            $filterLabels = StorageHelper::getInstance()->get('search.filter_data');
            if (!empty($resultsPagination)) {
                $reload = $request->get('reload');
                $viewName = null;
                if ($reload) {
                    $viewName = 'components.search_results';
                } else {
                    $viewName = 'front.search';
                }
                $view = View::make($viewName)->with('establishments', $resultsPagination)->with('filter_values', $filterValues)
                        ->with('filter_labels', $filterLabels);
            }
        }
        return $view;
    }

    /**
     * 
     * @return Eloquent
     */
    public static function buildSearchQuery() {
        $establishmentsQuery = null;
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        $userLat = SessionController::getInstance()->getUserLat();
        $userLng = SessionController::getInstance()->getUserLng();
        $userLatLng = new LatLng($userLat, $userLng);
        if (!$userLatLng->isValid()) {
            $userLatLng = GeolocationController::getRawInitialGeolocation();
        }

//        $terms = Request::get('term');
        $terms = self::getFilterValues('term', Request::get('term'));
        $distance = self::getFilterValues('distance', self::DEFAULT_DISTANCE_KM_SEARCH);
        $price = self::getFilterValues('price');
        $orderBy = self::getFilterValues('order_by', self::SEARCH_ORDER_BY_PROXIMITY);
        $ids_location_index = self::getFilterValues('location_index');
        $ids_biz_category_1 = self::getFilterValues('biz_category_1');
        $ids_biz_category_2 = self::getFilterValues('biz_category_2');
        $ids_promos = self::getFilterValues('promo_type');

        if ($userLatLng->isValid()) {
            // Business categories matching **********************************/
            $businessCategoryType1 = null;
            $businessCategoryType2 = null;
            switch ($typeEts) {
                case \App\Models\BusinessType::TYPE_BUSINESS_RESTAURANT:
                    $businessCategoryType1 = BusinessCategory::TYPE_COOKING_TYPE;
                    $businessCategoryType2 = BusinessCategory::TYPE_RESTAURANT_AMBIENCE;
                    break;
            }

            $establishmentsQuery = DB::table(Establishment::TABLENAME)
                    ->select([Establishment::TABLENAME . '.*', Address::TABLENAME . '.*'
                            , DB::raw("biz_category1.id as id_biz_category_1"), DB::raw("biz_category1.name as name_biz_category_1")
                            , DB::raw(DbQueryTools::genRawSqlForDistanceCalculation($userLatLng, Establishment::TABLENAME))
                            , 'logo.local_path as logo_path', 'thumbnail.local_path as thumbnail_path'
                            ])
                    ->join(Address::TABLENAME, Address::TABLENAME . '.id', '=', Establishment::TABLENAME . '.id_address')
                    ->join(EstablishmentBusinessCategory::TABLENAME, Establishment::TABLENAME . '.id', '=', EstablishmentBusinessCategory::TABLENAME . '.id_establishment')
                    ->join(BusinessCategory::TABLENAME . ' AS biz_category1', 'biz_category1.id', '=', EstablishmentBusinessCategory::TABLENAME . '.id_business_category')
                    ->leftJoin(Promotion::TABLENAME, Establishment::TABLENAME . '.id', '=', Promotion::TABLENAME . '.id_establishment')
                    ->leftJoin(\App\Models\EstablishmentMedia::TABLENAME.' AS logo', function ($join) {
                        $join->on('logo.id', '=', Establishment::TABLENAME . '.id_logo')
                             ->where('logo.status', '=', \App\Models\EstablishmentMedia::STATUS_VALIDATED);
                    })
                    ->leftJoin(\App\Models\EstablishmentMedia::TABLENAME.' AS thumbnail', function ($join) {
                        $join->on('thumbnail.id', '=', Establishment::TABLENAME . '.id_thumbnail')
                             ->where('thumbnail.status', '=', \App\Models\EstablishmentMedia::STATUS_VALIDATED);
                    })
                    ->where(Establishment::TABLENAME . '.name', 'LIKE', "%$terms%")
                    ->where(Establishment::TABLENAME . '.id_business_type', '=', $typeEts)
                    ->where(Establishment::TABLENAME . '.status', '=', Establishment::STATUS_ACTIVE)
                    ->where(Establishment::TABLENAME . '.business_status', '>=', 50)
//                            ->having('rawDistance', '<=', ($distance*1000))
            ;
            $geolocLimitSuccess = DbQueryTools::setGeolocLimits($establishmentsQuery, $userLatLng, $distance, Establishment::TABLENAME);

            if($geolocLimitSuccess){
                // Link to main business category
                if (!empty($businessCategoryType1)) {
                    $establishmentsQuery->where('biz_category1.type', '=', $businessCategoryType1);
                }
                // Prebuild extra business categories filters
                $idsExtraBusinessCategories = array();
                if (!empty($businessCategoryType2)) {
                    $businessCategory2Query = DB::table(BusinessCategory::TABLENAME)
                            ->select('id', 'name')
                            ->where('type', '=', $businessCategoryType2);
                    if (!empty($ids_biz_category_2)) {
                        // Filter by extra business category
                        $businessCategory2Query->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id', $ids_biz_category_2));
                        $idsExtraBusinessCategories = array_merge($idsExtraBusinessCategories, $ids_biz_category_2);
                    }
                    $businessCategories2 = array();
                    $businessCategories2Data = $businessCategory2Query->get();
                    foreach ($businessCategories2Data as $businessCategory2Data) {
                        $uuidBusinessCategory2 = UuidTools::getUuid($businessCategory2Data->id);
                        if (!isset($businessCategories2[$uuidBusinessCategory2])) {
                            $businessCategories2[$uuidBusinessCategory2] = array('type' => $businessCategory2Data->name, 'count' => 0);
                        } else {
                            $businessCategories2[$uuidBusinessCategory2]['count'] ++;
                        }
                    }
                    StorageHelper::getInstance()->add('search.filter_data.biz_category_2', $businessCategories2);
                }

                // Search by extra business categories
                if (!empty($idsExtraBusinessCategories)) {
                    $establishmentsQuery->join(EstablishmentBusinessCategory::TABLENAME . ' AS ets_biz_categ', Establishment::TABLENAME . '.id', '=', 'ets_biz_categ.id_establishment');
                    $establishmentsQuery->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id_business_category', $idsExtraBusinessCategories, 'ets_biz_categ'));
                    $establishmentsQuery->addSelect('ets_biz_categ.id_business_category AS extra_business_category');
                }

                // Search by locations
                if (!empty($ids_location_index)) {
                    $establishmentsQuery->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id_location_index', $ids_location_index, Address::TABLENAME));
                }
                // Search by cooking type
                if (!empty($ids_biz_category_1)) {
                    $establishmentsQuery->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id', $ids_biz_category_1, 'biz_category1'));
                }
                // Search by promo type
                if (!empty($ids_promos)) {
                    $establishmentsQuery->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id_promotion_type', $ids_promos, Promotion::TABLENAME));
                }
                // Search by price
                if (!empty($price)) {
                    $establishmentsQuery->whereBetween(Establishment::TABLENAME . '.average_price_min', array(0, $price));
                }
                switch ($orderBy) {
                    default :
                    case self::SEARCH_ORDER_BY_PROXIMITY:
                        $establishmentsQuery->orderBy('rawDistance');
                        break;
                    case self::SEARCH_ORDER_BY_NAME:
                        $establishmentsQuery->orderBy('name');
                        break;
                }
            }
        }
        return $establishmentsQuery;
    }

    /**
     * 
     * @param type $searchQuery
     * @return LengthAwarePaginator
     */
    public static function buildSearchResults($searchQuery) {
        $establishments = array();
        $resultsPagination = null;
        if (!empty($searchQuery)) {
            // Query pagination management
            $nbElementPerPage = self::getFilterValues('display_by', self::DEFAULT_DISPLAY_BY);
            $currentPage = self::getFilterValues('page', 1); //LengthAwarePaginator::resolveCurrentPage(); 
            $sliceStart = ($currentPage - 1) * $nbElementPerPage;
            $nbTotalResults = $searchQuery->count(Establishment::TABLENAME . '.id');

            // Filter labels lists
            $minPrice = -1;
            $maxPrice = 0;
            $locationIndexes = array();
            $businessCategory1 = array();
            $businessCategory2 = StorageHelper::getInstance()->get('search.filter_data.biz_category_2');
            $promoTypes = array();

            $distance = self::getFilterValues('distance', self::DEFAULT_DISTANCE_KM_SEARCH);
            $establishmentFiltersData = $searchQuery->get();
            foreach ($establishmentFiltersData as $establishmentFilterData) {
                if ($establishmentFilterData->rawDistance <= ($distance * 1000)) {
                    // Filter label for price
                    if ($establishmentFilterData->average_price_min > 0) {
                        if ($establishmentFilterData->average_price_min > $maxPrice) {
                            $maxPrice = $establishmentFilterData->average_price_min;
                        }
                        if ($minPrice < 0 || $establishmentFilterData->average_price_min < $minPrice) {
                            $minPrice = $establishmentFilterData->average_price_min;
                        }
                    }
                    // Filter label for location
                    $uuidLocationIndex = UuidTools::getUuid($establishmentFilterData->id_location_index);
                    if (!isset($locationIndexes[$uuidLocationIndex])) {
                        $locationIndexes[$uuidLocationIndex] = array(
                                                                    'city' => $establishmentFilterData->city, 
                                                                    'postal_code' => $establishmentFilterData->postal_code, 
                                                                    'district' => $establishmentFilterData->district, 
                                                                    'count' => 1);
                    } else {
                        $locationIndexes[$uuidLocationIndex]['count'] ++;
                    }
                    // Filter label for business category 1 (cooking type, ...)
                    $uuidBusinessCat1 = UuidTools::getUuid($establishmentFilterData->id_biz_category_1);
                    if (!isset($businessCategory1[$uuidBusinessCat1])) {
                        $businessCategory1[$uuidBusinessCat1] = array('type' => $establishmentFilterData->name_biz_category_1, 'count' => 1);
                    } else {
                        $businessCategory1[$uuidBusinessCat1]['count'] ++;
                    }
                    // Filter label for extra business category
                    if (isset($establishmentFilterData->extra_business_category)) {
                        $uuidBusinessCategory2 = UuidTools::getUuid($establishmentFilterData->extra_business_category);
                        if (isset($businessCategory2[$uuidBusinessCategory2])) {
                            $businessCategory2[$uuidBusinessCategory2]['count'] ++;
                        }
                    }
                    // Filter label for promotion type
                    if (isset($establishmentFilterData->id_promotion_type)) {
                        $uuidPromotionType = UuidTools::getUuid($establishmentFilterData->id_promotion_type);
                        if (!isset($promoTypes[$uuidPromotionType])) {
                            $promoTypes[$uuidPromotionType] = array('type' => '', 'count' => 1);
                        } else {
                            $promoTypes[$uuidPromotionType]['count'] ++;
                        }
                    }
                }
            }

            // Filter labels save
            StorageHelper::getInstance()->add('search.filter_data.location_index', $locationIndexes);
            StorageHelper::getInstance()->add('search.filter_data.biz_category_1', $businessCategory1);
            StorageHelper::getInstance()->add('search.filter_data.min_price', $minPrice);
            StorageHelper::getInstance()->add('search.filter_data.max_price', $maxPrice);
            if (!empty($businessCategory2)) {
                foreach ($businessCategory2 as $uuid => $bizCat2info) {
                    if ($bizCat2info['count'] == 0) {
                        unset($businessCategory2[$uuid]);
                    }
                }
                StorageHelper::getInstance()->add('search.filter_data.biz_category_2', $businessCategory2);
            }
            if (!empty($promoTypes)) {
                $promoTypeIds = array_keys($promoTypes);
                $promoTypesData = DB::table(\App\Models\PromotionType::TABLENAME)
                        ->select('id', 'name')
                        ->whereRaw(DbQueryTools::genSqlForWhereRawUuidConstraint('id', $promoTypeIds, PromotionType::TABLENAME))
                        ->get();
                foreach ($promoTypesData as $promoTypeData) {
                    $uuidPromoType = UuidTools::getUuid($promoTypeData->id);
                    if (isset($promoTypes[$uuidPromoType])) {
                        $promoTypes[$uuidPromoType]['type'] = $promoTypeData->name;
                    }
                }
            }
            StorageHelper::getInstance()->add('search.filter_data.promo_type', $promoTypes);

            $searchQuery->offset($sliceStart)->limit($nbElementPerPage);
            $establishmentsData = $searchQuery->get();
            
            // Collect additional data without joining initial query
            $isosByIdCountry = array();
            $countryIds = $establishmentsData->pluck('id_country')->all();
            if(!empty($countryIds)){
                $etsCountriesData = DB::table(\App\Models\Country::TABLENAME)
                    ->select([\App\Models\Country::TABLENAME . '.iso', \App\Models\Country::TABLENAME . '.id'])
                    ->whereIn('id', $countryIds)
                    ->get();
                foreach($etsCountriesData as $etsCountryData){
                    $isosByIdCountry[$etsCountryData->id] = $etsCountryData->iso;
                }
            }
            foreach ($establishmentsData as $establishmentData) {
                if ($establishmentData->rawDistance <= ($distance * 1000)) {
                    $uuid = UuidTools::getUuid($establishmentData->id);
                    // Search results list
                    $establishments[$uuid]['id'] = $uuid;
                    $establishments[$uuid]['name'] = $establishmentData->name;
                    $establishments[$uuid]['logo_img'] = $establishmentData->logo_path;
//                    if(empty($establishmentData->logo_path)){
//                        $establishments[$uuid]['logo_img'] = \App\Utilities\MediaTools::getRandomDsThumbnailPath();
//                    } else {
//                        $establishments[$uuid]['logo_img'] = $establishmentData->logo_path;
//                    }
                    if(isset($establishmentData->thumbnail_path) && !empty($establishmentData->thumbnail_path)){
                        $establishments[$uuid]['thumbnail_img'] = $establishmentData->thumbnail_path;
                    }
                    $establishments[$uuid]['background_color'] = $establishmentData->background_color;
                    $establishments[$uuid]['city'] = $establishmentData->city;
                    $establishments[$uuid]['country'] = \App\Models\Country::getCountryLabel($establishmentData->id_country);
                    if(isset($isosByIdCountry[$establishmentData->id_country])){
                        $establishments[$uuid]['country_iso'] = $isosByIdCountry[$establishmentData->id_country];
                    }
                    $establishments[$uuid]['biz_category_1'] = $establishmentData->name_biz_category_1;
                    $establishments[$uuid]['raw_distance'] = StringTools::displayCleanDistance($establishmentData->rawDistance);
                    $establishments[$uuid]['latitude'] = $establishmentData->latitude;
                    $establishments[$uuid]['longitude'] = $establishmentData->longitude;
                    if($establishmentData->status == Establishment::STATUS_ACTIVE){
                        $establishments[$uuid]['url'] = Establishment::getUrlStatic($establishmentData->id_business_type, $establishmentData->city, 
                                $establishmentData->slug, $establishmentData->url_id);
                    }
                }
            }

            // Paginate results
            $resultsPagination = new LengthAwarePaginator($establishments, $nbTotalResults, $nbElementPerPage, $currentPage);
            $resultsPagination->setPath(Request::url());
        }
        return $resultsPagination;
    }

    public static function buildFilterLabels() {
        $orderBy = array(
            self:: SEARCH_ORDER_BY_PROXIMITY => "Proximité",
            self:: SEARCH_ORDER_BY_NAME => "Nom"
        );
        $displayBy = self::$nbElementsPerPageChoices;
        StorageHelper::getInstance()->add('search.filter_data.order_by', $orderBy);
        StorageHelper::getInstance()->add('search.filter_data.display_by', $displayBy);
    }

    public static function setFilterValues($key, $value) {
        SessionController::getInstance()->addSearchFilterValue($key, $value);
    }

    public static function getFilterValues($key, $defaultValue = null) {
        if (Request::exists($key)) {
            $value = Request::get($key);
            SessionController::getInstance()->addSearchFilterValue($key, $value);
        } else {
            $value = SessionController::getInstance()->getSearchFilterValue($key, $defaultValue);
        }
        return $value;
    }

}
