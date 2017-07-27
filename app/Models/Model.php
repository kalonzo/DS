<?php

namespace App\Models;

/**
 * Description of Model
 *
 * @author Nico
 */
class Model extends \Illuminate\Database\Eloquent\Model {

    protected $guarded = [];
    public $incrementing = false;
    
    public function save(array $options = array()) {
//        if(!isset($this->id) || empty($this->id)){
        if(!$this->exists){
            $this->id = \App\Utilities\UuidTools::generateUuid();
        }
        return parent::save($options);
    }
    
//    protected function insertAndSetId(\Illuminate\Database\Eloquent\Builder $query, $attributes){
//        $keyName = $this->getKeyName();
//        $id = \App\Utilities\UuidTools::generateUuid();
//
//        $this->setAttribute($keyName, $id);
//    }
    
    function getId() {
        return $this->attributes['id'];
    }
    
    function getUuid(){
        return \App\Utilities\UuidTools::getUuid($this->getId());
    }
    
    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query){
        return new \App\Database\Eloquent\Builder($query);
    }

    /**
     * Get a new query builder instance for the connection.
     *
     * @return \Illuminate\Database\Query\Builder
     */
//    protected function newBaseQueryBuilder()
//    {
//        $connection = $this->getConnection();
//
//        return new QueryBuilder(
//            $connection, $connection->getQueryGrammar(), $connection->getPostProcessor()
//        );
//    }

    
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
    
}