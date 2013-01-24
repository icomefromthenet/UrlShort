<?php
namespace UrlShort\Event;

use UrlShort\Decision\ReviewToken;

/**
  *  Event fire when url has passed
  *
  *  @access since 1.0.0
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  */
class UrlReviewPassEvent extends BaseEvent
{
    /**
      *  @var UrlShort\Decision\ReviewToken
      */
    protected $token;

    
    /**
      *  Class Constructor
      *
      */
    public function __construct(ReviewToken $token)
    {
        $this->token    = $token;
    }
    
    /**
      *  Get the review data token
      *
      *  @access public
      *  @return UrlShort\Decision\ReviewToken
      */    
    public function getToken()
    {
        return $this->token;
    }
    
}
/* End of File */