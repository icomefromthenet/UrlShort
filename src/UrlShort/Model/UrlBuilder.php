<?php
namespace UrlShort\Model;

use DBALGateway\Builder\BuilderInterface;

/**
  *  Builder to convert database entity to domain StoredUrl entity
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
class UrlBuilder implements BuilderInterface
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
        $entity = new StoredUrl();
        
        $entity->dateStored  = $data['date_created'];
        $entity->urlId       = $data['url_id'];
        $entity->shortCode   = $data['short_code'];
        $entity->description = $data['description_msg'];
        $entity->longUrl     = $data['long_ur'];
        
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      */
    public function demolish($entity)
    {
        return array(
          'url_id'          => $entity->urlId,
          'short_code'      => $entity->shortCode,
          'long_url'        => $entity->longUrl,
          'date_created'    => $entity->dateStored,
          'description_msg' => $entity->description,
        );
    }
    
}
/* End of File */