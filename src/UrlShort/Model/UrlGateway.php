<?php
namespace UrlShort\Model;

use DBALGateway\Table\AbstractTable;

/**
  *  Table Gateway to the url storage
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class UrlGatewaty extends AbstractTable
{
    
    /**
      *  Return a new query builder
      *
      *  @return UrlShort\Model\UrlQuery
      *  @access public
      */
    public function newQueryBuilder()
    {
        return new UrlQuery($this);
    }
    
}
/* End of File */