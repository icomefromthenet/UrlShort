<?php
namespace UrlShort\Command;

use DateTime;
use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Helper\DialogHelper,
    Symfony\Component\Console\Input\InputArgument;


use UrlShort\GSB\GSB4ugcServiceProvider;    

/**
* Purge The Google Safe Browsing Cache
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 0.0.1
*/
class GSBPurgeCommand extends Command
{
    
    /**
    *  Will Purge The Google Safe Browsing Cache
    *
    * @param InputInterface $input An InputInterface instance
    * @param OutputInterface $output An OutputInterface instance
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app      = $this->getHelper('silexApplication')->getApplication();
        $storage  =  $app[GSB4ugcServiceProvider::STORAGE];
        $data     = array();
        
        $storage->delete_all_data($data);
        
        return 0;
    }
    
    
    
    
    protected function configure()
    {
        $this->setDescription('Will run the Purge The Google Safe Browsing Cache');
        $this->setHelp(<<<EOF
Will run the purge 

Examples:

>> gsb:purge 
EOF
);
        parent::configure();
    }
}
/* End of File */