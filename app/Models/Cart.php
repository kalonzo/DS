<?php

namespace App\Models;

/**
 * Class Cart
 */
class Cart extends Model {

    protected $table = 'carts';
    const TABLENAME = 'carts';

    const STATUS_PENDING = 1;
    const STATUS_CHECKEDOUT = 2;
    
    public $timestamps = true;
    protected $fillable = [
        'status',
        'price_HT',
        'price_TTC',
        'vat_amount',
        'discount_amount',
        'discount_percent',
        'shipping_amount',
        'total_price',
        'id_currency',
        'id_user'
    ];
    protected $guarded = [];

    /**
     * 
     * @param type $cartLine
     * @param type $autoSetId
     * @return Cart
     */
    public function addLine($cartLine, $autoSetId = true, $autoCartSave = true){
        $this->setPriceHT($this->getPriceHT() + $cartLine->getPriceHT());
        $this->setPriceTTC($this->getPriceTTC() + $cartLine->getPriceTTC());
        if($autoSetId){
            $cartLine->setIdCart($this->getId());
            $cartLine->save();
        }
        if($autoCartSave){
            $this->save();
        }
        return $this;
    }
    
    public function removeAllLines(){
        $this->cartLines()->delete();
        $this->updateAmounts();
    }

    /**
     * 
     * @return Payment
     */
    public function getOrCreatePayment(){
        $payment = $this->payments()->where('status', '=', Payment::STATUS_START_CHECKOUT)->orderBy('updated_at')->first();
        if(!checkModel($payment)){
            $payment = Payment::create([
                'id' => \App\Utilities\UuidTools::generateUuid(),
                'status' => Payment::STATUS_START_CHECKOUT,
                'amount' => $this->getTotalPrice(false),
                'id_currency' => $this->getIdCurrency(),
                'id_user' => $this->getIdUser(),
                'id_cart' => $this->getId(),
                'id_payment_method' => 0,
                'id_bill' => 0,
            ]);
        }
        return $payment;
    }
    
    /**
     * Update all calculable cart fields from its cart lines
     * @return Cart
     */
    public function updateAmounts($updatesLines = true) {
        $cartLines = $this->cartLines()->get();
        $amountHT = 0;
        $vat_amount = 0;
        foreach($cartLines as $cartLine){
            if($updatesLines){
                $cartLine->updateAmounts();
            }
            $amountHT += $cartLine->getNetPriceHT();
            $vat_amount += $cartLine->getNetPriceTTC() - $cartLine->getNetPriceHT();
        }
        if(!empty($this->getDiscountAmount())){
            $amountHT -= $this->getDiscountAmount();
        }
        if(!empty($this->getDiscountPercent())){
            $amountHT = $amountHT * (1 - $this->getDiscountPercent() / 100);
        }
        
        $this->setPriceHT($amountHT);
        $this->setVatAmount($vat_amount);
        $amountTTC = $amountHT + $vat_amount;
        $this->setPriceTTC($amountTTC);
        
        $totalPrice = $amountTTC;
        if(!empty($this->getShippingAmount())){
            $totalPrice += $this->getShippingAmount();
        }
        $this->setTotalPrice($totalPrice);
        $this->save();
        return $this;
    }

    public function getLastPayment(){
        $payment = $this->payments()->whereIn('status', Payment::getFinalStatuses())->orderBy('updated_at')->first();
        return $payment;
    }
    
    public function getCurrencyLabel(){
        return Currency::getCurrencyLabel($this->getIdCurrency());
    }
    /**
     * 
     * @return Payment
     */
    public function payments(){
        return $this->hasMany(Payment::class, 'id_cart', 'id');
    }
    
    /**
     * 
     * @return CartLine
     */
    public function cartLines(){
        return $this->hasMany(CartLine::class, 'id_cart', 'id');
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
    public function getVatAmount() {
        return $this->vat_amount;
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
    public function getShippingAmount() {
        return $this->shipping_amount;
    }
    
    public function getTotalPrice() {
        return $this->total_price;
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
    public function setVatAmount($value) {
        $this->vat_amount = $value;
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
    public function setShippingAmount($value) {
        $this->shipping_amount = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setTotalPrice($value) {
        $this->total_price = $value;
        return $this;
    }

    function getIdUser() {
        return $this->id_user;
    }

    function setIdUser($id_user) {
        $this->id_user = $id_user;
    }
    
    function getIdCurrency() {
        return $this->id_currency;
    }

    function setIdCurrency($id_currency) {
        $this->id_currency = $id_currency;
        return $this;
    }
}
