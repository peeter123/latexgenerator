<?php

namespace Console;

class ParseCommand
{
    /**
     * The path to parse
     * @var string
     */
    private $path;
    
    /**
     * Construct with the arguments
     * @param array $args 
     */
    public function __construct(array $args)
    {
        array_shift($args);
        $this->path = array_shift($args);
    }
    
    /**
     *  Execute the command
     */
    public function execute()
    {        
        if ($this->path === null) {
            throw new \Exception('No path given to parse');
        }
        
        $path = realpath(rtrim(getcwd(), '/') . '/' . $this->path);

        if (is_file($path)) {
            $obj = new \Parser\Document($path);
        } elseif (is_dir($path)) {
            $obj = new \Parser\Directory($path);
        }
        
        $obj->parse(false);
        $obj->parse(true);
    }
}