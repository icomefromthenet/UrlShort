<?php
namespace UrlShort\Command;

use Symfony\Component\Console\Helper\Helper;
use Silex\Application;

/**
* Injects a Silex API into console commands
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 0.0.1
*/
class SilexHelper extends Helper
{
    /**
    * @var Silex\Application;
    */
    protected $app;
    
    
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    
    /**
    * Return the assigned Silex\Application
    *
    * @access public
    * @return Silex\Application;
    */
    public function getApplication()
    {
        return $this->app;
    }
    
    
    /**
    * @see Helper
    */
    public function getName()
    {
        return 'silexApplication';
    }
    
}
/* End of File */