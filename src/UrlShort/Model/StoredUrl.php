<?php
namespace UrlShort\Model;

use DateTime;

/**
  *  Entity of stored urls
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class StoredUrl
{
    /**
      *  @var integer the database id 
      */
    public $urlId;
    
    /**
      *  @var string the 6 chracter shortcode 
      */
    public $shortCode;
    
    /**
      *  @var string the url to direct 
      */
    public $longUrl;
    
    /**
      *  @var DateTime the date stored 
      */
    public $dateStored;
    
    /**
      *  @var string optional description 
      */
    public $description;
    
    /**
      *  @var boolean if the review has passed only set once run 
      */
    public $reviewPassed;
    
    /**
      *  @var string if failure a description of why and where. 
      */
    public $reviewFailureMessage;
    
    /**
      *  @var Datetime the date of the review 
      */    
    public $reviewDate;
    
    /**
      *  @var integer a relation to the tag that has been assigned 
      */
    public $tagId;
    
}
/* End of File */