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
    
    protected $name;
    protected $value;
    protected $label;
    protected $options;
    
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
}
