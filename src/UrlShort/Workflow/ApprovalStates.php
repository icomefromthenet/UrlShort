<?php
namespace UrlShort\WorkFlow;

/**
  *  Maps status_codes to constants
  *
  *  @access since 1.0.0
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  */
final class WorkflowStates
{
    /**
     * The apporval_waiting event will transition a url to a status of 'W'
     * this means the url it is awiting processing in the approval system AND not
     * entered the processing queue .
     * 
     * Also the opening state of any url entering the system.
     *
     * @var string
     */
    const APPORVAL_WAITING  = 'W';
    
    /**
     * The approval_pending event will transition a url to a status of 'AP'
     * this means the url is awiting processing and has entered the processing queue.
     *
     * @var string
     */
    const APPROVAL_PENDING = 'AP' ;
    
    /**
     * The approval_withdrawn event will transition a url to a status of 'WI'
     * this means that it has been withdrawn from the approval system before
     * completion this done by a manual action from a user. A failure use a
     * different status
     *
     * @var string
     */
    const APPROVAL_WITHDRAWN = 'WI';
    
    /**
     * The approval_passed event will transition a url to a status of 'PA'
     * this means that all apporval checks have passed sucessfuly.
     * 
     * @var string
     */
    const APPROVAL_PASSED = 'PA';
    
    /**
     * The approval_failed event will transition a url to a status of 'FA'
     * this means that end result of approval subs system has decied to 
     * classify this url has bad.
     * 
     * @var string
     */
    const APPROVAL_FAILED = 'FA';
    
    
    /**
     * The approval_link_resolved event will transition a url to a status of 'AP-EX'
     * this means that this linked will be tested for a resolve. i.e. return 200 ok from http request
     * 
     * @var string
     */ 
    const APPROVAL_LINK_RESOLVE = 'AP-EX';
    
    /**
     * The approval_link_resolved event will transition a url to a status of 'AP-GSB'
     * this means that this link is to be checked against Google Safer Browsing API
     * 
     * @var string
     */ 
    const APPROVAL_GSB ='AP-GSB';
    
    /**
     * The approval_whitelist event will transition a url to a status of 'AP-WH'
     * this means that this link checked against a whitelist
     * 
     * @var string
     */ 
    const APPROVAL_WHITELIST = 'AP-WH';
    
    /**
     * The approval_blacklist event will transition a url to a status of 'AP-BL'
     * this means that this link will be checked against a blacklist
     * 
     * @var string
     */ 
    const APPROVAL_BLACKLIST = 'AP-BL';
    
    
    
}
/* End of Class */