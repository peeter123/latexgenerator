<?php

namespace Parser;

class Document extends Inode
{
    public function parse($compile)
    {
        if ($this->getExtension() != 'tex') {
            throw new \Exception('File ' . $this->getPath() . ' is not a LaTeX file');
        }
        
        println('Start parsing document ' . $this->getPath(), \Logger::DEBUG);
        
        // open the tex document
        $handle = fopen($this->getPath(), 'r');
        $content = fread($handle, filesize($this->getPath()));
        fclose($handle);
        
        println('Start preprocessing of ' . $this->getPath(), \Logger::DEBUG);
        // create classes based on the comments in the tex
        // format %Classname(arguments)%
        // with class = \Content\[classname]
        $data = preg_replace_callback('/\%([A-Z][A-Za-z].*?)\%/', function($matches) use ($content) {
            $php = '$obj = new \\Content\\' . str_replace(array('(', ',', ')'), array('("', '","', '")'), $matches[1]) . ';';

            eval($php);
            
            if ( ! $obj instanceof \Content\BaseElement) {
                throw new \Exception('Content element not instance of Content\ElementInterface');
            }

            $obj->setContext($content);
            
            return $obj->render();
        }, $content);
        
		if ($compile) {
			println('Write data to temporary tex file', \Logger::DEBUG);
			// write the data to a file
			$fp = fopen(ROOT . '/tex/tmp.tex', 'w');
			fwrite($fp, $data);
			fclose($fp);
			
			println('Compile '. basename($this->getPath()), \Logger::WARNING);
			$base = getcwd();
			chdir(ROOT . '/tex');
			$compile = compile(ROOT . '/tex/tmp.tex');
			chdir($base);
			
			if ($compile === false) {
				throw new \Exception('Could not compile the tex document');
			}

			if ( ! file_exists(ROOT . '/tex/tmp.pdf')) {
				throw new \Exception('No pdf was generated');
			}
			
			println('Move pdf to right directory', \Logger::DEBUG);
			$pathinfo = pathinfo($this->getPath());
			if(!is_dir($pathinfo['dirname'].'/processed/'))
			{
			    mkdir($pathinfo['dirname'].'/processed/');
			}
			$destpath = $pathinfo['dirname'].'/processed/'.$pathinfo['filename'].'.pdf';
			println('Moved processed file to: '.$destpath, \Logger::INFO);
			
			rename(ROOT . '/tex/tmp.pdf', $destpath);
		}
    }
}
