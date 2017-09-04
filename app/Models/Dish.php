<?php

namespace App\Models;

/**
 * Class Dish
 */
class Dish extends Model {

    protected $table = 'dishes';

    const TABLENAME = 'dishes';
    const STATUS_ACTIVE = 1;

    public $timestamps = true;
    protected $fillable = [
        'name',
        'description',
        'status',
        'price',
        'currency',
        'start_date',
        'end_date',
        'position',
        'id_establishment',
        'id_photo'
    ];
    protected $guarded = [];

    /**
     * 
     * @param Dish $dishes
     * @param type $jsonEncoded
     * @return string
     */
    public static function getMediaConfigForInputFile($dishes, $jsonEncoded = true) {
        $mediaConfig = array();
        if ($dishes instanceof App\Models\Dish) {
            $dishes = array($dishes);
        }
        if (!empty($dishes)) {
            foreach ($dishes as $dish) {
                $media = $dish->media()->first();
                if($media instanceof Media){
                    $instanceConfig = array(
                        'caption' => $dish->getName()
                                    .'<br/>'
                                    .formatPrice($dish->getPrice(), $dish->getCurrencyLabel()),
                        'size' => '',
                        'key' => $media->getUuid(),
                        'url' => '/delete/' . $media::TABLENAME . '/' . $media->getUuid(),
                    );
                    $mediaConfig[] = $instanceConfig;
                }
            }
        }
        if ($jsonEncoded) {
            return json_encode($mediaConfig);
        } else {
            return $mediaConfig;
        }
    }
    
    /**
     * 
     * @return Media
     */
    public function media(){
        return $this->hasOne(EstablishmentMedia::class, 'id', 'id_photo');
    }
    
    /**
     * 
     * @return Establishment
     */
    public function establishment(){
        return $this->hasOne(EstablishmentMedia::class, 'id', 'id_establishment');
    }
    
    public function getCurrencyLabel(){
        return Currency::getCurrencyLabel($this->getCurrency());
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
    public function getDescription() {
        return $this->description;
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
    public function getPrice() {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getCurrency() {
        return $this->currency;
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
    public function getPosition() {
        return $this->position;
    }

    /**
     * @return mixed
     */
    public function getIdEstablishment() {
        return $this->id_establishment;
    }

    /**
     * @return mixed
     */
    public function getIdPhoto() {
        return $this->id_photo;
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
    public function setDescription($value) {
        $this->description = $value;
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
    public function setPrice($value) {
        $this->price = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setCurrency($value) {
        $this->currency = $value;
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
    public function setPosition($value) {
        $this->position = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdEstablishment($value) {
        $this->id_establishment = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdPhoto($value) {
        $this->id_photo = $value;
        return $this;
    }

}
