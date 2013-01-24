<?php
namespace UrlShort\Decision;


/**
* Will return a negative decision if one of the criteria returns negative result.
* All criteria will need to return positive if an affirmative decision to be
* reached.
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 1.0.0
*/
class Unanimous implements StrategyInterface
{
    
    public function decide(array $data)
    {
        $grant = 0;
        foreach ($data as $vote) {

                switch ($vote) {
                    case true:
                        ++$grant;

                        break;

                    case false:
                        return false;

                    default:
                        break;
                }
        }
        
        // no deny votes
        if ($grant > 0) {
            return true;
        }

        return false;
    }
    
    
}
/* End of File */