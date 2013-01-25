<?php
namespace UrlShort\Decision;

/**
* Will Return an affirmative decision if the number of positive criteria exceeds the
* number of negative criteria or where the two are equal and positive criteria count is not
* 0. Other cases return a negative decision.
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 1.0.0
*/
class Consensus implements StrategyInterface
{
    
    public function decide(array $data)
    {
        $grant = 0;
        $deny = 0;
        $abstain = 0;
        foreach ($data as $vote) {
            
            switch ($vote) {
                case true:
                    ++$grant;

                    break;

                case false:
                    ++$deny;

                    break;

                default:
                    ++$abstain;

                    break;
            }
            
            
        }
        
        if ($grant > $deny) {
            return true;
        }

        if ($deny > $grant) {
            return false;
        }

        if ($grant == $deny && $grant != 0) {
            return true;
        }

        return false;
    
    }
    
    
}
/* End of File */