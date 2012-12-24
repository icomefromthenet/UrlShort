<?php
namespace UrlShort\Event;

use UrlShort\Shortner;

/**
  *  Event fire when url is lookup by its shortcode
  *
  *  @access since 1.0.0
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  */
class UrlLookupEvent extends ContainerAwareEvent
{
    
    protected $shortCode;
    
    protected $notice;
    
    /**
      *  Class Constructor
      *
      *  @param Shortner $shorten
      *  @param string $key the shortcode
      *  @param boolean $notice , if this lookup came from a redirect request 
      */
    public function __construct(Shortner $shorten,$key,$notice)
    {
        $this->shortCode = $key;
        $this->notice    = (boolean) $notice;
        
        parent::__construct($shorten);
    }
    
    /**
      *  Get the short code
      *
      *  @return string the shortcode
      *  @access public
      */
    public function getShortCode()
    {
        return $this->shortCode;
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