<?php
namespace UrlShort\Event;

use UrlShort\Model\StoredUrl;

/**
  *  Event fire when remove a stored url
  *
  *  @access since 1.0.0
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  */
class UrlRemoveEvent extends BaseEvent
{
    
    protected $url;
    
    /**
      *  Class Constructor
      *
      *  @param UrlShort\Model\StoredUrl $url 
      */
    public function __construct(StoredUrl $url)
    {
        $this->url = $url;
    }
    
    /**
      *  Get the database id to remove
      *
      *  @return UrlShort\Model\StoredUrl the removed url
      *  @access public
      */
    public function getUrl()
    {
        return $this->url;
    }

}
/* End of File */