<?php
namespace UrlShort\Decision;

/**
* Common interface for decision criteria.
*
* A criteria will make an evaluation and pass back yes/no answer
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 1.0.0
*/
interface CriteriaInterface
{
    
    /**
      *  Make an evaluation using the given data against an internal measure.
      *
      *  @access public
      *  @param ReviewToken $token
      *  @return boolean 
      */
    public function makeVote(ReviewToken $token);
    
    
}
/* End of File */