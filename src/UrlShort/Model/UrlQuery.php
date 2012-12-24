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
    
}
/* End of File */