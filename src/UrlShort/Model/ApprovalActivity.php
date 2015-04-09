<?php
namespace UrlShort\Model;

use DateTime;

/**
 * Log of an activity status change
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 0.0.1
 */ 
class ApprovalActivity 
{
    
    protected $statusCode;
    
    protected $subStatusCode;
    
    protected $changeDate;
    
    protected $comment;
    
    protected $user;
    
    
    /**
     * Class Constructor
     * 
     * @param string        The new status code
     * @param string        The new sub status code
     * @param DateTime      The time when change occured
     * @param integer       The user id that owns the url
     * @param string        A text description of why and how
     * @return void                    
     */ 
    public function __construct($statusCode,$subStatusCode,DateTime $changeDate,$userId,$comment) 
    {
        $this->statusCode    = $statusCode;
        $this->subStatusCode = $subStatusCode;
        $this->changeDate    = $changeDate;
        $this->comment       = $comment;
        $this->user          = $userId;
    }
    
    /**
     * Return the status code of this activity
     * 
     * @access public
     * @return string
     */ 
    public function getStatusCode()
    {
        return $this->statusCode;
    }
    
    /**
     * Return the sub status code of this activity
     * 
     * @access public
     * @return string
     */ 
    public function getSubStatusCode()
    {
        return $this->subStatusCode;
    }
    
    /**
     * Return the change time of this activity
     * 
     * @access public
     * @return string
     */ 
    public function getChangeDate()
    {
        return $this->changeDate;
    }
    
    /**
     * Return the commment of this activity
     * 
     * @access public
     * @return string
     */ 
    public function getComment()
    {
        return $this->comment;
    }
    
    /**
     * Return the user id of 
     * the link owner when activity was recorded
     * 
     * @access public
     * @return integer
     */ 
    public function getUser()
    {
        return $this->user;
    }
    
}
/* End of Class */