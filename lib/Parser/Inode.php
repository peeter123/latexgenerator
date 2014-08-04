<?php

namespace Parser;

abstract class Inode
{
    /**
     * The path
     * @var string
     */
    private $path;
    
    
    public function __construct($path)
    {
        $this->path = $path;
    }
    
    /**
     * Get the path 
     * 
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * Get the extension of the path
     * 
     * @return string 
     */
    public function getExtension()
    {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }
    
    /**
     * Parse the content of the inode
     */
    abstract public function parse($arg);
}
