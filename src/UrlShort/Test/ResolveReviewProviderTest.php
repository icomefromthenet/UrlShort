<?php
namespace UrlShort\Test;

use Silex\Application;
use UrlShort\Decision\Provider\ResolveReviewProvider;
use UrlShort\Decision\Affirmative;

class ResolveReviewProviderTest extends \PHPUnit_Framework_TestCase
{
    
    public function testDecisionAndCriteriaImplementInterfaces()
    {
        $container = new Application();
        $container->register(new ResolveReviewProvider());

        
        # assert the decision is valid type        
        $this->assertInstanceOf('UrlShort\Decision\StrategyInterface',$container['urlshort.review.resolve.decision']);
        
        # check all returned criteria a re valid type
        $criterias = $container['urlshort.review.resolve.criteria'];
        foreach($criterias as $criteria) {
            $this->assertInstanceOf('UrlShort\Decision\CriteriaInterface',$criteria);
        }
        
        
    }
    
    
    public function testOverrideForDecision()
    {
        $container = new Application();
        $container->register(new ResolveReviewProvider(),array('urlshort.review.resolve.decision' => new Affirmative()));

        $this->assertInstanceOf('UrlShort\Decision\Affirmative',$container['urlshort.review.resolve.decision']);
       
        
    }
    
    
    public function testOverrideForCriteria()
    {
        $container = new Application();
        $criteria  = $this->getMock('UrlShort\Decision\CriteriaInterface');
        $container->register(new ResolveReviewProvider(),array('urlshort.review.resolve.criteria' => $criteria));

        $this->assertEquals($criteria,$container['urlshort.review.resolve.criteria']);
    }
    
    
    public function testServiceDefaultConfig()
    {
        $container = new Application();
        $container->register(new ResolveReviewProvider());
        
        $this->assertInstanceOf('UrlShort\Decision\ResolveReview',$container['urlshort.review.resolve']);
        $this->assertInstanceOf('UrlShort\Decision\AbstractDecision',$container['urlshort.review.resolve']);
        
    }
}
/* End of File */