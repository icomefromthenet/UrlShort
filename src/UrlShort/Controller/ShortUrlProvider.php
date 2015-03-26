<?php
namespace UrlShort\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class ShortUrlProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers->get('/urls/{id}', array($this,'getUrlAction'))->assert('id', '\d+');
        $controllers->get('/urls', array($this,'queryUrlAction'));
        $controllers->post('/urls', array($this,'postUrlAction'));
        $controllers->delete('/urls/{id}', array($this,'deleteUrlAction'))->assert('id', '\d+');
        

        return $controllers;
    }
    
    
    
    public function getUrlAction(Application $app, Request $request,$id)
    {
        $code = 200;
        $data = array('msg' => null, 'result' => null);
        
        
                
        
        return $app->json($data,$code);
        
    }
    
    
    public function postUrlAction(Application $app, Request $request)
    {
        $code = 200;
        $data = array('msg' => null, 'result' => null);
        
        
                
        
        return $app->json($data,$code);
        
    }
    
    
    public function deleteUrlAction(Application $app, Request $request,$id)
    {
        $code = 200;
        $data = array('msg' => null, 'result' => null);
        
        
                
        
        return $app->json($data,$code);
        
    }
    
    
    public function queryUrlAction(Application $app, Request $request)
    {
        $code = 200;
        $data = array('msg' => null, 'result' => null);
        
        
                
        
        return $app->json($data,$code);
        
    }
    
}
/* End of File */