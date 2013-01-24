<?php
namespace ShortUrl\Decision;

/**
* Common interface for decision strategies.
*
* A decision will return yes/no using list of criteria results
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 1.0.0
*/
interface StrategyInterface
{
    /**
      *  Evaluate the criteria results and return boolean
      *
      *  @access public
      *  @return boolean
      *  @param array[boolean]
      */
    public function decide(array $data);
    
}
/* End of File */