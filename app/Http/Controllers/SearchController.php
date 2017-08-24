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

    public static $nbElementsPerPageChoices = array(8, 24, 48, 96);

    public static function quickSearch($terms) {
        $results = array();
        $userLat = SessionController::getInstance()->getUserLat();
        $userLng = SessionController::getInstance()->getUserLng();
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        $userLatLng = new LatLng($userLat, $userLng);

        if (!empty($terms) && $userLatLng->isValid()) {
            // Search by proximity
            $rawDistanceRestaurantsQuery = Restaurant::where('name', 'LIKE', "%$terms%")
                    ->where('id_business_type', '=', $typeEts)
            ;
            $geolocLimitSuccess = DbQueryTools::setGeolocLimits($rawDistanceRestaurantsQuery, $userLatLng, self::DEFAULT_DISTANCE_KM_SEARCH, Establishment::TABLENAME);
            if($geolocLimitSuccess){
                $rawDistanceList = array();
                $rawDistanceRestaurants = $rawDistanceRestaurantsQuery->get();
                foreach ($rawDistanceRestaurants as $rawDistanceRestaurant) {
                    $rawDistance = GeolocTools::calculateRawDistance($userLatLng, $rawDistanceRestaurant->getLatLng());
                    $rawDistanceList[$rawDistance] = $rawDistanceRestaurant;
                }
                ksort($rawDistanceList);
                $counter = 1;
                foreach ($rawDistanceList as $distance => $restaurant) {
                    if ($counter <= self::NB_QUICK_RESULTS_PER_TYPE) {
                        $distanceDisplay = str_replace(' ', '<br/>', StringTools::displayCleanDistance($distance));
                        $results [] = array(
                            'id' => $restaurant->getUuid(),
                            'label' => $restaurant->getName(),
                            'value' => $restaurant->getName(),
                            'avatar_bg_color' => \App\Utilities\StyleTools::genColorHexaForVisualGradient('0090ff', '00b33b', ($distance/20000)),
                            'avatar_text' => $distanceDisplay,
                            'section' => 'Localité',
                            'order_by' => self::SEARCH_ORDER_BY_PROXIMITY,
                            'lat' => $restaurant->getLatitude(),
                            'lng' => $restaurant->getLongitude(),
                            'url' => $restaurant->getUrl()
                        );
                        $counter++;
                    } else {
                        break;
                    }
                }
                // Search by alphabetic
                $alphabetRestaurants = $rawDistanceRestaurantsQuery->orderBy('name')->limit(self::NB_QUICK_RESULTS_PER_TYPE)->get();
                foreach ($alphabetRestaurants as $distance => $restaurant) {
                    $results [] = array(
                        'id' => $restaurant->getUuid(),
                        'label' => $restaurant->getName(),
                        'value' => $restaurant->getName(),
                        'picture' => $restaurant->getDefaultPicture(),
                        'avatar_bg_color' => 'none',
                        'section' => 'Nom',
                        'order_by' => self::SEARCH_ORDER_BY_NAME,
                        'lat' => $restaurant->getLatitude(),
                        'lng' => $restaurant->getLongitude(),
                        'url' => $restaurant->getUrl()
                    );
                }

                // Search by cooking type
                $cookingTypesResults = BusinessCategory::select(DB::raw('count(' . EstablishmentBusinessCategory::TABLENAME . '.id_establishment' . ') as nb_establishment, '
                                        . BusinessCategory::TABLENAME . '.id, ' . BusinessCategory::TABLENAME . '.name'))
                        ->join(EstablishmentBusinessCategory::TABLENAME, EstablishmentBusinessCategory::TABLENAME . '.id_business_category', '=', BusinessCategory::TABLENAME . '.id')
                        ->join(Establishment::TABLENAME, EstablishmentBusinessCategory::TABLENAME . '.id_establishment', '=', Establishment::TABLENAME . '.id')
                        ->where(BusinessCategory::TABLENAME . '.name', 'LIKE', "%$terms%")
                        ->where(BusinessCategory::TABLENAME . '.type', '=', BusinessCategory::TYPE_COOKING_TYPE)
                        ->where(Establishment::TABLENAME . '.id_business_type', '=', $typeEts)
                        ->groupBy(BusinessCategory::TABLENAME . '.id')
                        ->orderBy(BusinessCategory::TABLENAME . '.name')
                        ->limit(self::NB_QUICK_RESULTS_PER_TYPE)
                        ->get()
                ;
                foreach ($cookingTypesResults as $result) {
                    $results [] = array(
                        'id' => UuidTools::getUuid($result->id_business_category),
                        'label' => $result->name,
                        'value' => $result->name,
                        'avatar_bg_color' => \App\Utilities\StyleTools::genRandomColorHexa(),
                        'avatar_text' => strtoupper($result->name[0]),
                        'text_right' => '(' . $result->nb_establishment . ')',
                        'section' => 'Type de cuisine',
                        'order_by' => self::SEARCH_ORDER_BY_COOKING_TYPE
                    );
                }
            }
        }

        return $results;
    }

    public static function search() {
        $view = null;
        $reset = Request::get('reset');
        if($reset){
            SessionController::getInstance()->resetSearchFilterValues();
        }
        self::buildFilterLabels();
        $establishmentsQuery = self::buildSearchQuery();

        if (!empty($establishmentsQuery)) {
            $resultsPagination = self::buildSearchResults($establishmentsQuery);
            $filterValues = SessionController::getInstance()->getSearchFilterValues();
            $filterLabels = StorageHelper::getInstance()->get('search.filter_data');
            if (!empty($resultsPagination)) {
                $reload = Request::get('reload');
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

        $terms = Request::get('term');
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
                    ->select(DB::raw(Establishment::TABLENAME . '.*, ' . Address::TABLENAME . '.* '
                                    . ', biz_category1.id as id_biz_category_1, biz_category1.name as name_biz_category_1'
                                    . ',' . DbQueryTools::genRawSqlForDistanceCalculation($userLatLng, Establishment::TABLENAME)))
                    ->join(Address::TABLENAME, Address::TABLENAME . '.id', '=', Establishment::TABLENAME . '.id_address')
                    ->join(EstablishmentBusinessCategory::TABLENAME, Establishment::TABLENAME . '.id', '=', EstablishmentBusinessCategory::TABLENAME . '.id_establishment')
                    ->join(BusinessCategory::TABLENAME . ' AS biz_category1', 'biz_category1.id', '=', EstablishmentBusinessCategory::TABLENAME . '.id_business_category')
                    ->leftJoin(Promotion::TABLENAME, Establishment::TABLENAME . '.id', '=', Promotion::TABLENAME . '.id_establishment')
                    ->where(Establishment::TABLENAME . '.name', 'LIKE', "%$terms%")
                    ->where(Establishment::TABLENAME . '.id_business_type', '=', $typeEts)
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
                        $locationIndexes[$uuidLocationIndex] = array('city' => $establishmentFilterData->city, 'count' => 1);
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
            foreach ($establishmentsData as $establishmentData) {
                if ($establishmentData->rawDistance <= ($distance * 1000)) {
                    $uuid = UuidTools::getUuid($establishmentData->id);
                    // Search results list
                    $establishments[$uuid]['id'] = $uuid;
                    $establishments[$uuid]['name'] = $establishmentData->name;
                    $establishments[$uuid]['img'] = "/img/images_ds/imagen-DS-" . rand(1, 20) . ".jpg";
                    $establishments[$uuid]['city'] = $establishmentData->city;
                    $establishments[$uuid]['country'] = \App\Models\Country::getCountryLabel($establishmentData->id_country);
                    $establishments[$uuid]['biz_category_1'] = $establishmentData->name_biz_category_1;
                    $establishments[$uuid]['raw_distance'] = StringTools::displayCleanDistance($establishmentData->rawDistance);
                    $establishments[$uuid]['latitude'] = $establishmentData->latitude;
                    $establishments[$uuid]['longitude'] = $establishmentData->longitude;
                    $establishments[$uuid]['url'] = Establishment::getUrlStatic($establishmentData->id_business_type, $establishmentData->city, 
                            $establishmentData->slug, $establishmentData->url_id);
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
