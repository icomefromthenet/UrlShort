<?php
namespace UrlShort\Test;

use DateTime;
use UrlShort\Event\UrlLookupEvent;
use UrlShort\Event\UrlPurgeEvent;
use UrlShort\Event\UrlRemoveEvent;
use UrlShort\Event\UrlShortEventsMap;
use UrlShort\Event\UrlReviewFailEvent;
use UrlShort\Event\UrlReviewPassEvent;
use UrlShort\Event\UrlStoreEvent;
use UrlShort\Event\UrlQueryEvent;
use UrlShort\Event\BaseEvent;
use UrlShort\Model\StoredUrl;


class EventObjectTest extends TestsWithFixture
{
    /**
    * Creates the application.
    *
    * @return HttpKernel
    */
    public function createApplication()
    {
        return require __DIR__ .'/../../../app.php';       
    }
    
    
    public function testBaseEventProperties()
    {
        $event = new BaseEvent($this->app);
        $event->setResult(true);
        
        $this->assertTrue($event->getResult());
    }
    
   
    public function testUrlLookupEventProperties()
    {
        $notice = true;
        $url    = new StoredUrl();
        $event  = new UrlLookupEvent($url,$notice);        
        
        $this->assertEquals($url,$event->getUrl());
        $this->assertEquals($notice,$event->getNotice());
    }
    
    
    public function testUrlPurgeEventProperties()
    {
        $before = new DateTime();        
        $event = new UrlPurgeEvent($before);
        
        $this->assertEquals($before,$event->getBefore());
    }
    
    
    public function testUrlRemoveEventProperties()
    {
        $url = new StoredUrl();
        $event = new UrlRemoveEvent($url);
        
        $this->assertEquals($url,$event->getUrl());
        
    }
    
    
    public function testUrlStoreEventProperties()
    {
        $url = new StoredUrl();
        $event = new UrlStoreEvent($url);
        
        $this->assertEquals($url,$event->getUrl());
    }
    
    
    public function testUrlReviewFailProperties()
    {
       $token    = $this->getMockBuilder('UrlShort\Decision\ReviewToken')->disableOriginalConstructor()->getMock();
       
       $event = new UrlReviewFailEvent($token);
        
       $this->assertEquals($token,$event->getToken());
    }

    
    public function testUrlReviewPassProperties()
    {
       $token    = $this->getMockBuilder('UrlShort\Decision\ReviewToken')->disableOriginalConstructor()->getMock();
       
       $event = new UrlReviewPassEvent($token);
        
       $this->assertEquals($token,$event->getToken());
       
        
    }

    public function testUrlQueryEventProperties()
    {
       $collection = $this->getMock('\Doctrine\Common\Collections\Collection');
        
       $event = new UrlQueryEvent($collection); 
        
    }
    
}
/* End of File */