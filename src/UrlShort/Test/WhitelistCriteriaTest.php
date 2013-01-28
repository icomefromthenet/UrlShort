<?php
namespace UrlShort\Test;

use DateTime;
use Silex\WebTestCase;
use UrlShort\Decision\Criteria\WhitelistApprovalCriteria;
use UrlShort\Whitelist\RegexCollection;
use UrlShort\Decision\ReviewToken;
use UrlShort\Model\StoredUrl;

class WhitelistCriteriaTest extends \PHPUnit_Framework_TestCase
{
    
    public function testFoundLink()
    {
        $domain   = $this->getMockBuilder('Pdp\Domain')->disableOriginalConstructor()->getMock();
        $url = new StoredUrl();
        $url->longUrl = 'http://www.google.com';
        $token = new ReviewToken($url,$domain);
        
        $domain->expects($this->once())
               ->method('getRegisterableDomain')
               ->will($this->returnValue('google.com.au'));
        
        
        $regexCollection = new RegexCollection(array('^google\.(com|com\.au)$','^google\.(com|com\.au)'));
                    
        $criteria = new WhitelistApprovalCriteria($regexCollection);    
        
        $this->assertTrue($criteria->makeVote($token));
        $this->assertEquals($token->getReviewMessage('WhitelistApprovalCriteria'),'Match found on whitelist regexs //^google\\.(com|com\\.au)$/ui/ui,//^google\\.(com|com\\.au)/ui/ui');
        
    } 
    
    
    
    public function testMissedLink()
    {
        $domain   = $this->getMockBuilder('Pdp\Domain')->disableOriginalConstructor()->getMock();
        $url = new StoredUrl();
        $url->longUrl = 'http://www.google.com.nz';
        $token = new ReviewToken($url,$domain);
        
        $domain->expects($this->once())
               ->method('getRegisterableDomain')
               ->will($this->returnValue('google.com.nz'));
        
        
        $regexCollection = new RegexCollection(array('^google\.(com|com\.au)$'));
                    
        $criteria = new WhitelistApprovalCriteria($regexCollection);    
        
        $this->assertFalse($criteria->makeVote($token));
        $this->assertEquals($token->getReviewMessage('WhitelistApprovalCriteria'),'NO Matches found on whitelist');
    } 
    
    
}
/* End of File */