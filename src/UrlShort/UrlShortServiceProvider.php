<?php
namespace UrlShort;

use Silex\Application;
use Silex\ServiceProviderInterface;
use DBALGateway\Metadata\Table;

class UrlShortServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['hello'] = $app->protect(function ($name) use ($app) {
            $default = $app['hello.default_name'] ? $app['hello.default_name'] : '';
            $name = $name ?: $default;

            return 'Hello '.$app->escape($name);
        });
    }

    public function boot(Application $app)
    {
        
    }
    
    /**
      *  Return the metadata for the table gateway
      *
      *  @access public
      *  @return DBALGateway\Metadata\Table
      */
    public function getUrlTableMetadata($table_name)
    {
        $table = new DBALGateway\Metadata\Table($table_name);
        
        # setup primay key
        $table->addColumn('url_id','integer',array("unsigned" => true,'autoincrement' => true));
        $table->setPrimaryKey(array("url_id"));
        
        # setup unique short code index
        $table->addColumn('short_code','string',array('length'=> 6,'notnull' => false));
        $table->addIndex(array('short_code'));
        
        # setup the url storage
        $table->addColumn('long_url','string',array('length'=> 255,'notnull' => false));
        
        # column date created
        $table->addColumn('date_created','datetime',array('notnull' => true));
        
        # Optional description message
        $table->addColumn('description_msg','string',array('length' => 200,'notnull'=> false));
        
        
        return $table;
        
    }
    
}
/* End of File */