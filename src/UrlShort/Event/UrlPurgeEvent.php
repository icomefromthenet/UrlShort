<?php
namespace UrlShort\Event;

use DateTime;
use UrlShort\Shortner;

/**
  *  Event fire when pruge stored urls
  *
  *  @access since 1.0.0
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  */
class UrlPurgeEvent extends ContainerAwareEvent
{
    
    protected $before;
    
    /**
      *  Class Constructor
      *
      *  @param Shortner $shorten
      *  @param DateTime $before
      */
    public function __construct(Shortner $shorten, DateTime $before)
    {
        $this->before = $before;
        
        parent::__construct($shorten);
    }
    
    /**
      *  Get the BeforeDate
      *
      *  @return DateTime the before date
      *  @access public
      */
    public function getBefore()
    {
        return $this->shortCode;
    }
    
    
}
/* End of File */