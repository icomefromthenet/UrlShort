<?php
namespace UrlShort\Event;

use UrlShort\Shortner;

/**
  *  Event fire when remove a stored url
  *
  *  @access since 1.0.0
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  */
class UrlRemoveEvent extends ContainerAwareEvent
{
    
    protected $id;
    
    /**
      *  Class Constructor
      *
      *  @param Shortner $shorten
      *  @param integer $id the database id
      */
    public function __construct(Shortner $shorten,$id)
    {
        $this->id = (integer) $id;
                
        parent::__construct($shorten);
    }
    
    /**
      *  Get the database id to remove
      *
      *  @return integer the database id
      *  @access public
      */
    public function getId()
    {
        return $this->id;
    }

}
/* End of File */