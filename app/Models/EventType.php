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

    public static function getLabelByType() {
        $labelByType = array();
        //$labelByType[self::TYPE_DISCOUNT_PERCENT] = 'Anniversaire';
        //$labelByType[self::TYPE_DISCOUNT_AMOUNT] = 'Happy hour';
        return $labelByType;
    }

    public static function getLabelFromType($type) {
        $typeLabel = 'Type non défini';
        $eventTypeLabels = self::getLabelByType();
        if (isset($eventTypeLabels[$type])) {
            $typeLabel = $eventTypeLabels[$type];
        }
        return $typeLabel;
    }

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
