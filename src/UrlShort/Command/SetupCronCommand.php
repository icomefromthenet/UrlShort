<?php
namespace UrlShort\Command;

use DateTime;
use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Helper\DialogHelper,
    Symfony\Component\Console\Input\InputArgument;

use php\manager\crontab\CrontabManager;    

/**
* Purge Urls created before the given date.
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 0.0.1
*/
class SetupCronCommand extends Command
{
    
    /**
    * Truncate the Queue and Transition table
    *
    * @param InputInterface $input An InputInterface instance
    * @param OutputInterface $output An OutputInterface instance
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bin_file = realpath(__DIR__ ."/../../../bin/urlshort.php > /dev/null");
        $crontab  = new CrontabManager();        
        
        $job = $crontab->newJob();
        $job->onMinute('30')->doJob($bin_file .' gsb:update');

        $crontab->add($job);
        $crontab->save();

        $output->writeln('Setup cron jobs <info>sucessfuly</info>');
        return 0;
    }
    
    
    
    
    protected function configure()
    {
        $this->setDescription('Setup the Cron jobs');
        $this->setHelp(<<<EOF
Will Setup cron jobs

Examples:

>> app:cronbind 
EOF
);
        
        parent::configure();
    }
}
/* End of File */