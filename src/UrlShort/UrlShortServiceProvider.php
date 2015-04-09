<?php
namespace UrlShort;

use Silex\Application;
use Silex\ServiceProviderInterface;

class UrlShortServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        
        $app['urlshort.meta'] = $app->share(function() use ($app) {
           
            $table = new \DBALGateway\Metadata\Table($app['urlshort.tablename']);
        
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
            
            # tag relation
            $table->addColumn('tag_id','integer', array("unsigned" => true));
            
            # Review bool
            $table->addColumn('review_passed','boolean', array());
            
            # Review failure msg
            $table->addColumn('review_failure_msg','string', array());
            
            # Review Date
            $table->addColumn('review_date','datetime', array());
            
            return $table;
        });
        
        $app['urlshort.gateway'] = $app->share(function () use ($app) {
            
            $tableName = $app['urlshort.tablename'];
            $doctrine  = $app['db'];
            $event     = $app['dispatcher'];
            $meta      = $app['urlshort.meta'];
            $builder   = new \UrlShort\Model\UrlBuilder();
            
            return new \UrlShort\Model\UrlGateway($tableName,$doctrine,$event,$meta,null,$builder);    
        });
        
        $app['urlshort.mapper'] = $app->share(function() use ($app) {
           
           $event   = $app['dispatcher'];
           $gateway = $app['urlshort.gateway'];
           
           return new \UrlShort\Model\UrlMapper($event,$gateway);
        });
        
        $app['urlshort.generator'] = $app->share(function() use ($app) {
           $chars = "123456789bcdfghjkmnpqrstvwxyz";
           return new \UrlShort\ShortCodeGenerator($chars); 
        });
        
        $app['urlshort'] = $app->share(function() use ($app){
           
           $event      = $app['dispatcher'];
           $mapper     = $app['urlshort.mapper'];
           $generator  = $app['urlshort.generator'];
           
           return new \UrlShort\Shortner($event,$mapper,$generator);
            
        });
        
        
        $app['urlshort.approvalstatus.meta']  = $app->share(function() use ($app){
            
            $table = new \DBALGateway\Metadata\Table('status_codes');
        
            # setup primay key
            $table->addColumn('status_code','string',array('length'=> 4,'notnull' => true));
            $table->setPrimaryKey(array("url_id"));
            
            # setup unique short code index
            $table->addColumn('status_parent_code','string',array('length'=> 4,'notnull' => true));
            $table->addColumn('status_description','string',array('length'=> 100,'notnull' => false));
           
        });
        
        $app['urlshort.apporvalstatus.gateway'] = $app->share(function() use ($app){
            $doctrine  = $app['db'];
            $event     = $app['dispatcher'];
            $meta      = $app['urlshort.meta'];
            $builder   = new \UrlShort\Model\ApprovalStatusBuilder();
            $tableName = 'status_codes';
            
            return new \UrlShort\Model\ApprovalStatusGateway($tableName,$doctrine,$event,$meta,null,$builder);
           
        });
        
    }

    public function boot(Application $app)
    {
        
    }
   
    
}
/* End of File */