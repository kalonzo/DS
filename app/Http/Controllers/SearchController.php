<?php

namespace App\Http\Controllers;

/**
 * Description of SearchController
 *
 * @author Nico
 */
class SearchController {
    public static function quickSearch($terms){
        $results = array();
        $userLat = SessionController::getInstance()->getUserLat();
        $userLng = SessionController::getInstance()->getUserLng();
        if(!empty($terms) && !empty($userLat) && !empty($userLng)){
            $results = array(
                    array(
                        'label' => 'resto1',
                        'section' => 'Top Résultats',
                    ),
                    array(
                        'label' => 'resto2',
                        'section' => 'Top Résultats',
                    ),
                    array(
                        'label' => 'resto3',
                        'section' => 'Top Résultats',
                    ),
                    array(
                        'label' => 'resto2',
                        'section' => 'Nom',
                    ),
                    array(
                        'label' => 'resto3',
                        'section' => 'Nom',
                    ),
                    array(
                        'label' => 'Cuisine X',
                        'section' => 'Type de Cuisine',
                    ),
                );
        }
        return $results;
    }
}
