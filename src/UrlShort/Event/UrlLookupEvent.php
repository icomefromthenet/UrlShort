<?php
namespace UrlShort\Event;

use UrlShort\Model\StoredUrl;

/**
  *  Event fire when url is lookup by its shortcode
  *
  *  @access since 1.0.0
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  */
class UrlLookupEvent extends BaseEvent
{
    
    protected $url;
    
    protected $notice;
    
    /**
      *  Class Constructor
      *
      *  @param UrlShort\Model\StoredUrl $url
      *  @param boolean $notice , if this lookup came from a redirect request 
      */
    public function __construct(StoredUrl $url, $notice)
    {
        $this->url     = $url;
        $this->notice  = (boolean) $notice;
        
    }
    
    /**
      *  Get the short code
      *
      *  @return UrlShort\Model\StoredUrl $url
      *  @access public
      */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
      *  Was lookup from a redirect request
      *
      *  @return boolean true if from redirect request
      *  @access public
      */
    public function getNotice()
    {
        return $this->notice;
    }
    
}
/* End of File */