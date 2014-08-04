<?php

namespace Content;

abstract class BaseElement
{
    private $context;
    
    /**
     * Render the element 
     */
    abstract public function render();
    
    /**
     * Set the document content 
     * 
     * @param stirng $content
     */
    public function setContext($context)
    {
        $this->context = $context;
    }
    
    /**
     * Get the document content
     * 
     * return string
     */
    public function getContext()
    {
        return $this->context;
    }
    
    /**
     * Get content of the letter
     * 
     * @return string 
     */
    public function getContent()
    {
        // get content delimited by:
        // %-BeginContent
        // ...
        // %-EndContent
        if ( ! preg_match('/\%\-BeginContent(.*?)\%\-EndContent/ms', $this->getContext(), $matches)) {
            throw new \Exception('No content found in the text');
        }

        //remove all comment
        return preg_replace('/\%.*$/', '', $matches[1]);
    }
    
}
