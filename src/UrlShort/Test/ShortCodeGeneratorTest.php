<?php
namespace UrlShort\Test;

use DateTime;
use UrlShort\ShortCodeGenerator;
use Silex\WebTestCase;

class ShortCodeGeneratorTest extends WebTestCase
{
    /**
    * Creates the application.
    *
    * @return HttpKernel
    */
    public function createApplication()
    {
        $app = require __DIR__ .'/../../../app.php';
        
        $app->boot();
        
        return $app;
    }

    public function testWithGoodId()
    {
        $generator = $this->app['urlshort.generator'];
        
        $this->assertEquals('3',$generator->convert(2));
        $this->assertEquals('q',$generator->convert(20));
        $this->assertEquals('7x',$generator->convert(200));
        $this->assertEquals('3cz',$generator->convert(2000));
        $this->assertEquals('4mq8b98',$generator->convert(PHP_INT_MAX));
        
    }
    
    /**
      *  @expectedException UrlShort\UrlShortException
      *  @expectedExceptionMessage The ID is not a valid integer
      */    
    public function testWithStringId()
    {
        $generator = $this->app['urlshort.generator'];
        $generator->convert('aaa');
    }
    
    
    /**
      *  @expectedException UrlShort\UrlShortException
      *  @expectedExceptionMessage The ID is not a valid integer
      */    
    public function testWithZeroIntegerId()
    {
        $generator = $this->app['urlshort.generator'];
        $generator->convert(0);
    }
    
}
/* End of File */