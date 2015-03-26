<?php
namespace UrlShort\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GlobalActionsProvider implements ControllerProviderInterface 
{
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

    
        $controllers->get('/', array($this,'defaultRouteAction'));
        

        return $controllers;
    }


    public function defaultRouteAction(Application $app,Request $req) 
    {
        return $app->redirect('/admin',302);
    }
    
    
}
/* End of Class */

