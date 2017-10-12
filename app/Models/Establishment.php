<?php

namespace App\Models;

/**
 * Class Establishment
 */
class Establishment extends Model implements GlobalObjectManageable{
    
    protected $table = 'establishments';
    const TABLENAME = 'establishments';
    const TYPE_GLOBAL_OBJECT = self::TYPE_OBJECT_ESTABLISHMENT;

    const TYPE_BUSINESS_RESTAURANT = 1;

    const STATUS_ACTIVE = 1;
    const STATUS_INCOMPLETE = 2;
    const STATUS_TO_LOCALIZE = 3;
    const STATUS_TO_VALID = 4;
    
    public $timestamps = true;
    protected $fillable = [
        'status',
        'business_status',
        'name',
        'slug',
        'url_id',
        'email',
        'id_address',
        'DS_ranking',
        'id_logo',
        'id_video',
        'star',
        'nb_last_week_visits',
        'accept_voucher',
        'accept_booking',
        'site_url',
        'description',
        'average_price_min',
        'average_price_max',
        'id_currency',
        'id_banking_info',
        'id_user_owner',
        'id_business_type',
        'latitude',
        'longitude'
    ];
    protected $guarded = [];

    private $latLng = null;
    public function getLatLng($lazy = true){
        if($this->latLng === null || !$lazy){
            $this->latLng = new Utilities\LatLng($this->getLatitude(), $this->getLongitude());
        }
        return $this->latLng;
    }
    
    public static function getLabelByStatus(){
        $labelByStatus = array();
        $labelByStatus[self::STATUS_ACTIVE] = 'Activé';
        $labelByStatus[self::STATUS_INCOMPLETE] = 'Incomplet';
        $labelByStatus[self::STATUS_TO_LOCALIZE] = 'A géolocaliser';
        $labelByStatus[self::STATUS_TO_VALID] = 'A valider';
        return $labelByStatus;
    }
    
    public static function getLabelFromStatus($status){
        $statusLabel = 'Statut non défini';
        $etsStatusLabels = self::getLabelByStatus();
        if(isset($etsStatusLabels[$status])){
            $statusLabel = $etsStatusLabels[$status];
        }
        return $statusLabel;
    }
    
    public function getBusinessTypeLabel(){
        $businessLabel = 'Type non défini';
        $businessTypeLabels = BusinessType::getLabelByType();
        if(isset($businessTypeLabels[$this->getIdBusinessType()])){
            $businessLabel = $businessTypeLabels[$this->getIdBusinessType()];
        }
        return $businessLabel;
    }
    
    public function getDefaultPicture($validated = true){
        $picPath = null;
        $logo = null;
        $logoQuery = $this->logo();
        if($validated){
            $logoQuery->where('status', '=', EstablishmentMedia::STATUS_VALIDATED);
        }
        $logo = $logoQuery->first();
        if(checkModel($logo)){
            $picPath = $logo->getLocalPath();
        } else {
            $picPath = \App\Utilities\MediaTools::getRandomDsThumbnailPath();
        }
        return $picPath;
    }
    
    public function getDefaultBanner($validated = true){
        $picPath = null;
        $banner = null;
        $bannerQuery = $this->homePictures();
        if($validated){
            $bannerQuery->where('status', '=', EstablishmentMedia::STATUS_VALIDATED);
        }
        $banner = $bannerQuery->orderBy('position')->limit(1)->first();
        if(checkModel($banner)){
            $picPath = $banner->getLocalPath();
        } else {
            $picPath = \App\Utilities\MediaTools::getRandomDsThumbnailPath();
        }
        return $picPath;
    }
    
