<?php
namespace UrlShort\Decision;

/**
* Will return a affirmative decision on the first criteria that reports true
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 1.0.0
*/
class Affirmative implements StrategyInterface
{
    
    public function decide(array $data)
    {
        $deny = 0;
        foreach ($data as $vote) {
            switch ($vote) {
                case true:
                    return true;

                case false:
                    ++$deny;

                    break;

                default:
                    break;
            }
        }

        if ($deny > 0) {
            return false;
        }
    }
    
    
}
/* End of File */