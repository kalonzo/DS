<?php

namespace App\Models;

/**
 * Class OpeningHour
 */
class OpeningHour extends Model {

    protected $table = 'opening_hours';
    const TABLENAME = 'opening_hours';
    
    public $timestamps = true;
    protected $fillable = [
        'day',
        'start_time',
        'end_time',
        'overnight',
        'day_order',
        'no_break',
        'closed',
        'start_date',
        'end_date',
        'id_establishment'
    ];
    protected $guarded = [];

    protected $dayLabels = null;
    public function getDayLabels($lazy = true){
        if($this->dayLabels === null || !$lazy){
            $this->dayLabels = \App\Utilities\DateTools::getDaysArray();
        }
        return $this->dayLabels;
    }
    
    public function getDayLabel(){
        $dayLabel = null;
        if(isset($this->getDayLabels()[$this->getDay()])){
            $dayLabel = $this->getDayLabels()[$this->getDay()];
        }
        return $dayLabel;
    }
    
    /**
     * @return mixed
     */
    public function getDay() {
        return $this->day;
    }

    /**
     * @return mixed
     */
    public function getStartTime() {
        return $this->start_time;
    }

    /**
     * @return mixed
     */
    public function getEndTime() {
        return $this->end_time;
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
    public function getIdEstablishment() {
        return $this->id_establishment;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDay($value) {
        $this->day = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setStartTime($value) {
        $this->start_time = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setEndTime($value) {
        $this->end_time = $value;
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
    public function setIdEstablishment($value) {
        $this->id_establishment = $value;
        return $this;
    }

    function getNoBreak() {
        return $this->no_break;
    }

    function getDayOrder() {
        return $this->day_order;
    }

    function setNoBreak($no_break) {
        $this->no_break = $no_break;
    }

    function setDayOrder($day_order) {
        $this->day_order = $day_order;
    }

    function getClosed() {
        return $this->closed;
    }

    function setClosed($closed) {
        $this->closed = $closed;
    }

    function getOvernight() {
        return $this->overnight;
    }

    function setOvernight($overnight) {
        $this->overnight = $overnight;
    }



}
