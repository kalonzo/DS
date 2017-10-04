<?php
namespace App\Models\Interfaces;


/**
 *
 * @author Nico
 */
interface EstablishmentBoundable {
    /**
     * 
     * @return Establishment
     */
    public function establishment();
    
    /**
     * @return mixed
     */
    public function getIdEstablishment();
    public function setIdEstablishment($id_establishment);
    
}
