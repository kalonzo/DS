<?php

namespace App\Models;

/**
 * Class Menu
 */
class Menu extends Model {

    protected $table = 'menus';

    const TABLENAME = 'menus';
    const STATUS_ACTIVE = 1;

    public $timestamps = true;
    protected $fillable = [
        'name',
        'status',
        'is_daily_menu',
        'start_date',
        'end_date',
        'position',
        'id_establishment',
        'id_file'
    ];
    protected $guarded = [];
    
    /**
     * 
     * @return Media
     */
    public function media(){
        return $this->hasOne(EstablishmentMedia::class, 'id', 'id_file');
    }

    /**
     * 
     * @return Establishment
     */
    public function establishment(){
        return $this->hasOne(Establishment::class, 'id', 'id_establishment');
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
    public function getStatus() {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getIsDailyMenu() {
        return $this->is_daily_menu;
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
    public function getIdFile() {
        return $this->id_file;
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
    public function setStatus($value) {
        $this->status = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIsDailyMenu($value) {
        $this->is_daily_menu = $value;
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
    public function setIdFile($value) {
        $this->id_file = $value;
        return $this;
    }

}
