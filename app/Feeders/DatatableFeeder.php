<?php
namespace App\Feeders;

/**
 * Description of DatatableFeeder
 *
 * @author Nico
 */
class DatatableFeeder {
    private $id = null;
    private $paginator = null;
    private $columns = array();
    private $reloaded = false;
    /**
     *
     * @var DatatableRowAction
     */
    private $actions = array();
    /**
     *
     * @var DatatableFilter
     */
    private $filters = array();
    
    function __construct($id) {
        $this->id = $id;
        if(empty($id) || is_numeric($id)){
            return null;
        }
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getPaginator() {
        return $this->paginator;
    }

    function getColumns() {
        return $this->columns;
    }

    function setPaginator($paginator) {
        $this->paginator = $paginator;
    }

    function setColumns($columns) {
        $this->columns = $columns;
    }
    
    function getReloaded() {
        return $this->reloaded;
    }

    function setReloaded($reloaded) {
        $this->reloaded = $reloaded;
    }

    function getViewParamsArray(){
        $paramsArray = array();
        $paramsArray['id'] = $this->getId();
        $paramsArray['rows'] = $this->getPaginator();
        $paramsArray['columns'] = $this->getColumns();
        $paramsArray['reloaded'] = $this->getReloaded();
        if(!empty($this->actions)){
            $paramsArray['actions'] = $this->actions;
        }
        if(!empty($this->filters)){
            $paramsArray['filters'] = $this->filters;
        }
        return $paramsArray;
    }
    
    function enableAction($action){
        $this->actions[$action] = DatatableRowAction::getActionDefaultInfo($action);
    }
    
    /**
     * 
     * @param type $action
     * @return DatatableRowAction
     */
    function customizeAction($action){
        if(!isset($this->actions[$action])){
            $this->enableAction($action);
        }
        return $this->actions[$action];
    }
    
    /**
     * 
     * @param DatatableFilter $filter
     */
    function addFilter($filter){
        $this->filters[] = $filter;
    }
}
