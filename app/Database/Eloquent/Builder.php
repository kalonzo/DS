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

    public function get($columns = ['*']){
        print_r($this->eagerLoad);
        die();
        $builder = $this->applyScopes();

        if (count($models = $builder->getModels($columns)) > 0) {
            $models = $builder->eagerLoadRelations($models);
        }
        return $builder->getModel()->newCollection($models);
    }
}
