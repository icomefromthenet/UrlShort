<?php
namespace UrlShort\Decision\Provider;

use Silex\ServiceProviderInterface;
use Silex\Application;
use UrlShort\Decision\BlacklistReview;

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
                    
            });
        } 
       
        if(isset($app['urlshort.review.blacklist.decision']) === false) {
            $app['urlshort.review.blacklist.decision'] = $app->share(function() use ($app)  {
                return new UrlShort\Decision\Unanimous();
            });
        }
        
        
        $app['urlshort.review.blacklist'] = $app->share(function() use ($app){
            return new BlacklistReview($app['urlshort.review.blacklist.decision'],
                                       $app['urlshort.review.blacklist.criteria']);
        });
        
    }
    
    
    public function boot(Application $app)
    {
        
    }
    
    
}
/* End of File */