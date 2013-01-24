<?php
namespace UrlShort\Event;

use DateTime;

/**
  *  Event fire when pruge stored urls
  *
  *  @access since 1.0.0
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  */
class UrlPurgeEvent extends BaseEvent
{
    
    protected $before;
    
    /**
      *  Class Constructor
      *
      *  @param DateTime $before
      */
    public function __construct(DateTime $before)
    {
        $this->before = $before;
        
    }
    
    /**
      *  Get the BeforeDate
      *
      *  @return DateTime the before date
      *  @access public
      */
    public function getBefore()
    {
        return $this->before;
    }
    
    
}
/* End of File */