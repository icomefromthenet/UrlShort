<?php
namespace UrlShort\Command;

use DateTime;
use RuntimeException;
use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Helper\DialogHelper,
    Symfony\Component\Console\Input\InputArgument;

use LaterJob\Log\ConsoleSubscriber;

/**
* Purge Urls created before the given date.
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 0.0.1
*/
class QueueMockAddCommand extends Command
{
    
    /**
      *  Fetch the laterjob queue library
      *
      *  @return LaterJob\Queue;
      */
    protected function getQueue()
    {
        $app = $this->getHelper('silexApplication')->getApplication();
        
        return $app['urlshort.queue.queue'];
    }
    
    
    protected function getEventDispatcher()
    {
        $app = $this->getHelper('silexApplication')->getApplication();
        
        return $app['urlshort.queue.event.dispatcher'];
    }
    
    /**
    * Truncate the Queue and Transition table
    *
    * @param InputInterface $input An InputInterface instance
    * @param OutputInterface $output An OutputInterface instance
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        # attach console logger so we can see the results of this operation
        $this->getEventDispatcher()->addSubscriber(new ConsoleSubscriber($output));
        
        # load the queue
        $queue    = $this->getQueue();
        
        # verify the argument is a number    
        $now      = new DateTime();
        $jCount   = $input->getArgument('jcount');
        
        if(!is_numeric($jCount)) {
            throw new RuntimeException('Argument jcount must be an integer');
        }
        
        # add mock jobs
        
        try {
           
            while($jCount > 0) {
                # each job data needs to be unique value as
                # we store a hash of job data
                $queue->send($now,array(
                    'job_name' => 'mock_job'
                   ,'made'    => $now->format('Y-m-d H:i:s')
                   ,'count'   => $jCount
                ));
                
                
                           
                $jCount = $jCount-1;
            }
            
        } catch(LaterJobException $e) {
            $worker->error($handle,new DateTime(),$e->getMessage());
            throw $e;
        }
       
       
        return 0;
    }
    
    
    
    
    protected function configure()
    {
        $this->setDescription('Adds mock jobs to the queue');
        $this->setHelp(<<<EOF
Will add mock jobs to the queue.

Examples:

>> laterjob:mockjobs 100 
EOF
);
        
        $this->addArgument('jcount',InputArgument::REQUIRED,'The number of mock jobs to add');
        
        parent::configure();
    }
}
/* End of File */