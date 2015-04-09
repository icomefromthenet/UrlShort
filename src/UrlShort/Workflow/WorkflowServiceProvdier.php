<?php
namespace UrlShort\Workflow;

use Silex\Application;
use Silex\ServiceProviderInterface;

class UrlShortServiceProvider implements ServiceProviderInterface
{
    
    
    public function register(Application $app)
    {
        $app['urlshort.workflow.process.approval']    = $this->share(function($app){
           return new ApprovalProcess(); 
        });
        
        $app['urlshort.workflow.process.billing']    = $this->share(function($app){
           return new BillingProcess();
        });
        
    }
    
    
    public function boot(Application $app)
    {
        
    }   
    
}
/* End of Class */