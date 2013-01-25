<?php
namespace UrlShort\Test;

use Silex\Application;
use UrlShort\Decision\Provider\BlacklistReviewProvider;
use UrlShort\Decision\Affirmative;

class BlackListReviewProviderTest extends \PHPUnit_Framework_TestCase
{
    
    public function testDecisionAndCriteriaImplementInterfaces()
    {
        $container = new Application();
        
        $container['gsb.client'] = $this->getMockBuilder('GSB_Client')->disableOriginalConstructor()->getMock();
        $container->register(new BlacklistReviewProvider());

        
        # assert the decision is valid type        
        $this->assertInstanceOf('UrlShort\Decision\StrategyInterface',$container['urlshort.review.blacklist.decision']);
        
        # check all returned criteria a re valid type
        $criterias = $container['urlshort.review.blacklist.criteria'];
        foreach($criterias as $criteria) {
            $this->assertInstanceOf('UrlShort\Decision\CriteriaInterface',$criteria);
        }
        
        
    }
    
    
    public function testOverrideForDecision()
    {
        $container = new Application();
        $container['gsb.client'] = $this->getMockBuilder('GSB_Client')->disableOriginalConstructor()->getMock();
        
        $container->register(new BlacklistReviewProvider(),array('urlshort.review.blacklist.decision' => new Affirmative()));

        
        $this->assertInstanceOf('UrlShort\Decision\Affirmative',$container['urlshort.review.blacklist.decision']);
       
        
    }
    
    
    public function testOverrideForCriteria()
    {
        $container = new Application();
        $criteria  = $this->getMock('UrlShort\Decision\CriteriaInterface');
        $container->register(new BlacklistReviewProvider(),array('urlshort.review.blacklist.criteria' => $criteria));

        $this->assertEquals($criteria,$container['urlshort.review.blacklist.criteria']);
    }
    
    public function testServiceDefaultConfig()
    {
        $container = new Application();
        $container['gsb.client'] = $this->getMockBuilder('GSB_Client')->disableOriginalConstructor()->getMock();
        $container->register(new BlacklistReviewProvider());
        
        $this->assertInstanceOf('UrlShort\Decision\BlacklistReview',$container['urlshort.review.blacklist']);
        $this->assertInstanceOf('UrlShort\Decision\AbstractDecision',$container['urlshort.review.blacklist']);
        
    }
    
    
}
/* End of File */