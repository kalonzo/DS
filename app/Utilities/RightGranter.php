<?php

namespace App\Utilities;

/**
 * Description of RightGranter
 *
 * @author Nico
 */
class RightGranter {
    
    private $user = null;
    /**
     * 
     * @param type $lazy
     * @return \App\Models\User
     */
    public function getUser($lazy = true){
        if($this->user === null || !$lazy){
            $this->user = \Illuminate\Support\Facades\Auth::user();
        }
        return $this->user;
    }
    
    public function isAllowedTo($action = null){
        $allowed = false;
        $user = $this->getUser();
        if(checkModel($user)){
            if($user->getType() === \App\Models\User::TYPE_USER_ADMIN_PRO){
                $allowed = true;
            }
        }
        return $allowed;
    }
    
    /******************* SINGLETON MANAGEMENT *********************************/
    
    private static $instance = null;
    private function __construct(){}
    
    /**
     * 
     * @return RightGranter
     */
    public static function getInstance(){
        if(self::$instance == null){
            self::setInstance(new self());
        }
        return self::$instance;
    }

    public static function setInstance(RightGranter $controller){
        if($controller != null){
            self::$instance = $controller ;
        }
    }
}
