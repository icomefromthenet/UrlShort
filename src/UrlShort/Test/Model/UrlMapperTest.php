<?php
namespace UrlShort\Test;

use DateTime;
use UrlShort\Model\StoredUrl;
use UrlShort\Test\TestsWithFixture;

class ModelUrlMapperTest extends TestsWithFixture
{
    
   
    
    
    public function testMapperRemove()
    {
        $mapper = $this->app['urlshort.mapper'];
        
        $storedUrl = new StoredUrl();
        $storedUrl->urlId = 1;
        
        $this->assertTrue($mapper->remove($storedUrl));
    }
    
    /**
      *  @expectedException UrlShort\UrlShortException
      *  @expectedExceptionMessage Can not remove Url NULL is not a valid Id
      */
    public function testMapperRemoveNullId()
    {
       $mapper = $this->app['urlshort.mapper'];
        
       $storedUrl = new StoredUrl();
        
       $result = $mapper->remove($storedUrl);
    }
    
    public function testMapperRemoveBadId()
    {
       $mapper = $this->app['urlshort.mapper'];
        
       $storedUrl = new StoredUrl();
       $storedUrl->urlId = 10000;
       
       $this->assertFalse($mapper->remove($storedUrl)); 
    }
    
    
    public function testPurgeNoneForDate()
    {
        $mapper = $this->app['urlshort.mapper'];
        $before = new DateTime();
        $before->modify('- 100 years');
        
        $this->assertEquals(0,$mapper->purge($before));
        
    }
    
    public function testPurge()
    {
        $mapper = $this->app['urlshort.mapper'];
        $before = new DateTime();
        $before->modify('+ 100 years');
        
        $this->assertEquals(200,$mapper->purge($before));
        
    }
    
    
    public function testGetById()
    {
        $mapper = $this->app['urlshort.mapper'];
        
        $entity = $mapper->getById(1);
        
        $this->assertEquals($entity->urlId,1);
    }
    
    
    public function testGetByIdBadId()
    {
        $mapper = $this->app['urlshort.mapper'];
        
        $entity = $mapper->getById(10000000) ;
        
        $this->assertFalse($entity);
    }
    
    /**
      *  @expectedException UrlShort\UrlShortException
      *  @expectedExceptionMessage Can not lookup Url 1 is a string must be and integer
      */    
    public function testGetByIdStringId()
    {
        $mapper = $this->app['urlshort.mapper'];
        
        $entity = $mapper->getById('1') ;
        
    }
    
    
    public function testGetByShort()
    {
        $mapper = $this->app['urlshort.mapper'];
        
        $entity = $mapper->getByShort('lmztn');
        
        $this->assertEquals($entity->urlId,1);
        
    }
    
    
    public function testSaveCreate()
    {
        $mapper                 = $this->app['urlshort.mapper']; 
        $entity                 = new StoredUrl();
        $entity->longUrl        = 'http://www.google.com.au';
        $entity->description    = 'my description';
        $entity->dateStored     = new DateTime();
        $entity->tagId          = 5;
     
        $result = $mapper->save($entity);
        
        $this->assertEquals(201,$entity->urlId);
        $this->assertTrue($result);
        
    }
    
    
    public function testSaveUpdate()
    {
        $mapper = $this->app['urlshort.mapper'];
        $entity = new StoredUrl();
        
        $entity->longUrl        = 'http://www.google.com.au';
        $entity->description    = 'my description';
        $entity->dateStored     = new DateTime();
        $entity->tagId          = 5;
        $entity->urlId          = 1;
        $entity->shortCode      = 'tiddhgs';
        
        $entity->reviewDate     = new DateTime();
        $entity->reviewFailureMessage = 'failure';
        $entity->reviewPassed = false;
        
        $result = $mapper->save($entity);
        
        $this->assertTrue($result);
        
    }
    
    
    public function testGetShortWithReview()
    {
        $mapper = $this->app['urlshort.mapper'];
        
        $entity = $mapper->getByShortWithReview('lmztn',true);
        
        $this->assertEquals($entity->urlId,1);
        
    }
    
    
   public function testGetShortWithReviewFailedReviewOnly()
   {
        $mapper = $this->app['urlshort.mapper'];
        
        $entity = $mapper->getByShortWithReview('lmztn',false);
        
        $this->assertFalse($entity);
        
   }
   
   public function testGetShortWithReviewUrlNotReviewed()
   {
        $mapper = $this->app['urlshort.mapper'];
        
        $entity = $mapper->getByShortWithReview('ilayd',false);
        
        $this->assertFalse($entity);
        
   } 
    
}
/* End of File */