<?php
namespace UrlShort\Test;

use DateTime;
use Silex\WebTestCase;
use UrlShort\Decision\Criteria\GSBCriteria;
use UrlShort\Decision\ReviewToken;
use UrlShort\Model\StoredUrl;

class GSBCriteriaTest extends WebTestCase
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

    
    public function testGoodLink()
    {
        $domain   = $this->getMockBuilder('Pdp\Domain')->disableOriginalConstructor()->getMock();
        $url = new StoredUrl();
        $url->longUrl = 'http://www.google.com';
        $token = new ReviewToken($url,$domain);
        
        $gsbClient = $this->getMockBuilder('GSB_Client')->disableOriginalConstructor()->getMock();
                    
        $gsbClient->expects($this->once())
                  ->method('doLookup')
                  ->with($this->equalTo($url->longUrl))
                  ->will($this->returnValue(array()));
        
                    
        $criteria = new GSBCriteria($gsbClient);    
        $this->assertFalse($criteria->makeVote($token));
        
    } 
    
    
    public function testBadLink()
    {
        $domain   = $this->getMockBuilder('Pdp\Domain')->disableOriginalConstructor()->getMock();
        $url = new StoredUrl();
        $url->longUrl = 'http://www.google.com';
        $token = new ReviewToken($url,$domain);
        
        $gsbClient = $this->getMockBuilder('GSB_Client')->disableOriginalConstructor()->getMock();
                    
        $gsbClient->expects($this->once())
                  ->method('doLookup')
                  ->with($this->equalTo($url->longUrl))
                  ->will($this->returnValue(array(1,2,3)));
        
                    
        $criteria = new GSBCriteria($gsbClient);    
        $this->assertTrue($criteria->makeVote($token));
        
    } 
}
/* End of File */