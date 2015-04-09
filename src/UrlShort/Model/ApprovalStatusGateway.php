<?php
namespace UrlShort\Model;

use DBALGateway\Table\AbstractTable;
use Doctrine\Common\Collections\Collection,
    Doctrine\Common\Collections\ArrayCollection;


/**
  *  Table Gateway for status code storage
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class ApprovalStatusGateway extends AbstractTable
{
    
    /**
      *  Return a new query builder
      *
      *  @return UrlShort\Model\UrlQuery
      *  @access public
      */
    public function newQueryBuilder()
    {
        return new ApprovalStatusQuery($this->getAdapater(),$this);
    }
    
    
    
}
/* End of File */