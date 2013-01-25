<?php
namespace UrlShort\Decision\Provider;

use Silex\ServiceProviderInterface;
use Silex\Application;
use UrlShort\Decision\BlacklistReview;
use UrlShort\UrlShortException;
use UrlShort\Decision\Criteria\GSBCriteria;

/**
* Provides default setup and extension hooks for BlacklistReview 
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 1.0.0
*/
class BlacklistReviewProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
      
       if(isset($app['urlshort.review.blacklist.criteria']) === false) {
            $app['urlshort.review.blacklist.criteria'] = $app->share(function() use ($app) {
                
                # test if gsb client extension installed
                if(isset($app['gsb.client']) == false) {
                    throw new \UrlShort\UrlShortException('GSB Client Service not found at index gsb.client');
                }
                
                return array(
                    new GSBCriteria($app['gsb.client'])
                );
            });
        } 
       
        if(isset($app['urlshort.review.blacklist.decision']) === false) {
            $app['urlshort.review.blacklist.decision'] = $app->share(function() use ($app)  {
                return new \UrlShort\Decision\Unanimous();
            });
        }
        
        
        $app['urlshort.review.blacklist'] = $app->share(function() use ($app){
            return new BlacklistReview($app['urlshort.review.blacklist.criteria'],$app['urlshort.review.blacklist.decision']);
        });
        
    }
    
    
    public function boot(Application $app)
    {
        
    }
        
}
/* End of File */