<?php 
namespace UrlShort\Model;

use DBALGateway\Builder\BuilderInterface;

/**
 * Convert database to entity and back
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 0.0.1
 */ 
class ApprovalStatusBuilder implements BuilderInterface 
{
      /**
      *  Convert data array into entity
      *
      *  @return mixed
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        return new ApprovalStatus($data['status_code'],$data['status_description'],$data['status_parent_code']);
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      */
    public function demolish(ApprovalStatus $entity)
    {
        return array(
            'status_code'        => $entity->getCode(),
            'status_description' => $entity->getDescription(),
            'status_parent_code' => $entity->getParentCode()
            
        );
        
    }
    
}
/* End of Class */
