<?php
namespace UrlShort\Decision;

use Psr\Log\LoggerInterface;

/**
* Resolve a decision and logs the result
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 1.0.0
*/
class DecisionResolver
{
    
    protected $logger;
    
    /**
      *  Class Constructor
      *
      *  @param Psr\Log\LoggerInterface Logger to use 
      */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    /**
      *  Resolve a decision 
      */    
    public function resolve(AbstractDecision $decision,ReviewToken $token)
    {
        $decisionMade = $decision->tally($token);
        
        $this->logger->info('review run for {url} decision::{decision} returned {returnValue}',array( 'url' => $token->getStoredUrl()->longUrl,
                                                                                                      'decision' => gettype($decision),
                                                                                                      'returnValue' => $decisionMade
                                                                                                ));    
        
        return $decisionMade;
    }
    
    
}
/* End of File */