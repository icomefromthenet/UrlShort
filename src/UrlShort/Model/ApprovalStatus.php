<?php
namespace UrlShort\Model;

/**
 * Used to represent a status code during the approval process.
 * 
 * Each status code is identifed by a primary code that 1-3 characters long
 * Each status code can belong to 1 parent status
 * Each code has a simple description (developers reference when examing the database schema)
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 0.0.1
 */ 
class ApprovalStatus 
{
    
    protected $code;
    
    protected $description;
    
    protected $parentCode;
    
    
    /**
     * Class Constructor
     * 
     * @param string    $code           The status code must be unique to all instance
     * @param string    $descrption     What does this code mean
     * @param string    $parentCode     Optional parent
     * @return void                    
     */ 
    public function __construct($code,$description,$parentCode = NULL) 
    {
        $this->code         = $code;
        $this->parentCode   = $parentCode;
        $this->description  = $description;
    }
    
    /**
     * The status identifier
     * 
     * @access public
     * @return string
     */ 
    public function getCode()
    {
        return $this->code;
    }
    
    /**
     * Return the optional parent identifier
     *  
     * @return string
     * @access public
     */ 
    public function getParentCode()
    {
        return $this->parentCode;
    }
    
    /**
     *  Fetch a short description about this status
     * 
     * @access public
     * @return string
     */ 
    public function getDescription()
    {
        return $this->description;
    }
    
}
/* End of Class */