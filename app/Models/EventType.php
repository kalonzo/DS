<?php

namespace App\Models;

/**
 * Class EventType
 */
class EventType extends Model {

    protected $table = 'event_types';
    const TABLENAME = 'event_types';

    public $timestamps = true;
    public $incrementing = true;
    public static $hasUuid = false;
    
    protected $fillable = [
        'label'
    ];
    protected $guarded = [];

    /**
     * @return mixed
     */
    public function getLabel() {
        return $this->label;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setLabel($value) {
        $this->label = $value;
        return $this;
    }

}
