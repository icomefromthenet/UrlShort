<?php
namespace UrlShort\Command;

use DateTime;
use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Helper\DialogHelper,
    Symfony\Component\Console\Input\InputArgument;
    

/**
* Purge Urls created before the given date.
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 0.0.1
*/
class PurgeCommand extends Command
{
    
    /**
    * Truncate the Queue and Transition table
    *
    * @param InputInterface $input An InputInterface instance
    * @param OutputInterface $output An OutputInterface instance
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $date = new DateTime($input->getArgument('date'));
        $app  = $this->getHelper('silexApplication')->getApplication();
        
        
        return 0;
    }
    
    
    
    
    protected function configure()
    {
        $this->setDescription('Will run the Purge Sequence');
        $this->setHelp(<<<EOF
Will run the purge for the date

Examples:

>> app:purge '15th january 2011'
>> app:purge 'today -1 month'


First Argument is date to purge before, should use php strtotime syntax
make sure to quote or date will not parse correctly.

EOF
);
        $this->addArgument('date',InputArgument::REQUIRED, 'A strtotime date string to purge </info>before<info>');
        parent::configure();
    }
}
/* End of File */