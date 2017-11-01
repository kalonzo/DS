<?php

namespace App\Feeders;

/**
 * Description of DatatableRowAction
 *
 * @author Nico
 */
class DatatableRowAction {
    const ACTION_EDIT = 1;
    const ACTION_REMOVE = 2;
    const ACTION_VALID = 3;
    const ACTION_DENY = 4;
    
    protected $type;
    protected $icon;
    protected $title;
    protected $href;
    protected $onclick;
    protected $hiddenCond;
    
    public static function getActionDefaultInfo($actionType){
        $action = new DatatableRowAction();
        switch($actionType){
            case self::ACTION_EDIT:
                $action->setType($actionType);
                $action->setIcon('glyphicon-pencil');
                $action->setTitle('Editer');
               break;
            case self::ACTION_REMOVE:
                $action->setType($actionType);
                $action->setIcon('glyphicon-trash');
                $action->setTitle('Effacer');
                break;
            case self::ACTION_VALID:
                $action->setType($actionType);
                $action->setIcon('glyphicon-ok-circle');
                $action->setTitle('Valider');
                break;
            case self::ACTION_DENY:
                $action->setType($actionType);
                $action->setIcon('glyphicon-remove-circle');
                $action->setTitle('Refuser');
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

    function getHiddenCond() {
        return $this->hiddenCond;
    }

    function setHiddenCond($hiddenCond) {
        $this->hiddenCond = $hiddenCond;
    }


}
