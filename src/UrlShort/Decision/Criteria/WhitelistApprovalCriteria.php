<?php
namespace UrlShort\Decision\Criteria;

use UrlShort\Decision\CriteriaInterface;
use UrlShort\Decision\ReviewToken;


/**
* Check if a on the whitelist
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 1.0.0
*/
class GSBCriteria implements CriteriaInterface
{
    
    
    
    
    public function __construct()
    {
        
    }
    
    
    /**
      *  Check if the link exists on the whitelist
      *
      *  @access public
      *  @param ReviewToken $token 
      *  @return boolean 
      */
    public function makeVote(ReviewToken $token)
    {
        
        
    }
    
}
/* End of File */