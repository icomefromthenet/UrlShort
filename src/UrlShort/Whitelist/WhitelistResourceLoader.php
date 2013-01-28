<?php
namespace UrlShort\Whitelist;

use Symfony\Component\Config\Loader\FileLoader;
use UrlShort\UrlShortException;

/**
  *  Load a whitelist regex collection for comparison
  *  
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */  
class WhitelistResourceLoader extends FileLoader
{
    public function load($resource, $type = null)
    {
        $raw_list = include $this->getLocator()->locate($resource);
    
        if(is_array($raw_list) === false) {
            throw new UrlShortException('WhiteList regex list must return an array');
        }
     
        $collection = new RegexCollection();
    
        foreach($raw_list as $item) {
            $collection->add($item);
        }
        
        return $collection;
    }

    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'php' === pathinfo(
            $resource,
            PATHINFO_EXTENSION
        );
    }
}


/* End of File */