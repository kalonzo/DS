<?php

namespace App\Utilities;

class Translator extends \Illuminate\Translation\Translator {

    /**
     * Make the place-holder replacements on a line.
     *
     * @param  string  $line
     * @param  array   $replace
     * @return string
     */
    protected function makeReplacements($line, array $replace) {
        if (!empty($replace)) {
            // TODO for detect untranslated string
            echo $replace;
        }
        return parent::makeReplacements($line, $replace);
    }

    /**
     * Set translation.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @param  string  $locale
     * @return void
     */
    /*
    public function set($key, $value, $locale = null) {
        list($namespace, $group, $item) = $this->parseKey($key);

        if (null === $locale) {
            $locale = $this->locale;
        }

        // Load given group defaults if exists
        $this->load($namespace, $group, $locale);

        array_set($this->loaded[$namespace][$group][$locale], $item, $value);
    }
    */
    
    /**
     * Set multiple translations.
     *
     * @param  array   $items   Format: [group => [key => value]]
     * @param  string  $locale
     * @return void
     */
    /*
    public function add(array $items, $locale = null) {
        if (null === $locale) {
            $locale = $this->locale;
        }

        foreach ($items as $group => $translations) {
            // Build key to parse
            $key = $group . '.' . key($translations);

            list($namespace, $group) = $this->parseKey($key);

            // Load given group defaults if exists
            $this->load($namespace, $group, $locale);

            foreach ($translations as $item => $value) {
                array_set($this->loaded[$namespace][$group][$locale], $item, $value);
            }
        }
    }
     */

}
