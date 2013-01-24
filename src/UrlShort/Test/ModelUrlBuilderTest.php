<?php
namespace UrlShort\Test;

use DateTime;
use PHPUnit_Framework_TestCase;
use UrlShort\Model\UrlBuilder;
use UrlShort\Model\StoredUrl;

class ModelUrlBuilderTest extends PHPUnit_Framework_TestCase
{
    
    public function testBuilderBuild()
    {
        $urlId                  = 1;
        $shortCode              = 'adxcdfd';
        $longUrl                = 'http://www.google.com.au/';   
        $dateStored             = new DateTime();
        $description            = 'a link to google in Australia';
        $reviewPassed           = true;
        $reviewFailureMessage   = 'no failure';
        $reviewDate             = new DateTime();
        $tagId                  = 3;
        
        $data = array(
            'url_id'             => $urlId,
            'short_code'         => $shortCode,
            'long_url'           => $longUrl,
            'date_created'       => $dateStored,
            'description_msg'    => $description,
            'tag_id'             => $tagId,
            'review_passed'      => $reviewPassed,
            'review_failure_msg' => $reviewFailureMessage,
            'review_date'        => $reviewDate, 
        );
        
        $builder = new UrlBuilder();
        
        $entity = $builder->build($data);
        
        $this->assertEquals($urlId,$entity->urlId);
        $this->assertEquals($shortCode,$entity->shortCode);
        $this->assertEquals($longUrl,$entity->longUrl);
        $this->assertEquals($dateStored,$entity->dateStored);
        $this->assertEquals($description,$entity->description);
        $this->assertEquals($reviewPassed,$entity->reviewPassed);
        $this->assertEquals($reviewFailureMessage,$entity->reviewFailureMessage);
        $this->assertEquals($reviewDate,$entity->reviewDate);
        $this->assertEquals($tagId,$entity->tagId);
        
        
    }
    
    
    
    public function testBuilderDemolish()
    {
        $urlId                  = 1;
        $shortCode              = 'adxcdfd';
        $longUrl                = 'http://www.google.com.au/';   
        $dateStored             = new DateTime();
        $description            = 'a link to google in Australia';
        $reviewPassed           = true;
        $reviewFailureMessage   = 'no failure';
        $reviewDate             = new DateTime();
        $tagId                  = 3;
        
        $data = array(
            'url_id'             => $urlId,
            'short_code'         => $shortCode,
            'long_url'           => $longUrl,
            'date_created'       => $dateStored,
            'description_msg'    => $description,
            'tag_id'             => $tagId,
            'review_passed'      => $reviewPassed,
            'review_failure_msg' => $reviewFailureMessage,
            'review_date'        => $reviewDate, 
        );
        
        $entity = new StoredUrl();
        
        $entity->urlId                = $urlId;
        $entity->tagId                = $tagId;    
        $entity->dateStored           = $dateStored;
        $entity->description          = $description;
        $entity->longUrl              = $longUrl;
        $entity->reviewDate           = $reviewDate;  
        $entity->reviewFailureMessage = $reviewFailureMessage;
        $entity->reviewPassed         = $reviewPassed;
        $entity->shortCode            = $shortCode; 
        
        $bulider = new UrlBuilder();
        
        $this->assertEquals($data,$bulider->demolish($entity));
        
    }
    
}
/* End of File */