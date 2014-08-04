<?php

namespace Parser;

class Directory extends Inode
{
    
    /**
     * {@inheritdoc}
     */
    public function parse($compile)
    {
        if ($dh = opendir($this->getPath())) {
            println('Walk through directory' . $this->getPath());
            while (($file = readdir($dh)) !== false) {
                if ($file == '.' || $file == '..' || $file == 'processed') {
                    continue;
                }

        $path = realpath($this->getPath() . '/' . $file);

        if (is_file($path)) {
                    $obj = new Document($path);
                } elseif (is_dir($path)) {
                    $obj = new Directory($path);
                }

                try {
                    $obj->parse($compile);
                } catch (\Exception $e) {
                    error($e->getMessage());
                }
            }
            closedir($dh);
        } else {
            throw new \Exception('Could not load path ' . $this->getPath());
        }
    }
}


