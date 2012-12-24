<?php
namespace UrlShort\Event;

use UrlShort\Shortner,
    UrlShort\Model\StoredUrl;

/**
  *  Event fire when url needs spam check
  *
  *  @access since 1.0.0
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  */
class UrlSpamCheckEvent extends ContainerAwareEvent
{
    /**
      *  @var StoredUrl 
      */
    protected $url;
    
    /**
      *  Class Constructor
      *
      *  @param Shortner $shorten
      *  @param string $key the shortcode
      *  @param boolean $notice , if this lookup came from a redirect request 
      */
    public function __construct(Shortner $shorten,StoredUrl $url)
    {
        $this->url = $url;
        
        parent::__construct($shorten);
    }
    
    
    /**
      *  Get the storage entity
      *
      *  @access public
      *  @return UrlShort\Model\StoredUrl
      */    
    public function getStorage()
    {
        return $this->url;
    }
    
}
/* End of File */