<?php
namespace UrlShort\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminActionsProvider implements ControllerProviderInterface 
{
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers->get('/', array($this,'defaultAdminAction'))->bind('home');
        $controllers->get('/queue',array($this,'queueAdminAction'))->bind('qcontrol');

        return $controllers;
    }
    
    
    public function defaultAdminAction(Application $app,Request $req)
    {
        return $app['twig']->render('home.html.twig', array(
        
        ));
        
    }
    
    public function queueAdminAction(Application $app,Request $req)
    {
        return $app['twig']->render('queue.html.twig', array(
        
        ));
        
    }
    
}
/* End of Class */

