<?php 

namespace SearchWords;

class Util
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function  getSearchableFolders()
    {
        $directories = [];

        $searchRoot = isset($this->config['searchRoot']) 
            ? $config['searchRoot'] : __DIR__;
        $dirIterator = new RecursiveDirectoryIterator($searchRoot);
        $dirIterator->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator = new RecursiveIteratorIterator($dirItearator, RecursiveIteratorIterator::SELF_FIRST);
        
        /**
         * @var SplFileInfo $dir
         */
        foreach ($iterator as $dir) {
            if ($dir->isDir()) {
                $directories[] = $dir;
            }
        
        return $directories;
    }
}


