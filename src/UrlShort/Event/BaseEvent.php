<?php
namespace UrlShort\Event;

use Symfony\Component\EventDispatcher\Event;

/**
  *  Base Event
  *
  *  @access since 1.0.0
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  */
class BaseEvent extends Event
{
    
    /**
      *  @var the result of the events 
      */
    protected $result;
   
    
    /**
      *  Get the result of the event
      *
      *  @return mixed
      *  @access public
      */
    public function getResult()
    {
        return $this->result;
    }
    
    /**
      *  Set the result of the event
      *
      *  @access public
      *  @param mixed $result
      */
    public function setResult($result)
    {
        $this->result = $result;
    }
    
    
}
/* End of File */