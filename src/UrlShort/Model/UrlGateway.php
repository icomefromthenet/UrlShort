<?php
namespace UrlShort\Model;

use DBALGateway\Table\AbstractTable;
use Doctrine\Common\Collections\Collection,
    Doctrine\Common\Collections\ArrayCollection;
use UrlShort\Event\UrlLookupEvent;
use UrlShort\Event\UrlQueryEvent;
use UrlShort\Event\UrlShortEventsMap;
    
/**
  *  Table Gateway to the url storage
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class UrlGateway extends AbstractTable
{
    
    /**
      *  Return a new query builder
      *
      *  @return UrlShort\Model\UrlQuery
      *  @access public
      */
    public function newQueryBuilder()
    {
        return new UrlQuery($this->getAdapater(),$this);
    }
    
    
    public function find()
    {
        $result = parent::find();
        
        $this->event_dispatcher->dispatch(UrlShortEventsMap::QUERY,new UrlQueryEvent($result));
        
        return $result;
    }
    
}
/* End of File */