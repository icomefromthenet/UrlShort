<?php
namespace UrlShort\Decision\Criteria;

use UrlShort\Decision\CriteriaInterface;
use UrlShort\Decision\ReviewToken;
use GSB_Client;

/**
* Check if a on the GSB Blacklist
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 1.0.0
*/
class GSBCriteria implements CriteriaInterface
{
    
    /**
      *  @var GSB_Client the gsb client 
      */
    protected $client;
    
    
    
    public function __construct(GSB_Client $client)
    {
        $this->client = $client;
    }
    
    
    /**
      *  Check if the link exists on the blacklist
      *
      *  @access public
      *  @param ReviewToken $token 
      *  @return boolean true if on the list
      */
    public function makeVote(ReviewToken $token)
    {
        $onList = false;
        $result = $this->client->doLookup($token->getStoredUrl()->longUrl);        
        
        if(count($result) > 0) {
            $onList = true;
            $token->addReviewMessage('GSBCriteria','Link found on Google Safer Browser Blacklist on list '.$result[0]['listname']);    
        } else {
            $token->addReviewMessage('GSBCriteria','Link NOT found on Google Safer Browser Blacklist');    
        }
        
        return $onList;            
    }
    
}
/* End of File */