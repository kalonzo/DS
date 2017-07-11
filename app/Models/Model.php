<?php

namespace App\Models;

/**
 * Description of Model
 *
 * @author Nico
 */
class Model extends \Illuminate\Database\Eloquent\Model{
    public $id;
    
    function __construct() {
        // TODO Génération de l'ID
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }
}
