<?php
namespace App\Feeders;

use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

/**
 * Description of DatatableFeeder
 *
 * @author Nico
 */
abstract class DatatableFeeder {
    const DT_ID = null;
    
    protected $id = null;
    protected $nbElementPerPage = 10;
    protected $nbTotalResults;
    protected $paginator = null;
    protected $columns = array();
    protected $reloaded = false;
    protected $debug = false;
    /**
     *
     * @var DatatableRowAction
     */
    protected $actions = array();
    /**
     *
     * @var DatatableFilter
     */
    protected $filters = array();
    /**
     *
     * @var Builder
     */
    protected $query;
    
    protected $queryIndex;
    
    protected $results;
    
    function __construct($id = null) {
        if($id === null){
            $id = static::DT_ID;
        }
        $this->id = $id;
        if(empty($id) || is_numeric($id)){
            return null;
        }
    }
    
    function run(){
        $sliceStart = ($this->getCurrentPage() - 1) * $this->getNbElementPerPage();

        $filters = $this->buildFilters();
        $this->setFilters($filters);
        
        $query = $this->buildQuery();
        $this->setQuery($query);
        
        // Apply filters
        \App\Feeders\DatatableFilter::applyFilters($this->getQuery(), $this->getFilters());
        
        // Calculate total quantity of results
        $this->processNbTotalResults();
                
        // Slice results to display paginated view
        $query->offset($sliceStart)->limit($this->getNbElementPerPage());
        
        $columns = $this->buildColumns();
        $this->setColumns($columns);
        
        if($this->getDebug() && envDev()){
            print_r($this->getQuery()->toSql()); die();
        }
        $results = $this->buildResults($this->getQuery()->get());
        $this->setResults($results);
        
        $this->buildActions();
        $this->buildPaginator();
    }
    
    abstract function buildFilters();
    abstract function buildColumns();
    abstract function buildActions();
    abstract function buildQuery();
    abstract function buildResults(Collection $queryResults);
    
    abstract function getQueryIndex();
    
    function processNbTotalResults(){
        $this->nbTotalResults = $this->getQuery()->count($this->getQueryIndex());
    }

    public function buildPaginator() {
        $this->paginator = new LengthAwarePaginator($this->getResults(), $this->getNbTotalResults(), $this->getNbElementPerPage(), $this->getCurrentPage());
        $this->paginator->setPath(Request::url());
    }
    
    public function getCurrentPage(){
        return Request::get('page', 1);
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
    
    function getFilters(){
        return $this->filters;
    }

    function setFilters($filters) {
        $this->filters = $filters;
    }

    function getQuery(){
        return $this->query;
    }

    function setQuery($query) {
        $this->query = $query;
    }

    function getResults() {
        return $this->results;
    }

    function setResults($results) {
        $this->results = $results;
    }

    function getNbElementPerPage() {
        return $this->nbElementPerPage;
    }

    function setNbElementPerPage($nbElementPerPage) {
        $this->nbElementPerPage = $nbElementPerPage;
    }

    function getNbTotalResults() {
        return $this->nbTotalResults;
    }

    function setNbTotalResults($nbTotalResults) {
        $this->nbTotalResults = $nbTotalResults;
    }

    function getDebug() {
        return $this->debug;
    }

    function setDebug($debug) {
        $this->debug = $debug;
    }


}
