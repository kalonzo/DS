<?php

namespace App\Feeders;

/**
 * Description of DatatableFilter
 *
 * @author Nico
 */
class DatatableFilter {
    const INPUT_TEXT = 1;
    const INPUT_SELECT = 2;
    const INPUT_RADIOBOX = 3;
    const INPUT_CHECKBOX = 4;
    const INPUT_MULTISELECT = 5;
    
    const OPERATOR_EQUAL = 1;
    const OPERATOR_GREATER_THAN = 2;
    const OPERATOR_EOG = 3;
    const OPERATOR_LESS_THAN = 4;
    const OPERATOR_EOL = 5;
    const OPERATOR_LIKE = 6;
    const OPERATOR_LIKE_START = 7; // xxx%
    const OPERATOR_LIKE_END = 8; // %xxx
    const OPERATOR_LIKE_CONTAINS = 9; // %xxx%
    const OPERATOR_IN = 10;
    
    protected $name;
    protected $value;
    protected $label;
    protected $options;
    protected $inputType;
    protected $placeholder;
    protected $table;
    protected $field;
    protected $operator;
    protected $raw = null;
    protected $enableEmpty = true;
    protected $isRaw = false;
    
    /**
     * 
     * @param \Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Query\Builder
     */
    function processConstraint($query){
        if($query instanceof \Illuminate\Database\Query\Builder){
            if($this->getEnableEmpty() || !empty($this->getValue())){
                if(!empty($this->getRaw())){
                    $query->whereRaw($this->getRaw());
                } else {
                    switch($this->getOperator()){
                        case self::OPERATOR_EQUAL:
                        case self::OPERATOR_GREATER_THAN:
                        case self::OPERATOR_EOG:
                        case self::OPERATOR_LESS_THAN:
                        case self::OPERATOR_EOL:
                        case self::OPERATOR_LIKE:
                        case self::OPERATOR_LIKE_START:
                        case self::OPERATOR_LIKE_END:
                        case self::OPERATOR_LIKE_CONTAINS:
                            if($this->getIsRaw()){
                                $queryValue = $this->getValueQuery();
                                if(!is_numeric($queryValue)){
                                    $queryValue = '"'.$queryValue.'"';
                                }
                                $query->whereRaw($this->getFieldQuery().' '.$this->getOperatorQuery().' '.$queryValue);
                            } else {
                                $query->where($this->getFieldQuery(), $this->getOperatorQuery(), $this->getValueQuery());
                            }
                            break;
                        case self::OPERATOR_IN:
                            if($this->getIsRaw()){
                                $query->whereRaw($this->getFieldQuery().' IN ('.implode(',', $this->getValueQuery()).')');
                            } else {
                                $query->whereIn($this->getFieldQuery(), $this->getValueQuery());
                            }
                            break;
                    }
                }
            }
        }
        return $query;
    }
    
    /**
     * 
     * @param \Illuminate\Database\Query\Builder $query
     * @param DatatableFilter $filters
     * @return \Illuminate\Database\Query\Builder
     */
    public static function applyFilters($query, $filters){
        if($query instanceof \Illuminate\Database\Query\Builder){
            if(!empty($filters)){
                foreach ($filters as $filter){
                    if($filter instanceof DatatableFilter){
                        $filter->processConstraint($query);
                    }
                }
            }
        }
        return $query;
    }
    
    public function getValueQuery(){
        $value = null;
        switch($this->getOperator()){
            case self::OPERATOR_EQUAL:
            case self::OPERATOR_GREATER_THAN:
            case self::OPERATOR_EOG:
            case self::OPERATOR_LESS_THAN:
            case self::OPERATOR_EOL:
            case self::OPERATOR_LIKE:
                $value = $this->getValue();
                break;
            case self::OPERATOR_LIKE_START:
                $value = '%'. $this->getValue();
                break;
            case self::OPERATOR_LIKE_END:
                $value = $this->getValue().'%';
                break;
            case self::OPERATOR_LIKE_CONTAINS:
                $value = '%'.$this->getValue().'%';
                break;
            case self::OPERATOR_IN:
                if(!is_array($this->getValue())){
                    $value = [$this->getValue()];
                } else {
                    $value = $this->getValue();
                }
                break;
        }
        return $value;
    }
    
    public function getFieldQuery(){
        $field = '';
        if(!empty($this->getTable())){
            $field .= $this->getTable().'.';
        }
        if(!empty($this->getField())){
            $field .= $this->getField();
        }
        return $field;
    }
    
    public function getOperatorQuery(){
        return self::getOperatorFromType($this->getOperator());
    }
    
    public static function getOperatorFromType($type){
        $operator = null;
        switch($type){
            case self::OPERATOR_EQUAL:
                $operator = '=';
                break;
            case self::OPERATOR_GREATER_THAN:
                $operator = '>';
                break;
            case self::OPERATOR_EOG:
                $operator = '>=';
                break;
            case self::OPERATOR_LESS_THAN:
                $operator = '<';
                break;
            case self::OPERATOR_EOL:
                $operator = '<=';
                break;
            case self::OPERATOR_LIKE:
            case self::OPERATOR_LIKE_START:
            case self::OPERATOR_LIKE_END:
            case self::OPERATOR_LIKE_CONTAINS:
                $operator = 'LIKE';
                break;
            case self::OPERATOR_IN:
                $operator = 'IN';
                break;
        }
        return $operator;
    }
    
    function getName() {
        return $this->name;
    }

    function getValue() {
        return $this->value;
    }

    function getLabel() {
        return $this->label;
    }

    function getOptions() {
        return $this->options;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setValue($value) {
        $this->value = $value;
    }

    function setLabel($label) {
        $this->label = $label;
    }

    function setOptions($options) {
        $this->options = $options;
    }
    
    function getInputType() {
        return $this->inputType;
    }

    function setInputType($inputType) {
        $this->inputType = $inputType;
    }

    function getPlaceholder() {
        return $this->placeholder;
    }

    function setPlaceholder($placeholder) {
        $this->placeholder = $placeholder;
    }

    function getTable() {
        return $this->table;
    }

    function getField() {
        return $this->field;
    }

    function getOperator() {
        return $this->operator;
    }

    function getRaw() {
        return $this->raw;
    }

    function setTable($table) {
        $this->table = $table;
    }

    function setField($field) {
        $this->field = $field;
    }

    function setOperator($operator) {
        $this->operator = $operator;
    }

    function setRaw($raw) {
        $this->raw = $raw;
    }

    function getEnableEmpty() {
        return $this->enableEmpty;
    }

    function setEnableEmpty($enableEmpty) {
        $this->enableEmpty = $enableEmpty;
    }

    function getIsRaw() {
        return $this->isRaw;
    }

    function setIsRaw($isRaw) {
        $this->isRaw = $isRaw;
    }

}
