<?php
namespace UrlShort\Test;

use DateTime;
use Silex\WebTestCase;
use UrlShort\Decision\Criteria\ResolveLinkCriteria;
use UrlShort\Decision\ReviewToken;
use UrlShort\Model\StoredUrl;

class ResolveLinkCriteriaTest extends WebTestCase
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
        $url      = new StoredUrl();
        $url->longUrl = 'http://www.google.com';
        $token    = new ReviewToken($url,$domain);
        $criteria = new ResolveLinkCriteria();    
        $this->assertTrue($criteria->makeVote($token));
        
    } 
    
    public function test404Link()
    {
        $domain   = $this->getMockBuilder('Pdp\Domain')->disableOriginalConstructor()->getMock();
        $url = new StoredUrl();
        $url->longUrl = 'http://www.icomefromthenet.com/3434343';
        $token = new ReviewToken($url,$domain);
        
        $criteria = new ResolveLinkCriteria();    
        $this->assertFalse($criteria->makeVote($token));
        
    }
    
}
/* End of File */