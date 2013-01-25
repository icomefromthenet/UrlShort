<?php
namespace UrlShort\Decision\Provider;

use Silex\ServiceProviderInterface;
use Silex\Application;
use UrlShort\Decision\ResolveReview;
use UrlShort\Decision\Criteria\ResolveLinkCriteria;
use UrlShort\Decision\Unanimous;

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
                return  array(
                    new ResolveLinkCriteria()
                );
            });
        } 
       
        if(isset($app['urlshort.review.resolve.decision']) === false) {
            $app['urlshort.review.resolve.decision'] = $app->share(function() use ($app)  {
                return new Unanimous();
            });
        }
        
        
        $app['urlshort.review.resolve'] = $app->share(function() use ($app){
            return new ResolveReview($app['urlshort.review.resolve.criteria'],$app['urlshort.review.resolve.decision']);
        });
        
    }
    
    
    public function boot(Application $app)
    {
        
    }
    
    
}
/* End of File */