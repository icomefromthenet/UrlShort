<?php
namespace UrlShort\GSB;

use GSB_Logger;
use Psr\Log\LoggerInterface;


class GSBLogBridge extends GSB_Logger
{
    
    /**
      *  @var Psr\Log\LoggerInterface; 
      */
    protected $logger;
    
    /**
      *  Class Constructor
      *
      *  @param mono
      *  @access public
      */
    function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function fatal($message)
    {
        $this->logger->critical($message,array());    
    }
    
    public function error($message)
    {
        $this->logger->error($message,array());
    }
    
    public function warn($message)
    {
        $this->logger->warn($message,array());
    }
    
    public function info($message)
    {
        $this->logger->info($message,array());
    }
    
    public function debug($message)
    {
        $this->logger->debug($message,array());
    }
        
}
/* End of File */