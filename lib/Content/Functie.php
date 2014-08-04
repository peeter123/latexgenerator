<?php

namespace Content;

class Functie extends BaseElement
{
    private $func;
    
    public function __construct($func)
    {
        $this->func = $func;
    }
    
	/**
	 * Return function + length of the content
	 */
    public function render() 
    {
        return 'Functie: '.$this->func;
    }
}
