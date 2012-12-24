<?php
namespace UrlShort\Model;

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
    
}
/* End of File */