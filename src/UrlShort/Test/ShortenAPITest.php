<?php
namespace UrlShort\Test;

use DateTime;
use UrlShort\Model\StoredUrl;

class ShortenAPITest extends TestsWithFixture
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
    
    
    public function testServiceProvider()
    {
        $this->assertInstanceOf('\UrlShort\Model\UrlGateway'  ,$this->app['urlshort.gateway']);
        $this->assertInstanceOf('\UrlShort\Model\UrlMapper'   ,$this->app['urlshort.mapper']);
        $this->assertInstanceOf('\UrlShort\ShortCodeGenerator',$this->app['urlshort.generator']);
        $this->assertInstanceOf('\UrlShort\Shortner'          ,$this->app['urlshort']);
        
    }
    
    
 
    public function testCreate()
    {
        $shortner = $this->app['urlshort'];
        
        $url         = 'http://www.google.com';
        $now         = new DateTime();
        $description = 'This is my description';
        $tag_id      = 1;
        
        $result      = $shortner->create($url,$now,$description, $tag_id);
        
        $this->assertInstanceOf('UrlShort\Model\StoredUrl',$result);
        $this->assertGreaterThan(0,$result->urlId);
    }
    
    
    
    /**
      *  @expectedException \UrlShort\UrlShortException
      *  @expectedExceptionMessage Unable to store url description given must be between 0 and 200 characters
      */
    public function testCreateEmptyDescription()
    {
        $shortner = $this->app['urlshort'];
        
        $url         = 'http://www.google.com';
        $now         = new DateTime();
        $description = '';
        $tag_id      = 1;
        
        $result      = $shortner->create($url,$now,$description, $tag_id);
        
    }
    
    
    
    /**
      *  @expectedException \UrlShort\UrlShortException
      *  @expectedExceptionMessage Unable to store url description given must be between 0 and 200 characters
      */
    public function testCreateOverflowDescription()
    {
        $shortner = $this->app['urlshort'];
        
        $url         = 'http://www.google.com';
        $now         = new DateTime();
        $description = str_repeat('a',201);
        $tag_id      = 1;
        
        $result      = $shortner->create($url,$now,$description, $tag_id);
        
    }
    
    
    
    /**
      *  @expectedException \UrlShort\UrlShortException
      *  @expectedExceptionMessage URL must be a string be between 0 and 255 characters
      */
    public function testCreateEmptyUrl()
    {
        $shortner = $this->app['urlshort'];
        
        $url         = '';
        $now         = new DateTime();
        $description = 'a description';
        $tag_id      = 1;
        
        $result      = $shortner->create($url,$now,$description, $tag_id);
        
    }
    
    
    
    /**
      *  @expectedException \UrlShort\UrlShortException
      *  @expectedExceptionMessage URL must be a string be between 0 and 255 characters
      */
    public function testCreateOverflowUrl()
    {
        $shortner = $this->app['urlshort'];
        
        $url         = str_repeat('a',256);
        $now         = new DateTime();
        $description = 'a description';
        $tag_id      = 1;
        
        $result      = $shortner->create($url,$now,$description, $tag_id);
        
    }
    
    
    /**
      *  @expectedException \UrlShort\UrlShortException
      *  @expectedExceptionMessage Unable to store url given tag must be a integer given is a string
      */
    public function testStringTagId()
    {
        $shortner = $this->app['urlshort'];
        
        $url         = 'http://www.google.com.au';
        $now         = new DateTime();
        $description = 'a description';
        $tag_id      = 'one';
        
        $result      = $shortner->create($url,$now,$description, $tag_id);
        
    }
    
    
    public function testPurge()
    {
        $shortner = $this->app['urlshort'];
        
        $before = new DateTime();
        $before->modify('+ 100 years');
        
        $this->assertEquals(200,$shortner->purge($before));
        
    }
    
    
    public function testPurgeNoneInRange()
    {
        $shortner = $this->app['urlshort'];
        
        $before = new DateTime();
        $before->modify('- 100 years');
        
        $this->assertEquals(0,$shortner->purge($before));
        
    }
    
    

    public function testRemove()
    {
        $shortner   = $this->app['urlshort'];
        $url        = new StoredUrl();
        $url->urlId = 1;
        
        
        $this->assertTrue($shortner->remove($url));
        
    }
    
    
    public function testRemoveNoUrlAtID()
    {
        $shortner   = $this->app['urlshort'];
        $url        = new StoredUrl();
        $url->urlId = -1;
        
        
        $this->assertFalse($shortner->remove($url));
    }
    
    
    public function testLookupUnReviewed()
    {
        
        
    }
    
    
    
}
/* End of File */