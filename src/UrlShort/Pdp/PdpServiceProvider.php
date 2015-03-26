<?php
namespace UrlShort\Pdp;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Pdp\Parser;
use Pdp\PublicSuffixListManager;
use UrlShort\UrlShortException;

class PdpServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        if(isset($app['pdp.cachedir']) === false) {
            $app['pdp.cachedir'] = $app['resources_path'] . 'psl';
        }
        
        
        $app['pdb.listmanager'] = $app->share(function() use ($app){
            if(is_dir($app['pdp.cachedir']) === false) {
                throw new UrlShortException('Pdp the cache directory does not exist or not writable');
            }
            
            return new PublicSuffixListManager($app['pdp.cachedir']);
        });
        
        
        $app['pdb.parser'] = $app->share(function() use ($app){
            return new Parser($app['pdb.listmanager']->getList());
        });
        
    }
    
    
    public function boot(Application $app)
    {
        
    }
}
/* End of File */