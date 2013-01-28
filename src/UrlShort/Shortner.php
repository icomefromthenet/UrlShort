<?php
namespace UrlShort;

use GSB_Client;
use DateTime;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use UrlShort\Event\UrlShortEvents,
    UrlShort\Event\UrlLookupEvent,
    UrlShort\Event\UrlStoreEvent,
    UrlShort\Event\UrlRemoveEvent,
    UrlShort\Event\UrlQueryEvent,
    UrlShort\Event\UrlPurgeEvent,
    UrlShort\Event\UrlReviewFailEvent,
    UrlShort\Event\UrlReviewPassEvent,
    UrlShort\Event\UrlShortEventsMap,
    UrlShort\Model\StoredUrl,
    UrlShort\Model\UrlMapper,
    UrlShort\Decision\BlacklistReview,
    UrlShort\Decision\WhitelistReview,
    UrlShort\Decision\ResolveReview,
    UrlShort\Decision\ReviewToken,
    UrlShort\Decision\DecisionResolver;
use Patchwork\Utf8;
use Pdp\DomainParser;



/**
  *  Url Shorten API
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */    
class Shortner
{
    
     
    /**
      *  @var  Symfony\Component\EventDispatcher\EventDispatcherInterface
      */
    protected $eventDispatcher;
    
    /**
      *  @var UrlShort\Model\UrlMapper
      */
    protected $mapper;
    
    /**
      *  @var  ShortCodeGenerator 
      */
    protected $shortCodeGenerator;
    
    /**
      *  Class Constructor
      *
      *  @param EventDispatcherInterface $event
      */    
    public function __construct(EventDispatcherInterface $event, UrlMapper $mapper, ShortGeneratorInterface $generator)
    {
        $this->eventDispatcher    = $event;
        $this->mapper             = $mapper;
        $this->shortCodeGenerator = $generator;
    }
        
    
    /**
      *  Find a url given the short code
      *
      *  @param string $key the short code
      *  @param boolen $notice if this from a redirect request or internal lookup
      *  @param boolean $reviewStatus
      *  @return \UrlShort\Model\Url | null;
      */
    public function lookup($key,$notice,$reviewStatus = true)
    {
        if(is_string($key)) {
            throw new UrlShortException('Lookup short must be a string');
        }
        
        if(is_bool($reviewStats) === false) {
            throw new UrlShortException('Review Status must be a boolean');
        }
        
        if(($url = $this->mapper->getByShortWithReview($key,$reviewStatus)) !== false) {
            
            # create the event
            $event = new UrlLookupEvent($url,$notice);
            $event->setResult(true);
        
            # dispatch the event for processing
            $this->eventDispatcher->dispatch(UrlShortEventsMap::LOOKUP,$event);
        }
        
        return $url;
    }
    
    /**
      *  Query to return a paged list of stored urls
      *
      * @access public
      * @return DBALGateway\Container\SelectContainer 
      */
    public function query()
    {
        return $this->mapper->find();        
    }
    
    /**
      *  Remove a url using the shortcode
      *
      *  @access public
      *  @return boolean true if removed
      *  @param integer the database id
      *   
      */
    public function remove(StoredUrl $url)
    {
        if($result = $this->mapper->remove($url) !== false) {

            $event = new UrlRemoveEvent($url);
            $event->setResult(true);
            
            $this->eventDispatcher->dispatch(UrlShortEventsMap::REMOVE,$event);
        }
        
        return $result;
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
        if($result = (integer)$this->mapper->purge($before) > 0) {
            $event = new UrlPurgeEvent($before);
            $event->setResult($result);
            
            $this->eventDispatcher->dispatch(UrlShortEventsMap::PURGE,$event);
        }
        
        return $result;
    }
    
    /**
      *   Short a new url
      *
      *   @access public
      *   @param string $url the full url
      *   @param DateTime $now the current time
      *   @param string $description a description of the url
      *   @param integer $tag_id optional id of a tag
      *   @return UrlShort\Model\Url
      */
    public function create($url,DateTime $now, $description = null, $tag_id = null)
    {
        $url         = (string) $url;
        $description = (string) $description;
        
        $maxUrlLength  = $this->mapper->getUrlMaxSize();
        $maxDescLength = $this->mapper->getDescriptionMaxSize();
        
        if(!Utf8::strlen($url) > 0 || Utf8::strlen($url) > $maxUrlLength) {
            throw new UrlShortException(sprintf('URL must be a string be between 0 and %s characters',$maxUrlLength));
        }
        
        if($tag_id !== null && is_int($tag_id) === false) {
            throw new UrlShortException(sprintf('Unable to store url given tag must be a integer given is a %s',gettype($tag_id)));
        }
        
        
        if(empty($description) || Utf8::strlen($description) > $maxDescLength ) {
            throw new UrlShortException(sprintf('Unable to store url description given must be between 0 and %s characters',$maxDescLength));
        }
        
        $entity              = new StoredUrl();
        $entity->longUrl     = $url;
        $entity->dateStored  = $now;
        $entity->tagId       = $tag_id;
        $entity->description = $description;
        
        if($this->mapper->save($entity) === true) {
            # set the shortcode and update db
            $entity->shortCode  = $this->shortCodeGenerator->convert($entity->tagId);    
            
            if($this->mapper->save($entity) === false) {
                throw new UrlShortException('Unable to complete saving the new url::'.$url);
            }
            
            $storeEvent  = new UrlStoreEvent($entity);
            $storeEvent->setResult(true);
            
            $this->eventDispatcher->dispatch(UrlShortEventsMap::CREATE,$storeEvent);
            
        } else {
            
            $entity = null;
        }
        
        return $entity;
    }
    
   
    /**
      *  Pick url's to check from the queue and execute spam check
      *
      *  @access public
      *  @param StoredUrl $url
      */    
    public function review(DomainParser $parser,DecisionResolver $resolver,StoredUrl $url,ResolveReview $resolverReview, BlacklistReview $blacklistReview, WhitelistReview $whitelistReview)
    {
       $success = false;
       
       # break the url into parts
       $parts = $parser->parse($url->longUrl);
       
       $token = new ReviewToken($url,$parts);

       # resolve the url       
       if($resolver->resolve($resolverReview,$token) === true) {
            
            $parts = 
            
            # on whitelist
            $token = new ReviewToken($url,$parts);
       
            if($resolver->resolve($whitelistReview,$token) === false) {
         
                # not on the white list last review check 
                $token = new ReviewToken($url,$parts);

                if($resolver->resolve($blacklistReview,$token) === false) {
                    # passed black list review.
                    $success = true;
                }
                
            } else {
                # on the white list accept url
                $success = true;                        
            }
       } 
       
       if($success == true) {
            $this->eventDispatcher->dispatch(UrlShortEventsMap::REVIEW_FAIL,new UrlReviewFailEvent($token));           
       } else {
            $this->eventDispatcher->dispatch(UrlShortEventsMap::REVIEW_PASS,new UrlReviewPassEvent($token));        
       }
       
       return $token;
        
    }
    
}
/* End of File */