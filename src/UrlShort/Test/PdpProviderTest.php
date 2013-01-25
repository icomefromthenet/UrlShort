<?php
namespace UrlShort\Test;

use Silex\Application;
use UrlShort\Pdp\PdpServiceProvider;

class PdpProviderTest extends \PHPUnit_Framework_TestCase
{
    
    public function testCacheDirectoryUsesGlobalEnv()
    {
        $container = new Application();
        $container['resources_path'] =__DIR__ . '/../../../resources/';
                
        $container->register(new PdpServiceProvider());

        $this->assertTrue(is_dir($container['pdp.cachedir']));
    }
    
    
    public function testListmanagerStarts()
    {
        $container = new Application();
        $container['resources_path'] =__DIR__ . '/../../../resources/';
                
        $container->register(new PdpServiceProvider());
        
        $this->assertInstanceOf('Pdp\PublicSuffixListManager',$container['pdb.listmanager']);
    }
    
    
    public function testUrlParse()
    {
        $container = new Application();
        $container['resources_path'] =__DIR__ . '/../../../resources/';
                
        $container->register(new PdpServiceProvider());
        
        $this->assertInstanceOf('Pdp\DomainParser',$container['pdb.parser']);
        $this->assertInstanceOf('Pdp\Domain',$container['pdb.parser']->parse('www.google.com.au'));
    }
    
}
/* End of File */