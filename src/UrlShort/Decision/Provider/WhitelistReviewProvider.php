<?php
namespace UrlShort\Decision\Provider;

use Silex\ServiceProviderInterface;
use Silex\Application;
use UrlShort\Decision\WhitelistReview;

/**
* Provides default setup and extension hooks for WhitelistReview 
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 1.0.0
*/
class WhitelistReviewProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
      
       if(isset($app['urlshort.review.whitelist.criteria']) === false) {
            $app['urlshort.review.whitelist.criteria'] = $app->share(function() use ($app) {
                    
            });
        } 
       
        if(isset($app['urlshort.review.whitelist.decision']) === false) {
            $app['urlshort.review.whitelist.decision'] = $app->share(function() use ($app)  {
                return new UrlShort\Decision\Unanimous();
            });
        }
        
        
        $app['urlshort.review.whitelist'] = $app->share(function() use ($app){
            return new WhitelistReview($app['urlshort.review.whitelist.decision'],
                                       $app['urlshort.review.whitelist.criteria']);
        });
        
    }
    
    
    public function boot(Application $app)
    {
        
    }
    
    
}
/* End of File */