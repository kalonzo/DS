<?php

namespace App\Models;

/**
 * Class Gallery
 */
class Gallery extends Model {

    protected $table = 'galleries';
    const TABLENAME = 'galleries';
    
    const STATUS_PENDING = 1;
    const STATUS_VALIDATED = 2;
    
    const TYPE_ESTABLISHMENT_GALLERY = 1;
    
    public $timestamps = true;
    protected $fillable = [
        'status',
        'name',
        'type',
        'id_establishment'
    ];
    protected $guarded = [];

    /**
     * 
     * @return Media
     */
    public function medias(){
        return $this->hasMany(EstablishmentMedia::class, 'id_object_related', 'id');
    }

    /**
     * 
     * @return Establishment
     */
    public function establishment(){
        return $this->hasOne(EstablishmentMedia::class, 'id', 'id_establishment');
    }
    
    public function delete() {
        $this->medias()->delete();
        return parent::delete();
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
    public function getType() {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getIdEstablishment() {
        return $this->id_establishment;
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
    public function setType($value) {
        $this->type = $value;
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

}
