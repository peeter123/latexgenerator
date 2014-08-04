<?php

namespace Content;

class Titel extends BaseElement
{
    private $title;
    
    /**
     * Inject data
     * @param string $$title
     * @param string $number 
     */
    public function __construct($titel, $number)
    {
        \Registry::getInstance()->set('brieftitel_' . trim($number), $titel);
        \Registry::getInstance()->set('huidige_brief', trim($number));
        
        $this->titel = $titel;
    }
    
    
    public function render() 
    {
        return '\Titel{'. $this->titel .'}';
    }
}
