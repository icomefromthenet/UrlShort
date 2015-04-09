<?php
namespace UrlShort\Test;

use DateTime;
use UrlShort\Model\UrlQuery;
use UrlShort\Model\UrlGatewaty;
use UrlShort\UrlShortServiceProvider;
use UrlShort\Test\Base\TestsWithFixture; 

class UrlStorageQueryTest extends TestsWithFixture
{
    
   
    
    public function testFilterById()
    {
        $gateway = $this->app['urlshort.gateway'];
        
        
        $query = $gateway->selectQuery()
                ->start()
                    ->filterById(1);
                
        $this->assertRegExp('/WHERE url_id = :url_id/',$query->getSql());
        $this->assertEquals(1,$query->getParameter('url_id'));
        
        
        
    }
    
    
    public function testFilterByShortCode()
    {
        $gateway = $this->app['urlshort.gateway'];
        $short   = 'asxcsd';
        
        $query  = $gateway->selectQuery()
                    ->start()
                       ->filterByShortCode($short);
        
        $this->assertRegExp('/WHERE short_code = :short_code/',$query->getSql());
        $this->assertEquals($short,$query->getParameter('short_code'));
        
    }
    
    
    public function testFilterAddedAfter()
    {
        $gateway = $this->app['urlshort.gateway'];
        $after  = new DateTime();
        
        $query = $gateway->selectQuery()
                    ->start()
                        ->filterByAddedAfter($after);
                        
        $this->assertRegExp('/WHERE date_created >= :date_created_after/',$query->getSql());
        $this->assertEquals($after,$query->getParameter('date_created_after'));        
        
    }
    
    
    public function testFilterAddedBefore()
    {
        $gateway = $this->app['urlshort.gateway'];
        $before  = new DateTime();
        
        $query  = $gateway->selectQuery()
                    ->start()
                        ->filterByAddedBefore($before);
        
        $this->assertRegExp('/WHERE date_created <= :date_created_before/',$query->getSql());
        $this->assertEquals($before,$query->getParameter('date_created_before'));     
        
    }
    
    
    public function testFilterAddedRange()
    {
        $gateway = $this->app['urlshort.gateway'];
        $before  = new DateTime();
        $after   = new DateTime();
        
        $query = $gateway->selectQuery()
                    ->start()
                        ->filterByAddedAfter($after)
                        ->filterByAddedBefore($before);
                        
        $this->assertEquals($after,$query->getParameter('date_created_after'));  
        $this->assertEquals($before,$query->getParameter('date_created_before'));
        $this->assertRegExp('/WHERE \(date_created >= :date_created_after\) AND \(date_created <= :date_created_before\)/',$query->getSql());
    }
    
    
    public function testFilterBySuccessfulReview()
    {
        $gateway = $this->app['urlshort.gateway'];
        
        $query = $gateway->selectQuery()
                    ->start()
                        ->filterBySuccessfulReview();
                        
        $this->assertRegExp('/WHERE review_passed = :review_passed_success/',$query->getSql());
        $this->assertEquals(true,$query->getParameter('review_passed_success'));    
    }
    
    
    public function testFilterByFailedReview()
    {
        $gateway = $this->app['urlshort.gateway'];
        
        $query = $gateway->selectQuery()
                    ->start()
                        ->filterByFailedReview();
                        
        $this->assertRegExp('/WHERE review_passed = :review_passed_failed/',$query->getSql());
        $this->assertEquals(false,$query->getParameter('review_passed_failed'));  
        
    }
    
    
    
    public function testFilterByReviewed()
    {
        $gateway = $this->app['urlshort.gateway'];
        
        $query = $gateway->selectQuery()
                    ->start()
                        ->filterByReviewed();
                        
        $this->assertRegExp('/WHERE review_passed IS NOT NULL/',$query->getSql());                
    }
    
    
    
    public function testFilterByNotReviewed()
    {
        $gateway = $this->app['urlshort.gateway'];
        
        $query = $gateway->selectQuery()
                    ->start()
                        ->filterByNotReviewed();
                        
        $this->assertRegExp('/WHERE review_passed IS NULL/',$query->getSql());
        
    }
    
    
    public function testFilterByReviewedBefore()
    {
        $gateway = $this->app['urlshort.gateway'];
        $before  = new DateTime();
        
        $query = $gateway->selectQuery()
                    ->start()
                        ->filterByReviewDateBefore($before);
        
        $this->assertRegExp('/WHERE review_date <= :review_date_before/',$query->getSql());
        $this->assertEquals($before,$query->getParameter('review_date_before'));  
        
    }
    
    
    public function testFilterByReviewedAfter()
    {
        $gateway = $this->app['urlshort.gateway'];
        $after  = new DateTime();
        
        $query = $gateway->selectQuery()
                    ->start()
                        ->filterByReviewDateAfter($after);
        
        $this->assertRegExp('/WHERE review_date >= :review_date_after/',$query->getSql());
        $this->assertEquals($after,$query->getParameter('review_date_after'));  
        
    }
    
    
    public function testFilterByReviewdRange()
    {
        $gateway = $this->app['urlshort.gateway'];
        $after  = new DateTime();
        $before = new DateTime();
        
        $query = $gateway->selectQuery()
                    ->start()
                        ->filterByReviewDateBefore($before)
                         ->filterByReviewDateAfter($after);
                         
                         
        $this->assertEquals($after,$query->getParameter('review_date_after'));  
        $this->assertEquals($before,$query->getParameter('review_date_before'));
        
        $this->assertRegExp('/WHERE \(review_date <= :review_date_before\) AND \(review_date >= :review_date_after\)/',$query->getSql());
    }
    
    
    public function testOrderByAddedDate()
    {
        $gateway = $this->app['urlshort.gateway'];
        $dir = 'DESC';
        
        $query = $gateway->selectQuery()
                ->start()
                    ->orderByAddedDate($dir);
                
        $this->assertRegExp('/ORDER BY date_created DESC/',$query->getSql());
        
    }
    
    
    public function testOrderByReviewedDate()
    {
        $gateway = $this->app['urlshort.gateway'];
        $dir = 'DESC';
        
        $query = $gateway->selectQuery()
                ->start()
                    ->orderbyReviewDate($dir);
                
        $this->assertRegExp('/ORDER BY review_date DESC/',$query->getSql());
    }
    
}
/* End of File */