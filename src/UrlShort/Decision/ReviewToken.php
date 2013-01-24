<?php
namespace UrlShort\Decision;

use UrlShort\Model\StoredUrl;
use UrlShort\UrlShortException;


/**
  *  This review token is passed into each ReviewDecision. 
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */  
class ReviewToken
{
    /**
      *  @var UrlShort\Model\StoredUrl 
      */
    protected $storedUrl;
    
    /**
      *  @var boolean review result trur/pass fail/false 
      */
    protected $reviewResults;
    
    /**
      *  @var string a message from the review. 
      */
    protected $reviewMessages;
    
    /**
      *  Class Constructor
      *
      *  @access public
      *  @param StoredUrl $url to use in the review
      */
    public function __construct(StoredUrl $url)
    {
        $this->storedUrl      = $url;
        $this->reviewResult   = array();
        $this->reviewMessages = array();
    }
    
    //------------------------------------------------------------------
    
    /**
      *  Return the assigned store url
      *
      *  @access public
      *  @return UrlShort\Model\StoredUrl
      */
    public function getStoredUrl()
    {
        return $this->storedUrl;
    }
    
    //------------------------------------------------------------------
    
    /**
      *  Set the review message
      *
      *  @access public
      *  @param string Criteria index
      *  @param sttring the review message
      *  @return string a review message
      */
    public function addReviewMessage($criteria,$msg)
    {
        $this->reviewMessage[$criteria] = $msg;
    }
    
    /**
      *  Get the review message can be used in
      *  a rejection email or passed to identify
      *  which review failed.
      *
      *  @access public
      *  @param string Criteria index
      *  @return string the review message
      */
    public function getReviewMessage($criteria)
    {
        $msg = null;
        
        if(isset($this->reviewMessage[$criteria])) {
            $msg = $this->reviewMessage[$criteria];
        }
        
        return $msg;
    }
    
    /**
      *  Get the review messages can be used in
      *  a rejection email or passed to identify
      *  which review failed.
      *
      *  @access public
      */
    public function getReviewMessages()
    {
        return $this->reviewMessage;
    }
    
    //------------------------------------------------------------------
    
    /**
      *  Set the review result
      *
      *  @access public
      *  @param string Criteria index
      *  @param boolean $result true/pass faile/false;
      */
    public function addReviewResult($criteria,$result)
    {
        
        if(is_bool($result) === false) {
            new UrlShortException('Review Result must be a boolean');
        }
        
        $this->reviewResult[$criteria] = $result;
        
    }
    
    /**
      *  Fetch a review result
      *
      *  @access public
      *  @param string Criteria index
      *  @return boolean the review result true/pass fail/false
      */
    public function getReviewResult($criteria)
    {
        $msg = null;
        
        if(isset($this->reviewMessage[$criteria])) {
            $msg = $this->reviewResult[$criteria];
        }
        
        return $msg;
    }
    
    /**
      *  Fetch a review result
      *
      *  @access public
      *  @return array the review results true/pass fail/false
      */
    public function getReviewResults()
    {
        return $this->reviewResult;        
    }
    
}

/* End of File */