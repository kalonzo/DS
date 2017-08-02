<?php

namespace App\Feeders;

/**
 * Description of DatatableRowAction
 *
 * @author Nico
 */
class DatatableRowAction {
    const ACTION_EDIT = 1;
    
    protected $type;
    protected $icon;
    protected $title;
    protected $href;
    protected $onclick;
    
    public static function getActionDefaultInfo($actionType){
        $action = new DatatableRowAction();
        switch($actionType){
            case self::ACTION_EDIT:
                $action->setType($actionType);
                $action->setIcon('glyphicon-pencil');
                $action->setTitle('Editer');
                break;
        }
        return $action;
    }
    
    function getIcon() {
        return $this->icon;
    }

    function getTitle() {
        return $this->title;
    }

    function getHref() {
        return $this->href;
    }

    function getOnclick() {
        return $this->onclick;
    }

    function setIcon($icon) {
        $this->icon = $icon;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setHref($href) {
        $this->href = $href;
    }

    function setOnclick($onclick) {
        $this->onclick = $onclick;
    }
    
    function getType() {
        return $this->type;
    }

    function setType($type) {
        $this->type = $type;
    }
}