    public function calculateBusinessStatus($autoSave = true){
        $businessStatus = 0;
        
        $userOwner = $this->userOwner()->count();
        if($userOwner === 1){
            $businessStatus = 25;
        }
        
        $address = $this->address()->first();
        if(checkModel($address) && $address instanceof Address){
            $geocoded = $address->getGeocoded();
            if($geocoded){
                $callNumbers = $this->callNumbers()->count();
                if($callNumbers >= 2){
                    switch($this->getIdBusinessType()){
                        case BusinessType::TYPE_BUSINESS_RESTAURANT:
                            $cookingType = $this->businessCategories()->where('type', '=', BusinessCategory::TYPE_COOKING_TYPE)->count();
                            if($cookingType >= 1){
                                $businessStatus = 50;
                            }
                            break;
                    }
                    $logo = $this->logo()->count();
                    if($logo === 1){
                        $homePics = $this->homePictures()->count();
                        if($homePics >= 1){
                            $menus = $this->menus()->count();
                            if($menus >= 1){
                                $businessStatus = 75;
                            }
                        }
                    }
                }
            }
        }
        
        if($this->getStatus() === self::STATUS_ACTIVE){
            $businessStatus += 25;
        }
        $this->setBusinessStatus($businessStatus);
        if($autoSave){
            $this->save();
        }
    }
    
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function address(){
        return $this->hasOne(Address::class, 'id', 'id_address');
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function userOwner(){
        return $this->hasOne(User::class, 'id', 'id_user_owner');
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function logo(){
        return $this->hasOne(EstablishmentMedia::class, 'id', 'id_logo');
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function video(){
        return $this->hasOne(EstablishmentMedia::class, 'id', 'id_video');
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function homePictures(){
        return $this->hasMany(EstablishmentMedia::class, 'id_object_related', 'id')->where('type_use', '=', Media::TYPE_USE_ETS_HOME_PICS);
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function callNumbers(){
        return $this->hasMany(CallNumber::class, 'id_object_related', 'id');
    }
/**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function businessCategoryLinks(){
        return $this->hasMany(EstablishmentBusinessCategory::class, 'id_establishment', 'id');
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function businessCategories(){
        return $this->belongsToMany(BusinessCategory::class, EstablishmentBusinessCategory::TABLENAME, 'id_establishment', 'id_business_category');
    }    
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function openingHours(){
        return $this->hasMany(OpeningHour::class, 'id_establishment', 'id');
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function closePeriods(){
        return $this->hasMany(ClosePeriod::class, 'id_establishment', 'id');
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function galleries(){
        return $this->hasMany(Gallery::class, 'id_establishment', 'id');
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function employees(){
        return $this->hasMany(Employee::class, 'id_establishment', 'id');
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function stories(){
        return $this->hasMany(EstablishmentHistory::class, 'id_establishment', 'id');
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function menus($excludeDaily = true){
        $menus = $this->hasMany(Menu::class, 'id_establishment', 'id');
        if($excludeDaily){
            $menus->whereNull('is_daily_menu')->orWhere('is_daily_menu', '!=', 1);
        }
        return $menus;
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function dailyMenu(){
        return $this->hasOne(Menu::class, 'id_establishment', 'id')->where('is_daily_menu', '=', true)->orderBy('created_at', 'DESC');
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function dishes(){
        return $this->hasMany(Dish::class, 'id_establishment', 'id');
    }
    /**
     * 
     * @return \App\Database\Eloquent\Builder
     */
    public function promotions(){
        return $this->hasMany(Promotion::class, 'id_establishment', 'id');
    }
    
    /**
     * Increments nbLastWeekVisits and save it
     */
    public function incrementWeeklyVisit(){
        $this->setNbLastWeekVisits($this->getNbLastWeekVisits() + 1);
        $this->save();
    }
    
    protected $url = null;
    public function getUrl($lazy = true){
        if($this->url === null || !$lazy){
            if($this->getStatus() === self::STATUS_ACTIVE){
                $typeLabel = str_slug($this->getBusinessTypeLabel());
                $citySlug = $this->address()->first()->getCitySlug();
                $slug = $this->getSlug();
                $urlId = $this->getUrlId();
                if(!empty($typeLabel) && !empty($citySlug) && !empty($slug) && !empty($urlId)){
                    $this->url = '/'.$typeLabel.'/'.$citySlug.'/'.$slug.'/'.$urlId.'/';
                }
            }
        }
        return $this->url;
    }
    
    public static function getUrlStatic($typeBusiness, $city, $slug, $urlId){
        $url = null;
        $businessTypeLabels = BusinessType::getLabelByType();
        if(isset($businessTypeLabels[$typeBusiness])){
            $typeLabel = $businessTypeLabels[$typeBusiness];
            if(!empty($typeLabel) && !empty($city) && !empty($slug) && !empty($urlId)){
                $citySlug = str_slug($city);
                $typeSlug = str_slug($typeLabel);
                $url = '/'.$typeSlug.'/'.$citySlug.'/'.$slug.'/'.$urlId.'/';
            }
        }
        return $url;
    }
    
    public function save(array $options = array()) {
        $this->generateUrlId();
        if($this->isDirty()){
            $changedAttr = $this->getDirty();
            if(isset($changedAttr['name']) && !isset($changedAttr['slug'])){
                $this->generateSlug();
            }
        } else if(empty($this->getSlug())){
            $this->generateSlug();
        }
        return parent::save($options);
    }
    
    
    public function generateUrlId() {
        $urlId = $this->getUrlId();
        if (empty($urlId)) {
            $uuid = $this->getUuid();
            if (empty($uuid)) {
                $id = \App\Utilities\UuidTools::generateUuid();
                $uuid = \App\Utilities\UuidTools::getUuid($id);
                $this->setId($id);
            }
            $urlId = self::generateStaticUrlId($uuid);
            $this->setUrlId($urlId);
        }
    }

    public static function generateStaticUrlId($uuid) {
        $urlId = '';
        $countdown = 8;
        if (checkHexUuid($uuid)) {
            for ($i = 0; $i <= strlen($uuid); $i++) {
                $char = $uuid[$i];
                if (is_numeric($char)) {
                    $urlId .= $char;
                    $countdown--;
                    if ($countdown <= 0) {
                        break;
                    }
                }
            }
        }
        return $urlId;
    }
    
    public function generateSlug(){
        $name = $this->getName();
        $slug = null;
        if(!empty($name)){
            $slug = str_slug($name);
            $this->setSlug($slug);
        }
        return $slug;
    }

    /**
     * @return mixed
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getIdAddress() {
        return $this->id_address;
    }

    /**
     * @return mixed
     */
    public function getDSRanking() {
        return $this->DS_ranking;
    }

    /**
     * @return mixed
     */
    public function getIdLogo() {
        return $this->id_logo;
    }

    /**
     * @return mixed
     */
    public function getStar() {
        return $this->star;
    }

    /**
     * @return mixed
     */
    public function getNbLastWeekVisits() {
        return $this->nb_last_week_visits;
    }

    /**
     * @return mixed
     */
    public function getAcceptVoucher() {
        return $this->accept_voucher;
    }

    /**
     * @return mixed
     */
    public function getSiteUrl() {
        return $this->site_url;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getAveragePriceMin() {
        return $this->average_price_min;
    }

    /**
     * @return mixed
     */
    public function getAveragePriceMax() {
        return $this->average_price_max;
    }

    /**
     * @return mixed
     */
    public function getIdBankingInfo() {
        return $this->id_banking_info;
    }

    /**
     * @return mixed
     */
    public function getIdUserOwner() {
        return $this->id_user_owner;
    }

    /**
     * @return mixed
     */
    public function getIdBusinessType() {
        return $this->id_business_type;
    }

    /**
     * @return mixed
     */
    public function getLongitude() {
        return $this->longitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setStatus($value) {
        $this->status = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setName($value) {
        $this->name = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setEmail($value) {
        $this->email = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdAddress($value) {
        $this->id_address = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDSRanking($value) {
        $this->DS_ranking = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdLogo($value) {
        $this->id_logo = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setStar($value) {
        $this->star = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setNbLastWeekVisits($value) {
        $this->nb_last_week_visits = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setAcceptVoucher($value) {
        $this->accept_voucher = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setSiteUrl($value) {
        $this->site_url = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDescription($value) {
        $this->description = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setAveragePriceMin($value) {
        $this->average_price_min = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setAveragePriceMax($value) {
        $this->average_price_max = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdBankingInfo($value) {
        $this->id_banking_info = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdUserOwner($value) {
        $this->id_user_owner = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdBusinessType($value) {
        $this->id_business_type = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setLatitude($value) {
        $this->latitude = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setLongitude($value) {
        $this->longitude = $value;
        return $this;
    }

    function getSlug() {
        return $this->slug;
    }

    function setSlug($slug) {
        $this->slug = $slug;
        return $this;
    }
    
    function getUrlId() {
        return $this->url_id;
    }

    function setUrlId($url_id) {
        $this->url_id = $url_id;
        return $this;
    }
    
    function getIdCurrency() {
        return $this->id_currency;
    }

    function setIdCurrency($id_currency) {
        $this->id_currency = $id_currency;
        return $this;
    }

    function getIdVideo() {
        return $this->id_video;
    }

    function setIdVideo($id_video) {
        $this->id_video = $id_video;
        return $this;
    }

    function getAcceptBooking() {
        return $this->accept_booking;
    }

    function getBusinessStatus() {
        return $this->business_status;
    }

    function setAcceptBooking($accept_booking) {
        $this->accept_booking = $accept_booking;
        return $this;
    }

    function setBusinessStatus($business_status) {
        $this->business_status = $business_status;
        return $this;
    }


    
}
