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
        if(!isset($this->id) || empty($this->id)){
            $this->id = hex2bin(str_replace('-', '', \Ramsey\Uuid\Uuid::uuid4()));
        }
        return parent::save($options);
    }

    function getId() {
        return $this->attributes['id'];
    }
    
    function getUuid(){
        return bin2hex($this->getId());
    }
    
    /**
     * Find a unique object from UUID
     * @param type $uuid
     * @return self
     */
    public static function findUuid($uuid){
        $classObject = null;
        $className = static::getClass();
        $tableName = static::getTableName();
        $object = \Illuminate\Support\Facades\DB::table($tableName)->whereRaw(' HEX(id) = "'.$uuid.'" ')->first();
        if(!is_null($object)){
            $objectArray = array($object);
            $objectCollection = $className::hydrate($objectArray);
            $classObject = $objectCollection->first();
        }
        return $classObject;
    }
    
    public static function getClass(){
        return get_class(new static);
    }
    /**
     * 
     * @return string
     */
    public static function getTableName(){
        return ((new static)->getTable());
    }
    
    protected static function create($attributes = array()) {
        $findme ='@';
        
        
        
        foreach ($attributes as $val){
            //echo $val.   '<br>';
            $pos = strpos($val, $findme);
            if($pos == true) {
                echo $val . '<br>' ;
            }
        }
     
        die();
        return parent::create();
    }
}
