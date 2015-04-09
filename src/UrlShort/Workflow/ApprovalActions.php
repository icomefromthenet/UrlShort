<?php
namespace UrlShort\WorkFlow;

/**
  *  Actions that cause transitions
  *
  *  @access since 1.0.0
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  */
final class ApprovalActions
{
    
    /**
     * The ADDED_APPROVAL_QUEUE action will transition a url to a status of 'AP'
     * this means the url it is awiting processing in the approval system AND not
     * entered the processing queue .
     * 
     * Also the opening state of any url entering the system.
     *
     * @var string
     */
    const ACTION_ADDED_QUEUE = 'added_queue';
    
     /**
     * Thewithdrawn_from_queue action will transition a url to a status of 'WI'
     * this means the url has been removed from approved queue and is in holding.
     * 
     * @var string
     */
    const ACTION_WITHDRAWN_FROM_QUEUE = 'withdrawn_from_queue';
    
    /**
     * The passed_approval action will transition a url to a status of 'PA'
     * this means the url has been approved
     *
     * @var string
     */
    const ACTION_PASSED_APPROVAL = 'passed_approval';
    
    /**
     * The failed_approval action will transition a url to a status of 'FA'
     * this means the url has failed approval
     *
     * @var string
     */
    const ACTION_FAILED_APPROVAL = 'failed_approval';
    
    /**
     * The whitelist_check action will transition a url to a status of 'AP-WH'
     * this means the url it will be checked against whitelist.
     *
     * @var string
     */
    const ACTION_WHITELIST_CHECK = 'whitelist_check';
    
    /**
     * The blacklist_check action will transition a url to a status of 'AP-BL'
     * this means the url it will be checked against blacklist.
     *
     * @var string
     */
    const ACTION_BLACKLIST_CHECK = 'blacklist_check';
    
    
    /**
     * The resolve_check action will transition a url to a status of 'AP-EX'
     * this means the url it will be tested for a resolution via a http request.
     *
     * @var string
     */
    const ACTION_RESOLVE_CHECK = 'resolve_check';
    
    /**
     * The gsb_check action will transition a url to a status of 'AP-GSB'
     * this means the url it will be tested against GSB (Google Safer Browsing API).
     *
     * @var string
     */
    const ACTION_GSB_CHECK = 'gsb_check';
    
}
/* End of Class */