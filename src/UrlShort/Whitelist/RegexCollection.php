<?php
namespace UrlShort\Whitelist;

use Closure, ArrayIterator;
use Doctrine\Common\Collections\ArrayCollection;

/**
  *  A list of collection with matching implemented
  *  
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */  
class RegexCollection extends ArrayCollection
{
    
    
    /**
     * Initializes a new ArrayCollection.
     *
     * @param array $elements
     */
    public function __construct(array $elements = array())
    {
        foreach($elements as $item) {
            $this->add($item);
        }
    }
        
    public function add($value)
    {
        # escape the regx and ensure unicode and caseless matching
        return parent::add('/'. $value. '/ui');
    }
    
    /**
      *  Match url to a regex item
      *
      *  @access public
      *  @param string $url
      */
    public function regexMatchUrl($url)
    {
        return $this->filter(function($item) use ($url){
            return (preg_match($item,$url)  === 1);
        });
    }
    
}
/* End of File */