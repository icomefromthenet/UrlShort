<?php
namespace UrlShort\Decision;

use  UrlShort\UrlShortException;

/**
*  A decision contains both a decision strategy and a set
*  of criteria and is itself a criteria to be used in other
*  decisions.
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 1.0.0
*/
class AbstractDecision 
{
    
    /**
    * @var StrategyInterface
    */
    protected $strategy;
    
    /**
    * @var array[CrteriaInterface], the criteria to use
    */
    protected $criteria;
    
    /**
    * Class Constrcutor
    *
    * @param array $criteria CriteriaInterface, the voters to use
    * @param StrategyInterface a strategy to use
    */
    public function __construct(array $criteria, StrategyInterface $strategy)
    {
        $this->strategy = $strategy;
        $this->criteria = $criteria;
    }
    
    
    /**
    * Run the criteria again a decision strategy
    *
    * @param ReviewToken $token
    * @return boolean true if sucessful
    */
    public function tally(ReviewToken $token)
    {
        
        $results = array();
        
        # verify that criteria have been set
        
        if(count($this->criteria) <= 0 ) {
            throw new UrlShortException('No Criteria to make a decision with have been set');
        }
        
        # verify a decision strategy has been set
        
        if(($this->strategy instanceof StrategyInterface) === false) {
            throw new UrlShortException('No Decision Strategy has been set');
        }
        
        # run through an collect criteria results
        
        foreach($this->criteria as $criteria) {
            $criteria->makeVote($token);
        }
        
        # pass results to strategy for resolution
        
        return $this->strategy->decide($token->getReviewResults());
        
    }
    
}
/* End of File */