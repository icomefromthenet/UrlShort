<?php
namespace UrlShort\WorkFlow;

/**
  *  Maps status_codes to constants
  *
  *  @access since 1.0.0
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  */
final class BillingStates
{
    
    /**
     * The approval_bill event will transition a url to a status of 'PA-BILL'
     * this means that this link will be checked against a blacklist
     * 
     * @var string
     */ 
    const BILLING_READY = 'BILL';
    
    /**
     * The approval_paid event will transition a url to a status of 'PA-PAID'
     * this means that this link will be checked against a blacklist
     * 
     * @var string
     */ 
    const BILLING_PAID = 'BILL-PAID';
    
    /**
     * The approval_void event will transition a url to a status of 'PA-VOID'
     * this means that this link will be checked against a blacklist
     * 
     * @var string
     */ 
    const BILLING_VOID = 'BILL-VOID';
    
}
/* End of Class */