<?php
namespace UrlShort\Test;

use UrlShort\Whitelist\RegexCollection;


class RegexCollectionTest  extends \PHPUnit_Framework_TestCase
{
    
    public function testRegexHadDelimiterAdded()
    {
        $collection = new RegexCollection();
        
        $collection->add('^localhost$');
        $this->assertEquals('/^localhost$/ui',$collection->get(0));
    }
    
    
    public function testRegexMatch()
    {
        $collection = new RegexCollection();
        $collection->add('^localhost$');
        
        $results= $collection->regexMatchUrl('localhost');
        $this->assertCount(1,$results);
        
        $results= $collection->regexMatchUrl('localhosts');
        $this->assertCount(0,$results);
        
        # add a second match regex check if both returned        
        $collection->add('^localhost$');
        $results= $collection->regexMatchUrl('localhost');
        $this->assertCount(2,$results);
        
        # check case not effect match
        $results= $collection->regexMatchUrl('localHOST');
        $this->assertCount(2,$results);
    }
    
}
/* End of File */