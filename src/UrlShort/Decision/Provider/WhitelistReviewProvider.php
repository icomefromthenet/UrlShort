<?php
namespace UrlShort\Decision\Provider;

use Silex\ServiceProviderInterface;
use Silex\Application;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Resource\FileResource;


use UrlShort\Whitelist\WhitelistResourceLoader;
use UrlShort\Decision\WhitelistReview;
use UrlShort\Decision\Criteria\WhitelistApprovalCriteria;
use UrlShort\Decision\Unanimous;

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
       
       if(isset($app['urlshort.review.whitelist.path']) == false) {
        $app['urlshort.review.whitelist.path'] = $app['resources_path'] . 'whitelist';
       }
       
       if(isset($app['urlshort.review.whitelist.criteria']) === false) {
            $app['urlshort.review.whitelist.criteria'] = $app->share(function() use ($app) {
                return array( new WhitelistApprovalCriteria($app['urlshort.review.whitelist.config']));   
            });
        } 
       
        if(isset($app['urlshort.review.whitelist.decision']) === false) {
            $app['urlshort.review.whitelist.decision'] = $app->share(function() use ($app)  {
                return new Unanimous();
            });
        }
        
        
        $app['urlshort.review.whitelist'] = $app->share(function() use ($app){
            return new WhitelistReview($app['urlshort.review.whitelist.criteria'],$app['urlshort.review.whitelist.decision']);
        });
        
        
        $app['urlshort.review.whitelist.config'] = $app->share(function() use ($app) {
             $loader = new WhitelistResourceLoader(new FileLocator(array($app['urlshort.review.whitelist.path'])));
             return $loader->import('whitelist.php','php');
        });
        
    }
    
    
    public function boot(Application $app)
    {
        
    }
    
    
}
/* End of File */