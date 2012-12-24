<?php
namespace UrlShort\Model;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use DBALGateway\Exception as DBALGatewayException;
use UrlShort\UrlShortException;
use UrlShort\Event\UrlShortEvents;
//use UrlShort\Event\


/**
* Handle events found in UrlShort\Event\UrlShortEvents
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 0.0.1
*/
class EventSubscriber implements EventSubscriberInterface
{
    
    /**
    * Bind event handlers to the dispatcher
    *
    * @access public
    * @static
    * @return array a binding to event handlers
    */
    static public function getSubscribedEvents()
    {
        return array(
            JobEventsMap::STATE_START => array('onJobStart'),
            JobEventsMap::STATE_FAIL => array('onJobFail'),
            JobEventsMap::STATE_ERROR => array('onJobError'),
            JobEventsMap::STATE_FINISH => array('onJobFinish'),
        );
    }

    
    
        
}
/* End of File */