<?php
namespace UrlShort\Model;

use DateTime;
use DBALGateway\Query\AbstractQuery;
use UrlShort\UrlShortException;

/**
  *  Query Builder for Url Storage
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class UrlQuery extends AbstractQuery
{
    
    /**
      *  Filter for the database uuid
      *
      *  @access public
      *  @return UrlQuery
      *  @param string $id of the worker
      */
    public function filterById($id)
    {
        $this->where($this->expr()->eq('url_id',':url_id'))->setParameter('url_id',$id,$this->getGateway()->getMetaData()->getColumn('url_id')->getType());
        
        return $this;
    }
    
    /**
      *  Filter for the unique short code
      *
      *  @access public
      *  @return UrlQuery
      *  @param string $id of the worker
      */
    public function filterByShortCode($code)
    {
        $this->where($this->expr()->eq('short_code',':short_code'))->setParameter('short_code',$code,$this->getGateway()->getMetaData()->getColumn('short_code')->getType());
        
        return $this;
    }
        
    
    /**
    * Filter urls added after x
    *
    * @access public
    * @return UrlQuery
    * @param DateTime $time
    */
    public function filterByAddedAfter(DateTime $time)
    {
        $this->andWhere($this->expr()->gte('date_created',':date_created_after'))->setParameter('date_created_after',$time,$this->getGateway()->getMetaData()->getColumn('date_created')->getType());
        
        return $this;
    }
    
    /**
    * Filter urls added before x
    *
    * @access public
    * @return UrlQuery
    * @param DateTime $time
    */
    public function filterByAddedBefore(DateTime $time)
    {
        $this->andWhere($this->expr()->lte('date_created',':date_created_before'))->setParameter('date_created_before',$time,$this->getGateway()->getMetaData()->getColumn('date_created')->getType());
        
        return $this;
    }
    
    
    /**
    * Filter urls where review was successful
    *
    * @access public
    * @return UrlQuery
    */
    public function filterBySuccessfulReview()
    {
        $this->andWhere($this->expr()->eq('review_passed',':review_passed_success'))->setParameter('review_passed_success',true,$this->getGateway()->getMetaData()->getColumn('review_passed')->getType());
                
        return $this;
    }
    
    
    /**
    * Filter urls where review has failed
    *
    * @access public
    * @return UrlQuery
    */
    public function filterByFailedReview()
    {
        $this->andWhere($this->expr()->eq('review_passed',':review_passed_failed'))->setParameter('review_passed_failed',false,$this->getGateway()->getMetaData()->getColumn('review_passed')->getType());
        
        return $this;
    }
    
    /**
    * Filter urls that not been reviewed
    *
    * @access public
    * @return UrlQuery
    */
    public function filterByNotReviewed()
    {
        $this->andWhere($this->expr()->isNull('review_passed'));
        
        return $this;
    }
    
    /**
    * Filter urls where a review has been done
    *
    * @access public
    * @return UrlQuery
    */
    public function filterByReviewed()
    {
        $this->andWhere($this->expr()->isNotNull('review_passed'));
        
        return $this;
    }
    
    /**
    * Filter urls where review was conducted before
    *
    * @access public
    * @return UrlQuery
    * @param DateTime $before
    */
    public function filterByReviewDateBefore(DateTime $before)
    {
        $this->andWhere($this->expr()->lte('review_date',':review_date_before'))->setParameter('review_date_before',$before,$this->getGateway()->getMetaData()->getColumn('review_date')->getType());
      
        return $this;
    }
    
    /**
    * Filter urls where review was conducted after
    *
    * @access public
    * @return UrlQuery
    * @param DateTime $before
    */
    public function filterByReviewDateAfter(DateTime $after)
    {
        $this->andWhere($this->expr()->gte('review_date',':review_date_after'))->setParameter('review_date_after',$after,$this->getGateway()->getMetaData()->getColumn('review_date')->getType());
        
        return $this;
    }
    
    
        
    /**
    * Filter urls when review was conducted
    *
    * @access public
    * @return UrlQuery
    * @param DateTime $before
    */
    public function orderbyReviewDate($dir = 'ASC')
    {
        $this->orderBy('review_date',$dir);
        
        return $this;    
    }
    
    /**
    * Filter urls by date they added
    *
    * @access public
    * @return UrlQuery
    * @param DateTime $before
    */
    public function orderByAddedDate($dir)
    {
        $this->orderBy('date_created',$dir);
        
        return $this;
    }
    
  
    
    
}
/* End of File */