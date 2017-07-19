<?php

namespace App\Database\Eloquent;
/**
 * Description of Builder
 *
 * @author Nico
 */
class Builder extends \Illuminate\Database\Eloquent\Builder{
    function __construct($query) {
        return parent::__construct($query);
    }

    public function create(array $attributes = []){
        $targetPrefix = $this->getModelTableName().'@';
        $targetAttributes = array();
        
        foreach ($attributes as $label =>$attribute){
            if(strpos($attribute, '@') !== false){
                if(strpos($attribute, $targetPrefix) === 0){
                    $label = str_replace($targetPrefix, '', $label);
                    $targetAttributes[$label] = $attribute;
                }
            } else {
                $targetAttributes[$label] = $attribute;
            }
        }
        
        return parent::create($targetAttributes);
    }
    
    public function getModelClass(){
        return get_class($this->newModelInstance());
    }

    /**
     * 
     * @return string
     */
    public function getModelTableName(){
        return $this->newModelInstance()->getTable();
    }
}
