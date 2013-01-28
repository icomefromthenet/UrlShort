<?php
namespace UrlShort\Decision\Criteria;

use UrlShort\Decision\CriteriaInterface;
use UrlShort\Decision\ReviewToken;
use UrlShort\Whitelist\RegexCollection;

/**
* Check if a on the whitelist
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 1.0.0
*/
class WhitelistApprovalCriteria implements CriteriaInterface
{
    
    protected $regexCollection;
    
    
    public function __construct(RegexCollection $regexCollection)
    {
        $this->regexCollection = $regexCollection;
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
        $result             = false;
        $registerableDomain = $token->getUrlParts()->getRegisterableDomain();
        
        # any of the whitelist regex's match current url
        $matches            = $this->regexCollection->regexMatchUrl($registerableDomain);
        
        if(count($matches) > 0) {
            $token->addReviewMessage('WhitelistApprovalCriteria','Match found on whitelist regexs '. implode(',',$matches->toArray()));
            $result = true;
        } else {
            $token->addReviewMessage('WhitelistApprovalCriteria','NO Matches found on whitelist');
        }
        
        return $result;
        
    }
    
}
/* End of File */