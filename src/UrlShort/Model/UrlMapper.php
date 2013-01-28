<?php
namespace UrlShort\Model;

use DateTime;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use DBALGateway\Exception as DBALGatewayException;
use UrlShort\UrlShortException;

class UrlMapper
{
    
    /**
      * @var UrlShort\Model\UrlGateway
      */
    protected $gateway;
    
    /**
      *  @var Symfony\Component\EventDispatcher\EventDispatcherInterface  
      */
    protected $event;
    
    /**
      *  Class Constructor
      *
      *  @access public
      *  @param EventDispatcherInterface $event
      *  @param UrlGateway $gateway
      */
    public function __construct(EventDispatcherInterface $event, UrlGateway $gateway)
    {
        $this->gateway = $gateway;
        $this->event   = $event;
    }
    
    /**
      *  Return a url
      *
      *  @param integer $url_id
      *  @return UrlShort\Model\StoredUrl or null none found
      */
    public function getById($url_id)
    {
        if(is_int($url_id) === false) {
            throw new UrlShortException(sprintf('Can not lookup Url %s is a %s must be and integer',$url_id,gettype($url_id)));
        }
        
        try {
        
            return $this->gateway->selectQuery()
                        ->start()
                            ->filterById($url_id)
                        ->end()
                    ->findOne();
                
        }
        catch(DBALGatewayException $e) {
            throw new UrlShortException($e->getMessage(),0,$e);
        }
    }
    
     /**
      *  Search for a url given short code and restrict to sucessful/failed reviews
      *
      *  @access public
      *  @return UrlShort\Model\StoredUrl or null none found
      *  @param string $code the shortcode
      */
    public function getByShort($code)
    {
        try {
        
            return $this->gateway->selectQuery()
                        ->start()
                            ->filterByShortCode($code)
                        ->end()
                    ->findOne();
                
        }
        catch(DBALGatewayException $e) {
            throw new UrlShortException($e->getMessage(),0,$e);
        }
        
    }

    
    /**
      *  Search for a url given short code and restrict to sucessful/failed reviews
      *
      *  @access public
      *  @return UrlShort\Model\StoredUrl or null none found
      *  @param string $code the shortcode
      *  @param boolean $reviewStatus the state of the review
      */
    public function getByShortWithReview($code,$reviewStatus)
    {
        try {
        
            $query = $this->gateway->selectQuery()
                        ->start()
                            ->filterByShortCode($code);
            
            if($reviewStatus === true) {
                $query->filterBySuccessfulReview();                            
            } else {
                $query->filterByFailedReview();                            
            }
                        
            return $query->end()->findOne();
                
        }
        catch(DBALGatewayException $e) {
            throw new UrlShortException($e->getMessage(),0,$e);
        }
        
    }

    /**
      *  Save the changes to database
      *
      *  @access public
      *  @param StoredUrl $url
      *  @return boolean
      */
    public function save(StoredUrl $url)
    {
        $result = false;
        
        try {
        
            if($url->urlId === null) {
                # create only save subset of info
                $result = $this->gateway->insertQuery()
                        ->start()
                            ->addColumn('long_url',$url->longUrl)
                            ->addColumn('date_created',$url->dateStored)
                            ->addColumn('description_msg',$url->description)
                            ->addColumn('tag_id',$url->tagId)
                        ->end()
                    ->insert();
                
               if($result === true) {
                    $url->urlId = $this->gateway->lastInsertId();
               }
                
            }
            else {
                # update
                $result = $this->gateway->updateQuery()
                               ->start()
                                ->addColumn('long_url',$url->longUrl)
                                ->addColumn('date_created',$url->dateStored)
                                ->addColumn('description_msg',$url->description)
                                ->addColumn('tag_id',$url->tagId)
                                ->addColumn('short_code',$url->shortCode)
                                ->addColumn('review_passed',$url->reviewPassed)
                                ->addColumn('review_failure_msg',$url->reviewFailureMessage)
                                ->addColumn('review_date',$url->reviewDate)
                               ->where()
                                 ->filterById($url->urlId)
                               ->end()
                           ->update();
            }
                    
        }
        catch(DBALGatewayException $e) {
            throw new UrlShortException($e->getMessage(),0,$e);
        }
        
        return $result;
        
    }
    
    /**
      *  Remove the Url
      *
      *  @param StoredUrl $url
      *  @return boolean
      */
    public function remove(StoredUrl $url)
    {
        if($url->urlId === null) {
            throw new UrlShortException('Can not remove Url NULL is not a valid Id');
        }
        
        try {
        
           $result =  $this->gateway->deleteQuery()   
                        ->start()
                            ->filterById($url->urlId)
                        ->end()
                    ->delete();
                    
        }
        catch(DBALGatewayException $e) {
            throw new UrlShortException($e->getMessage(),0,$e);
        }
        
        return $result;
    }
    

    /**
      *  Purge urls created before date
      *
      *  @access public
      *  @param DateTime $before 
      *  @return integer number of url's removed
      */
    public function purge(DateTime $before)
    {
        try {
        
            $result = $this->gateway->deleteQuery()   
                        ->start()
                            ->filterByAddedBefore($before)
                        ->end()
                    ->delete();
            $result = $this->gateway->rowsAffected();        
                    
        }
        catch(DBALGatewayException $e) {
            throw new UrlShortException($e->getMessage(),0,$e);
        }
        
        return $result;
        
    }
    
    /**
      *  Allows a select query to be run
      *
      *  @return DBALGateway\Container\SelectContainer
      *  @access public
      */
    public function find()
    {
        return $this->gateway->selectQuery();        
    }
    
    
    /**
      *  Return the url max size
      *
      *  @access public
      *  @return false
      */
    public function getUrlMaxSize()
    {
        return $this->gateway->getMetaData()->getColumn('long_url')->getLength();
    }
    
    
    /**
      *  Return the description max size
      *
      *  @access public
      *  @return false
      */
    public function getDescriptionMaxSize()
    {
        return $this->gateway->getMetaData()->getColumn('description_msg')->getLength();        
    }
    
}
/* End of File */