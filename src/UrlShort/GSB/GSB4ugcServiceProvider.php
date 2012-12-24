<?php
namespace UrlShort\GSB;

use GSB_Exception;
use Silex\Application;
use Silex\ServiceProviderInterface;

class GSB4ugcServiceProvider implements ServiceProviderInterface
{
    const INDEX   = 'gsb';
    
    const REQUEST = 'gsb.request';
    
    const STORAGE = 'gsb.storage';
    
    const LOGGER  = 'gsb.logger';
    
    const CLIENT  = 'gsb.client';
    
    const UPDATER = 'gsb.updater';
    
    const APIKEY  = 'gsb.api.key';
    
    const LISTS   = 'gsb.api.lists';
    
    
    /**
      *  Register the dependecies with the container
      *
      *  @access public
      *  @param Application $app
      */
    public function register(Application $app)
    {
        
        if(isset($app[self::LISTS]) === false) {
            $app[self::LISTS] = array('goog-malware-shavar', 'googpub-phish-shavar');
        } 
        
        if(isset($app[self::STORAGE]) === false) {
            
            $app[self::STORAGE] = $app->share(function() use($app) {
                $pdo = $app['db']->getWrappedConnection();
                return new \GSB_Storage($pdo);
            });
        }
        
                    
        if(isset($app[self::REQUEST]) === false) {
            
            $app[self::REQUEST] = $app->share(function() use($app) {
                return new \GSB_Request($app['gsb.api.key']);
            });
        }

        
        if(isset($app[self::LOGGER]) === false) {
            
            $app[self::LOGGER] = $app->share(function() use($app) {
                return new \UrlShort\GSB\GSBLogBridge($app['monolog']);
            });
        }
        
        if(isset($app[self::UPDATER]) === false) {
            
            $app[self::UPDATER] = $app->share(function() use($app) {
                return new \GSB_Updater($app['gsb.storage'], $app['gsb.request'], $app['gsb.logger']);
            });
        }
        
        if(isset($app[self::CLIENT]) === false) {
            
            $app[self::CLIENT] = $app->share(function() use($app) {
                return new \GSB_Client($app['gsb.storage'], $app['gsb.request'], $app['gsb.logger']);
            });
        }
        

    }

    public function boot(Application $app)
    {
        if(isset($app[self::APIKEY]) === false) {
            throw new GSB_Exception(sprintf('API Key not found in DI Container index %s ',self::APIKEY));
        }
    }

}    
/* End of File */