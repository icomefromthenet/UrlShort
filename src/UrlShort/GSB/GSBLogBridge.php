<?php
namespace UrlShort\GSB;

use GSB_Logger;
use Monolog\Logger;

class GSBLogBridge extends GSB_Logger
{
    
    /**
      *  @var Monolog\Logger; 
      */
    protected $logger;
    
    /**
      *  Class Constructor
      *
      *  @param integer $level -1, none, 0 fatal only, 4 all
      *  @param mono
      *  @access public
      */
    function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function fatal($message)
    {
        $this->logger->addCritical($message);    
    }
    
    public function error($message)
    {
        $this->logger->addError($message);
    }
    
    public function warn($message)
    {
        $this->logger->addWarning($message);
    }
    
    public function info($message)
    {
        $this->logger->addInfo($message);
    }
    
    public function debug($message)
    {
        $this->logger->addDebug($message);
    }
        
}
/* End of File */