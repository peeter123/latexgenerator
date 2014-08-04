<?php

namespace Content;

class Date extends BaseElement
{
    private $date;
    
    public function __construct($date = null)
    {
        if ($date === null) {
            $d = rand(0, 99);
            $m = rand(0, 99);
            $y = rand(1000, 9999);
            
            $date = ($d < 10 ? '0' . $d : $d) .
                    ($m < 10 ? '0' . $m : $m) . 
                     $y;
        }
        
        $this->date = $date;
    }
    
    public function render() 
    {
        println('Render date');
        return $this->date;
    }
}
