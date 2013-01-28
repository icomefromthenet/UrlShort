<?php
namespace UrlShort\Decision\Criteria;

use UrlShort\Decision\CriteriaInterface;
use UrlShort\Decision\ReviewToken;
use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;

/**
* Check if a link exists
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 1.0.0
*/
class ResolveLinkCriteria implements CriteriaInterface
{
    
    /**
      *  Check if the link exists
      *
      *  @access public
      *  @param ReviewToken $token 
      *  @return boolean 
      */
    public function makeVote(ReviewToken $token)
    {
        try {    
        
            $client   = new Client($token->getStoredUrl()->longUrl);        
            $response = $client->get()->send();
            
        }  catch (BadResponseException $e) {
            # 4.x.x or 5.x.x http error cause the above exception
            $token->addReviewMessage('ResolveLinkCriteria','Link return 4.x.x or 5.x.x ok failed to resolve');
            return false;
        }
        
        $token->addReviewMessage('ResolveLinkCriteria','Link return 200 ok from Resolver');
        return true;
                
    }
    
}
/* End of File */