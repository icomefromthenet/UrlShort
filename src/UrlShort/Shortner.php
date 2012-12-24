<?php
namespace UrlShort;

use DateTime, Pimple;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use UrlShort\Event\UrlShortEvents,
    UrlShort\Event\UrlLookupEvent,
    UrlShort\Event\UrlStoreEvent,
    UrlShort\Event\UrlSpamCheckEvent,
    UrlShort\Event\UrlRemoveEvent,
    UrlShort\Event\UrlQueryEvent,
    UrlShort\Event\UrlPurgeEvent,
    UrlShort\Model\StoredUrl;


/**
  *  Url Shorten API
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */    
class Shortner extends Pimple
{
    
    /**
      *  @var  Symfony\Component\EventDispatcher\EventDispatcherInterface
      */
    protected $eventDispatcher;
    
    
    /**
      *  Class Constructor
      *
      *  @param EventDispatcherInterface $event
      */    
    public function __construct(EventDispatcherInterface $event)
    {
        $this->eventDispatcher = $event;
    }
    
        
    
    /**
      *  Find a url given the short code
      *
      *  @param string $key the short code
      *  @param boolen $notice if this from a redirect request or internal lookup
      *  @return \UrlShort\Model\Url | null;
      */
    public function lookup($key,$notice)
    {
        # validate the key and notice
        
        # create the event
        $event = new UrlLookupEvent($this,$key,$notice);
        
        # dispatch the event for processing
        $this->eventDispatcher->dispatch(UrlShortEvents::LOOKUP,$event);
        
        # return the result
        return $event->getResult();
    }
    
    /**
      *  Query to return a paged list of stored urls
      *
      *  @param integer $limit the database limit
      *  @param integer $offset the database offset
      *  @param string $order asc|desc
      *  @param DateTime $before
      *  @param DateTime $after
      *  @return Doctrine\Common\Collections\Collection
      */
    public function query($limit,$offset,$order ='ASC', DateTime $before = null, DateTime $after = null)
    {
        # validate the params
        
        # create the event
        $event = new UrlQueryEvent($this,$limit, $offset, $order, $before, $after);
        
        # dispatch the event for processing
        $this->eventDispatcher->dispatch(UrlShortEvents::QUERY,$event);
        
        # return the result
        return $event->getResult();
        
    }
    
    /**
      *  Remove a url using the shortcode
      *
      *  @access public
      *  @return boolean true if removed
      *  @param integer the database id
      *   
      */
    public function remove($id)
    {
        # validate the params
        
        # create the event
        $event = new UrlRemoveEvent($this,$id);
        
        # dispatch the event for processing
        $this->eventDispatcher->dispatch(UrlShortEvents::REMOVE,$event);
        
        # return the result
        return $event->getResult();
    }
    
    /**
      *   Purge old urls given a date
      *
      *   @access public
      *   @param DateTime $before
      *   @return integer number of rows purged
      */
    public function purge(DateTime $before)
    {
        # validate the params
        
        # create the event
        $event = new UrlPurgeEvent($this,$before);
        
        # dispatch the event for processing
        $this->eventDispatcher->dispatch(UrlShortEvents::PURGE,$event);
        
        # return the result
        return $event->getResult();
    }
    
    /**
      *   Short a new url
      *
      *   @access public
      *   @param string $url the full url
      *   @param DateTime $now the current time
      *   @return UrlShort\Model\Url
      */
    public function create($url,DateTime $now)
    {
        # validate the params
        
        
        # create model entity
        $entity             = new StoredUrl();
        $entity->longUrl    = $url;
        $entity->dateStored = $now;
        
        # run the spam check
        $spamEvent          = new UrlSpamCheckEvent($this,$entity);
        $this->eventDispatcher->dispatch(UrlShortEvents::SPAMCHECK,$spamEvent);
        
        if($spamEvent->getResult() === true) {
            throw new FailedSmapCheckException(sprintf('URL %s has failed SPAM check',$url));            
        }
        
        # create the event
        $storeEvent         = new UrlStoreEvent($this,$entity);
        
        # dispatch the event for processing
        $this->eventDispatcher->dispatch(UrlShortEvents::CREATE,$storeEvent);
        
        # return the result
        return $event->getResult();
    }
    
    
}
/* End of File */