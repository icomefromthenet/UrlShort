<?php
namespace UrlShort\Event;

use DateTime;
use UrlShort\Shortner;

/**
  *  Event fire when query for a list of stored urls
  *
  *  @access since 1.0.0
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  */
class UrlQueryEvent extends ContainerAwareEvent
{
    
    protected $before;
    
    
    protected $after;
    
    
    protected $order;
    
    
    protected $limit;
    
    
    protected $offset;
    
    /**
      *  Class Constructor
      *
      *  @param Shortner $shorten
      *  @param DateTime $before
      */
    public function __construct(Shortner $shorten, $limit, $offset, $order = 'ASC', DateTime $before = null, DateTime $after = null)
    {
        $this->before = $before;
        $this->after  = $after;
        $this->limit  = $limit;
        $this->offset = $offset;
        $this->order  = strtoupper($order);
        
        parent::__construct($shorten);
    }
    
    /**
      *  Get the Before Date Param
      *
      *  @return DateTime the before date
      *  @access public
      */
    public function getBefore()
    {
        return $this->shortCode;
    }
    
    /**
      *  Get the After Date Param
      *
      *  @return DateTime the after date
      *  @access public
      */
    public function getAfter()
    {
        return $this->shortCode;
    }
    
    /**
      *  Get the Order param
      *
      *  @return string 'ASC' | 'DESC'
      */
    public function getOrder()
    {
        return $this->order;
    }
    
    /**
      *  Get the Limit param
      *
      *  @return integer the limit
      */
    public function getLimit()
    {
        return $this->limit;
    }
    
    /**
      *  Get the query offset
      *
      *  @return integer the offset
      *  @access public
      */
    public function getOffset()
    {
        return $this->offset;
    }
    
    
}
/* End of File */