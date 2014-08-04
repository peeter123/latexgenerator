<?php

namespace Content;

class VolgendeBrief extends BaseElement
{
    public function render() 
    {
        $number = \Registry::getInstance()->get('huidige_brief') + 1;
		return \Registry::getInstance()->get('brieftitel_'. $number);
    }
}
