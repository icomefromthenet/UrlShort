<?php
namespace UrlShort\Workflow;

use ArrayAccess;
use Metabor\Statemachine\Command;
use Psr\Log\LoggerInterface;

use UrlShort\Model\StoredUrl;

//use UrlShort\Model\ActivityGateway


/**
  *  Log activity to database and log
  *
  *  @access since 1.0.0
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  */
class ActivityLogCommand extends Command
{
    
    /**
     * @var Psr\Log\LoggerInterface
     */ 
    protected $oLogger;
    
    
    
    protected $oActivityGateway;
    
    
    
    /**
     * Log to the activity table
     * 
     * @param StoredUrl   $url      The Url Entity
     * @param ArrayAccess $context  Result object
     */
    protected function logToDatabase(StoredUrl $url,ArrayAccess $context)
    {
        
        
        
    }
    
    /**
     * Log to the provided logger (usually a file logger)
     * 
     * @param StoredUrl   $url      The Url Entity
     * @param ArrayAccess $context  Result object
     */
    protected function logToLogger(StoredUrl $url,ArrayAccess $context)
    {
        
        
        
    }
    
    public function __construct(LoggerInterface $oLogger) 
    {
        $this->oLogger = $oLogger;
        
        
    }
    
    
    /**
     * Action that invoked when command is executed by machine
     * 
     * @param StoredUrl   $url      The Url Entity
     * @param ArrayAccess $context  Result object
     */
    public function __invoke(StoredUrl $url, ArrayAccess $context)
    {
        $this->logToDatabase($url,$context);
        $this->logToLogger($url,$context);
    }
    
    
    /**
     * Return the command name 
     * 
     * @return string
     */
    public function __toString()
    {
        return 'ActivityLog';
    }
    
    
}
/* End of Class */