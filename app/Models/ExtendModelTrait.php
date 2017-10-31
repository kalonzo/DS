<?php

namespace App\Models;

/**
 * Description of ExtendModelTrait
 *
 * @author Nico
 */
trait ExtendModelTrait{
    
    protected static $hasUuid = true;
    
    public function save(array $options = array()) {
        if(!checkModelId($this->id) && $this->hasUuid()){
            $this->id = \App\Utilities\UuidTools::generateUuid();
        }
        return parent::save($options);
    }
    
    function getId() {
        return $this->attributes['id'];
    }
    
    function getUuid(){
        return \App\Utilities\UuidTools::getUuid($this->getId());
    }
    
    function hasUuid() {
        return static::$hasUuid;
    }

    function setHasUuid($hasUuid) {
        static::$hasUuid = $hasUuid;
        self::$hasUuid = $hasUuid;
    }
    
    public static function hasUuidStatic() {
        return static::$hasUuid;
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
    public static function findUuid($uuid, $columns = ['*']){
        $classObject = null;
        if(self::hasUuidStatic()){
            if (is_array($uuid) || $uuid instanceof Arrayable) {
                $classObject = static::whereRaw(\App\Utilities\DbQueryTools::genSqlForWhereRawUuidConstraint('id', $uuid))->get($columns);
            } else {
                $className = static::getClass();
                $tableName = static::getTableName();
                $object = \Illuminate\Support\Facades\DB::table($tableName)->whereRaw(' HEX(id) = "'.$uuid.'" ')->first($columns);
                if(!is_null($object)){
                    $objectArray = array($object);
                    $objectCollection = $className::hydrate($objectArray);
                    $classObject = $objectCollection->first();
                }
            }
        } else {
            $classObject = static::find($uuid, $columns);
        }
        return $classObject;
    }
    
//    public static function find($id, $columns = ['*']){
//        if(self::hasUuidStatic()){
//            var_dump(self::hasUuidStatic());
//            if (is_array($id) || $id instanceof Arrayable) {
//                return self::whereRaw(\App\Utilities\DbQueryTools::genSqlForWhereRawUuidConstraint('id', $id))->get($columns)->get();
//            }
//            return self::findUuid($id, $columns);
//        } else {
//            return parent::find($id, $columns);
//        }
//    }
    
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
