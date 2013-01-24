<?php
namespace UrlShort\Test;

use DateTime;
use Silex\WebTestCase;
use UrlShort\Decision\DecisionResolver;


class DecisionResolverTest extends WebTestCase
{
    
    /**
    * Creates the application.
    *
    * @return HttpKernel
    */
    public function createApplication()
    {
        $app = require __DIR__ .'/../../../app.php';
        
        $app->boot();
        
        return $app;
    }
    
    
    
    
    public function testResolver()
    {
        $url   = new \stdClass();
        $url->longUrl = 'www.google.com'; 
        
        $token = $this->getMockBuilder('UrlShort\Decision\ReviewToken')->disableOriginalConstructor()->getMock();
        $token->expects($this->once())
              ->method('getStoredUrl')
              ->will($this->returnValue($url));
        
        $decision = $this->getMockBuilder('UrlShort\Decision\AbstractDecision')->disableOriginalConstructor()->getMock();
        
        
        $decision->expects($this->once())
                ->method('tally')
                ->with($this->equalTo($token))
                ->will($this->returnValue(true));
        
        $log   = $this->getMock('Psr\Log\LoggerInterface');

        $log->expects($this->once())
            ->method('info')
            ->with($this->equalTo('review run for {url} decision::{decision} returned {returnValue}'),$this->equalTo(array(
                                                                                                             'url' => $url->longUrl,
                                                                                                             'decision' => gettype($decision),
                                                                                                             'returnValue' => true
                                                                                                                           )));
        
        
        $resolver = new DecisionResolver($log);
        $this->assertTrue($resolver->resolve($decision,$token));
        
    }
    
    
    
}
/* End of Class */