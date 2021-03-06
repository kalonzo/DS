<?php

namespace App\Models;

/**
 * Description of Model
 *
 * @author Nico
 */
class Model extends \Illuminate\Database\Eloquent\Model {

    use ExtendModelTrait;
    
    protected $guarded = [];
    public $incrementing = false;
    
    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }


}
