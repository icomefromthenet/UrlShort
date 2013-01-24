<?php
namespace UrlShort\Event;

use DateTime;
use Doctrine\Common\Collections\Collection;

/**
  *  Event fire when query run for a list of stored urls
  *
  *  @access since 1.0.0
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  */
class UrlQueryEvent extends BaseEvent
{
    
    /**
      *  Class Constructor
      *
      *  @param Doctrine\Common\Collections\Collection $collection
      *
      */
    public function __construct(Collection $collection)
    {
        $this->setResult($collection);
    }
    
    
}
/* End of File */