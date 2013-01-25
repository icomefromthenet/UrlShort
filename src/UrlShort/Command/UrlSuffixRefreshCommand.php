<?php
namespace UrlShort\Command;

use DateTime;
use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Helper\DialogHelper,
    Symfony\Component\Console\Input\InputArgument;

/**
*  Refresh the suffix list for pdp parser
*
*  @author Lewis Dyer <getintouch@icomefromthenet.com>
*  @since 1.0.0
*/
class UrlSuffixRefreshCommand extends Command
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
        $manager = $app['pdb.listmanager'];
        $manager->refreshPublicSuffixList();
        
        $output->writeln('Finished Refreshing the Suffix List');
        
        return 0;
    }
      
    
    
    protected function configure()
    {
        $this->setDescription('List Public Url SuffixList');
        $this->setHelp(<<<EOF
Refresh the pdp url suffix cache

Examples:

>> suffix:refresh 

EOF
);
        parent::configure();
    }
}
/* End of File */