<?php
namespace UrlShort\Event;

use UrlShort\Model\StoredUrl;

/**
  *  Event fire when url needs storage
  *
  *  @access since 1.0.0
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  */
class UrlStoreEvent extends BaseEvent
{
    /**
      *  @var StoredUrl 
      */
    protected $url;
    
    /**
      *  Class Constructor
      *
      * @param StoredUrl $url the entity that was stored
      */
    public function __construct(StoredUrl $url)
    {
        $this->url = $url;
    }
    
    
    /**
      *  Get the storage entity
      *
      *  @access public
      *  @return UrlShort\Model\StoredUrl
      */    
    public function getUrl()
    {
        return $this->url;
    }
    
}
/* End of File */