<?php
namespace UrlShort\Test;

use Silex\Application;
use UrlShort\Decision\Provider\WhitelistReviewProvider;

class WhitelistServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    
    public function testWhiteListPathResolves()
    {
        $container = new Application();
        $container['resources_path'] =__DIR__ . '/../../../resources/';
                
        $container->register(new WhitelistReviewProvider());

        $this->assertTrue(is_dir($container['urlshort.review.whitelist.path']));
    }
    
    
    public function testListLoaderReturnsCollection()
    {
        $container = new Application();
        $container['resources_path'] =__DIR__ . '/../../../resources/';
                
        $container->register(new WhitelistReviewProvider());
        $this->assertInstanceOf('UrlShort\Whitelist\RegexCollection',$container['urlshort.review.whitelist.config']);
        $this->assertCount(1,$container['urlshort.review.whitelist.config']);
    }
    
    
    public function testReviewDecision()
    {
        $container = new Application();
        $container['resources_path'] =__DIR__ . '/../../../resources/';
        
        $container->register(new WhitelistReviewProvider());
        $review = $container['urlshort.review.whitelist'];
        
        $this->assertInstanceOf('UrlShort\Decision\WhitelistReview',$review);
        
    }
    
}
/* End of File */