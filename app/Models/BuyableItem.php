<?php

namespace App\Models;

/**
 * Class BuyableItem
 */
class BuyableItem extends Model {

    protected $table = 'buyable_items';

    const TABLENAME = 'buyable_items';
    const TYPE_PRO_SUBSCRIPTION_LEVEL1 = 1;
    const TYPE_PRO_SUBSCRIPTION_LEVEL2 = 2;
    const TYPE_PRO_SUBSCRIPTION_LEVEL3 = 3;
    const TYPE_PRO_SUBSCRIPTION_LEVEL4 = 4;
    const STATUS_ACTIVE = 1;

    public $timestamps = true;
    protected $fillable = [
        'designation',
        'status',
        'type',
        'unit_price_HT',
        'unit_price_TTC',
        'vat_rate',
        'price_HT',
        'price_TTC',
        'discount_amount',
        'discount_percent',
        'net_price',
        'id_object',
        'type_object',
        'description',
        'start_date',
        'end_date',
        'id_business_type',
        'id_currency',
        'id_geographical_zone',
        'color'
    ];
    protected $guarded = [];
    
    /**
     * Get a cart line based on the current buyable item
     * @return \App\Models\CartLine
     */
    public function convertToCartLine(){
        $cartLine = CartLine::create([
            'designation' => $this->getDesignation(),
            'qty' => 1,
            'unit_price_HT' => $this->getUnitPriceHT(),
            'unit_price_TTC' => $this->getUnitPriceTTC(),
            'vat_rate' => $this->getVatRate(),
            'price_HT' => $this->getPriceHT(),
            'price_TTC' => $this->getPriceTTC(),
            'discount_amount' => $this->getDiscountAmount(),
            'discount_percent' => $this->getDiscountPercent(),
            'net_price_TTC' => $this->getNetPrice(),
            'id_buyable_item' => $this->getId(),
            'id_currency' => \App\Utilities\CurrencyTools::getIdCurrencyFromLocale(),
            'id_cart' => 0
        ]);
        return $cartLine;
    }

    /**
     * @return mixed
     */
    public function getDesignation() {
        return $this->designation;
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
    public function getType() {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getUnitPriceHT() {
        return $this->unit_price_HT;
    }

    /**
     * @return mixed
     */
    public function getUnitPriceTTC() {
        return $this->unit_price_TTC;
    }

    /**
     * @return mixed
     */
    public function getVatRate() {
        return $this->vat_rate;
    }

    /**
     * @return mixed
     */
    public function getPriceHT() {
        return $this->price_HT;
    }

    /**
     * @return mixed
     */
    public function getPriceTTC() {
        return $this->price_TTC;
    }

    /**
     * @return mixed
     */
    public function getDiscountAmount() {
        return $this->discount_amount;
    }

    /**
     * @return mixed
     */
    public function getDiscountPercent() {
        return $this->discount_percent;
    }

    /**
     * @return mixed
     */
    public function getNetPrice() {
        return $this->net_price;
    }

    /**
     * @return mixed
     */
    public function getIdObject() {
        return $this->id_object;
    }

    /**
     * @return mixed
     */
    public function getTypeObject() {
        return $this->type_object;
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
    public function getStartDate() {
        return $this->start_date;
    }

    /**
     * @return mixed
     */
    public function getEndDate() {
        return $this->end_date;
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
    public function getIdGeographicalZone() {
        return $this->id_geographical_zone;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDesignation($value) {
        $this->designation = $value;
        return $this;
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
    public function setType($value) {
        $this->type = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setUnitPriceHT($value) {
        $this->unit_price_HT = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setUnitPriceTTC($value) {
        $this->unit_price_TTC = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setVatRate($value) {
        $this->vat_rate = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setPriceHT($value) {
        $this->price_HT = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setPriceTTC($value) {
        $this->price_TTC = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDiscountAmount($value) {
        $this->discount_amount = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDiscountPercent($value) {
        $this->discount_percent = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setNetPrice($value) {
        $this->net_price = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdObject($value) {
        $this->id_object = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setTypeObject($value) {
        $this->type_object = $value;
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
    public function setStartDate($value) {
        $this->start_date = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setEndDate($value) {
        $this->end_date = $value;
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
    public function setIdGeographicalZone($value) {
        $this->id_geographical_zone = $value;
        return $this;
    }

    public function getColor() {
        return $this->color;
    }

    public function setColor($color) {
        $this->color = $color;
        return $this;
    }

    function getIdCurrency() {
        return $this->id_currency;
    }

    function setIdCurrency($id_currency) {
        $this->id_currency = $id_currency;
        return $this;
    }
}
