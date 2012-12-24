<?php
namespace UrlShort\Event;

use Symfony\Component\EventDispatcher\Event;
use UrlShort\Shortner;

/**
  *  Base Event to make children aware of the DI container
  *
  *  @access since 1.0.0
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  */
class ContainerAwareEvent extends Event
{
    /**
      *  @var UrlShort\Shortner
      */
    protected $shortner;
    
    /**
      *  @var the result of the events 
      */
    protected $result;
    
    /**
      *  Class Constructor
      *
      *  @access public
      *  @param UrlShort\Shortner $shortner
      */
    public function __construct(Shortner $container)
    {
        $this->shortner = $shortner;
    }
    
    /**
      *  Return the DI container
      *
      *  @access public
      *  @return UrlShort\Shortner
      */
    public function getContainer()
    {
        return $this->shortner;
    }
    
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