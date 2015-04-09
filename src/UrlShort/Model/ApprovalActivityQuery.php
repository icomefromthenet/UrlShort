<?php
namespace UrlShort\Model;

use DateTime;
use UrlShort\UrlShortException;
use DBALGateway\Query\AbstractQuery;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
  *  Query builder for Approval Status
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class ApprovalActivityQuery extends AbstractQuery
{

    /**
     * Filter the list by a url reference
     * 
     * @param integer $urlId    the url to filter on
     */ 
    public function filterByUrl($urlId) 
    {
        if(is_init($urlId) && $urlId <= 0) {
            throw new UrlShortException('Param urlID must be gt 0 ');
        }
        
        $this->where('url_id = :url_id')
             ->setParameter('url_id'
                            , $urlId
                            , $this->getGateway()->getMetaData()->getColumn('url_id')->getType());


        return $this;
        
    }
    
    /**
     * Filter the list to changes before X
     * 
     * @var DateTime    $after
     * @return ApprovalActivityQuery
     */ 
    public function filterBeforeDate(DateTime $before)
    {
        $this->where('change_dte = :change_dte_before')
             ->setParameter('change_dte_before'
                            , $before
                            , $this->getGateway()->getMetaData()->getColumn('change_dte')->getType());

     
        return $this;   
    }
    
    /**
     * Filter the list to changes after X
     * 
     * @var DateTime    $after
     * @return ApprovalActivityQuery
     */ 
    public function filterAfterDate(DateTime $after)
    {
        $this->where('change_dte = :change_dte_after')
             ->setParameter('change_dte_after'
                            , $after
                            , $this->getGateway()->getMetaData()->getColumn('change_dte')->getType());


        return $this;
    }
    
    /**
     * Filter the list to a set of status codes
     * 
     * @var array of ApprovalStatus codes
     * @return ApprovalActivityQuery
     */ 
    public function filterStatusBy(array $codes)
    {
        $codes = array();
        
        if(count($codes) == 0) {
            throw new UrlShortException('Status codes filter must have at least 1 code to filter on');
        }
        
        foreach($codes as $c) {
            if($c instanceof ApprovalStatus) {
                $codes[] = $c->getCode();
            } else {
                throw new UrlShortException('Status codes must be an instance of ApprovalStatus');
            }
        }
   
        $this->where('status IN ('.implode(',',$codes) .')');
        
        return $this;
    }
    
    
    /**
     * Filter the list to a set of sub status codes
     * 
     * @var array of ApprovalStatus codes
     * @return ApprovalActivityQuery
     */ 
    public function filterSubStatusBy(array $codes) 
    {
        $codes = array();
        
        if(count($codes) == 0) {
            throw new UrlShortException('Status codes filter must have at least 1 code to filter on');
        }
        
        foreach($codes as $c) {
            if($c instanceof ApprovalStatus) {
                $codes[] = $c->getCode();
            } else {
                throw new UrlShortException('Status codes must be an instance of ApprovalStatus');
            }
        }
   
        $this->where('sub_status IN ('.implode(',',$codes).')');
        
        return $this;
    }
    
    public function filerUser(AdvancedUserInterface $user)
    {
        $id = $user->getId();
    
        if(true === empty($id)) {
            throw new UrlShortException('User id must not be empty');
        }
        
        $this->where('user_id = :user_id')
             ->setParameter('user_id'
                            , $id
                            , $this->getGateway()->getMetaData()->getColumn('user_id')->getType());
      
        return $this;
    }
}
/* End of Class */