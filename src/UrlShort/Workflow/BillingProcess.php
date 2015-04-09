<?php
namespace Urlshort\Workflow;

use UrlShort\UrlShortException;
use UrlShort\Model\StoredUrl;
use Metabor\Statemachine\Process;
use Metabor\Statemachine\State;
use Metabor\Statemachine\Statemachine;
use Metabor\Statemachine\Transition;


/**
 * Builds the approval state machine.
 * 
 * This used to control the processes that see a url approved for use by the shortner.
 * 
 * @author Lewis Dyer <getintouch@icomeformthenet.com>
 * @since 1.0
 */ 
class BillingProcess extends Process implements ApprovalStates, ApprovalActions
{
   
   const PROCESS_NAME = 'billing_process';
    
   
    /**
     * @param EventInterface $event
     * @param callable       $command
     */
    protected function addCommand(EventInterface $event, $command)
    {
        $callback = new Callback($command);
        $observer = new ObserverCallback($callback);
        $event->attach($observer);
    }

   
    
    /**
     * Build the Process which setup states and transitions.
     * Builds the FSM, ready to accept commands
     * 
     */ 
    public function __construct()
    {
        
       
        
      
        //parent::__construct(self::PROCESS_NAME, $APPORVAL_WAITING);
    }
    
    
    
    
}
/* End of Class */
