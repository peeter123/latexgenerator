<?php

namespace Content;

class Kenmerk extends BaseElement
{
    private $number, $ondertekenletter,$afstandscintilla;

    /**
     * Inject data
     * @param $number
     * @param $ondertekenletter
     * @param $afstandscintilla
     * @internal param string $time
     */
    public function __construct($number, $ondertekenletter, $afstandscintilla)
    {
        $this->number = $number;
		$this->ondertekenletter = strtoupper($ondertekenletter);
		$this->afstandscintilla = $afstandscintilla;
    }
    
    /**
     * Get the time variable
     * 
     * @return string
     * @throws \Exception 
     */
    protected function getNumber()
    {
        return $this->number;
    }
	
	protected function getAfstand()
	{
	
		return $this->afstandscintilla;
	}
    
    /** 
     * Get amount of Het Comite in the letter
     * 
     * @return string
     */
    protected function getAmountComite()
    {
        return substr_count($this->getContent(), '\\comite');
    }
	protected function getOndertekenaar()
	{
		return $this->ondertekenletter;
	}
    
	protected function getAmountofDots()
	{
		return substr_count($this->getContent(), '.') + substr_count($this->getContent(),',');
	}
	
	protected function getRandomColorLetter()
	{
		$colors = ['r','g','b','z','p','o','t'];
		$c = rand(0, count($colors) - 1);
		return $colors[$c];
	}
	
	protected function getLidwoorden()
	{
		return 	substr_count($this->getContent(), 'de') + substr_count($this->getContent(),'het')+ substr_count($this->getContent(),'een')+ 
				substr_count($this->getContent(), 'De') + substr_count($this->getContent(),'Het')+ substr_count($this->getContent(),'Een');
	}
	protected function getAnummer()
	{
		$An = array('d' => 1,'p' => 2,'m' => 3,'t' => 4, 'r' =>5, 'e' => 6);
		return $An[strtolower($this->ondertekenletter)];
	}
    
    public function render() 
    {
        return $this->getNumber() . "=" . $this->getAfstand() . "\\#" . $this->getAmountComite() . "/" .
               $this->getLidwoorden() . "/" . $this->getAmountofDots() . "$>$" . $this->getOndertekenaar() .
               $this->getAnummer() . $this->getRandomColorLetter();
    }
}
