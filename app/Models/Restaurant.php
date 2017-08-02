<?php

namespace App\Models;


class Restaurant extends Establishment
{
    /**
     * 
     * @see \App\Models\Model::__construct()
     */
    public function __construct(){
        parent::__construct();
        $this->setIdBusinessType(BusinessType::TYPE_BUSINESS_RESTAURANT);
    }

    
}
