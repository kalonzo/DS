<?php

namespace App\Models;

/**
 * Description of Model
 *
 * @author Nico
 */
class Model extends \Illuminate\Database\Eloquent\Model {

    protected $guarded = [];
    
    public function save(array $options = array()) {
        if(!isset($this->uuid) || empty($this->uuid)){
            $this->uuid = \Ramsey\Uuid\Uuid::uuid4();
        }
        return parent::save($options);
    }

    function getId() {
        return $this->uuid;
    }

    function setId($uuid) {
        $this->uuid = $uuid;
    }

    public static function findUUID($uuid) {
        return self::find(hex2bin($uuid));
    }

}
