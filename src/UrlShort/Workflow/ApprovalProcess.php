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
class ApprovalProcess extends Process implements ApprovalStates, ApprovalActions
{
   
   const PROCESS_NAME = 'approval_process';
    
   
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
        
        $APPORVAL_WAITING       = new State(self::APPORVAL_WAITING);
        $APPROVAL_PENDING       = new State(self::APPROVAL_PENDING);
        $APPROVAL_WITHDRAWN     = new State(self::APPROVAL_WITHDRAWN);
        $APPROVAL_PASSED        = new State(self::APPROVAL_PASSED);
        $APPROVAL_FAILED        = new State(self::APPROVAL_FAILED);
        $APPROVAL_LINK_RESOLVE  = new State(self::APPROVAL_LINK_RESOLVE);
        $APPROVAL_GSB           = new State(self::APPROVAL_GSB);
        $APPROVAL_WHITELIST     = new State(self::APPROVAL_WHITELIST);
        $APPROVAL_BLACKLIST     = new State(self::APPROVAL_BLACKLIST);
     
        
        $approvedTransition     = new Transition($APPROVAL_PASSED,self::ACTION_PASSED_APPROVAL);
        $failedTransition       = new Transition($APPROVAL_FAILED,self::ACTION_FAILED_APPROVAL);
        $withdrawnTransition    = new Transition($APPROVAL_WITHDRAWN,self::ACTION_WITHDRAWN_FROM_QUEUE);
        
        $APPORVAL_WAITING->addTransition(new Transition($APPROVAL_PENDING,self::ACTION_ADDED_QUEUE));
        
        $APPROVAL_PENDING->addTransition(new Transition($APPROVAL_WHITELIST,self::ACTION_WHITELIST_CHECK));
        $APPROVAL_PENDING->addTransition($withdrawnApproval);
        
        $APPROVAL_WHITELIST->addTransition($approvedTransition);
        $APPROVAL_WHITELIST->addTransition($withdrawnApproval);
        $APPROVAL_WHITELIST->addTransition(new Transition($APPROVAL_BLACKLIST,self::ACTION_BLACKLIST_CHECK));
    
      
        $APPROVAL_BLACKLIST->addTransition($withdrawnApproval);
        $APPROVAL_BLACKLIST->addTransition($failedTransition);
        $APPROVAL_BLACKLIST->addTransition(new Transition($APPROVAL_LINK_RESOLVE,self::ACTION_RESOLVE_CHECK));
      
        $APPROVAL_LINK_RESOLVE->addTransition($withdrawnApproval);
        $APPROVAL_LINK_RESOLVE->addTransition($failedTransition);
        $APPROVAL_LINK_RESOLVE->addTransition(new Transition($APPROVAL_GSB, self::ACTION_GSB_CHECK));
        
        $APPROVAL_GSB->addTransition($withdrawnApproval);
        $APPROVAL_GSB->addTransition($failedTransition);
        $APPROVAL_GSB->addTransition($approvedTransition);
        
      
        parent::__construct(self::PROCESS_NAME, $APPORVAL_WAITING);
    }
    
    
    
    
}
/* End of Class */
