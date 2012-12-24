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
*  Download an update from The Google Safe Browsing API
*
*  @author Lewis Dyer <getintouch@icomefromthenet.com>
*  @since 1.0.0
*/
class GSBUpdateCommand extends Command
{
    
    /**
    * Truncate the Queue and Transition table
    *
    * @param InputInterface $input An InputInterface instance
    * @param OutputInterface $output An OutputInterface instance
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app     = $this->getHelper('silexApplication')->getApplication();
        $updater = $app[GSB4ugcServiceProvider::UPDATER];
        $storage = $app[GSB4ugcServiceProvider::STORAGE];
        $lists   = $app[GSB4ugcServiceProvider::LISTS];
        
        # get new chunks
        $updater->downloadData($lists, FALSE);

        # zap outdated fullhash definitions (they are only good for 45m)
        $storage->fullhash_delete_old();
        
        return 0;
    }
      
    
    
    protected function configure()
    {
        $this->setDescription('Download an update from The Google Safe Browsing API');
        $this->setHelp(<<<EOF
Download an update from The Google Safe Browsing API

Examples:

>> gsb:update '15th january 2011'

EOF
);
        parent::configure();
    }
}
/* End of File */