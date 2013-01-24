<?php
namespace UrlShort\Decision\Provider;

use Silex\ServiceProviderInterface;
use Silex\Application;
use UrlShort\Decision\ResolveReview;

/**
* Provides default setup and extension hooks for ResolveReview 
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 1.0.0
*/
class ResolveReviewProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
      
       if(isset($app['urlshort.review.resolve.criteria']) === false) {
            $app['urlshort.review.resolve.criteria'] = $app->share(function() use ($app) {
                    
            });
        } 
       
        if(isset($app['urlshort.review.resolve.decision']) === false) {
            $app['urlshort.review.resolve.decision'] = $app->share(function() use ($app)  {
                return new UrlShort\Decision\Unanimous();
            });
        }
        
        
        $app['urlshort.review.resolve'] = $app->share(function() use ($app){
            return new Review($app['urlshort.review.resolve.decision'],
                              $app['urlshort.review.resolve.criteria']);
        });
        
    }
    
    
    public function boot(Application $app)
    {
        
    }
    
    
}
/* End of File */