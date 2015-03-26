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
use LaterJob\Exception as LaterJobException;
/**
* Mock Process of jobs.
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 0.0.1
*/
class QueueMockProcessCommand extends Command
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
    
    protected function floatRand($min, $max, $round=0)
    {
	    if ($min > $max) {
            $min = $max;
            $max = $min;
        } else {
            $min = $min;
            $max = $max;
        }
	
        $randomfloat = $min + mt_rand() / mt_getrandmax() * ($max - $min);
	
        if($round > 0) {
		$randomfloat = round($randomfloat,$round);
        }
 
	    return $randomfloat;
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
        $jfailure   = $input->getArgument('jfailure');
        
        if(!is_numeric($jfailure)) {
            throw new RuntimeException('Argument jfailuer must be an integer');
        }
        
        $jfailure = $jfailure /100;
        
        if($jfailure > 1) {
            throw new RuntimeException('Argument jfailuer must be between 1-100');
            
        }
        # try to process jobs
        
        # fetch a worker instance from queue api
        $worker = $queue->worker();


        try {
            # start the worker, record started state in the activity log
            $worker->start(new DateTime());

            # load the allocator, allocates work from pool of locked jobs 
            $allocator = $worker->receive(new DateTime());

            # fetch worker handle
            $handle = $worker->getId();

            # iterate over jobs to proces
        foreach($allocator as $job) {

                # inner error catch so error job wont stop worker processing
                try {

                    # start job, will transition job from added to starting in the activity log
                    $job->start($handle,new DateTime());

                    # simulate time taken by a single job to process
                    $sleep = (integer) \mt_rand(0,15);    
                    sleep($sleep);        

                    # simulate a chance to fail    
                    $valueA = $this->floatRand(0,1);
                    $valueB = $this->floatRand(0,1);

                    if($valueA <= $jfailure) {
                        # Setting the rety left to 0 to force a `failed` transition.
                        # the api will decerement the count for you normally.
                        $job->getStorage()->setRetryLeft(0);

                        # throw exception to be caught by inner handler
                        throw new LaterJobException('failure has occured');
                    }

                    # cause the `error` transition if retry counter > 0
                    if($valueB <= $jfailure) {
                        throw new LaterJobException('error has occured');
                    }

                    # normal execution finished, transition from starting to finished in activity log
                    $job->finish($handle,new DateTime());
                }
                catch(LaterJobException $e) {

                    # transiton to failed or error  up to the developer to handle
                    # which transiton to pick, you may want the option to ignore failures
                    # and go to failed.
                    if($job->getRetryCount() > 0) {
                        $job->error($handle,new DateTime(),$e->getMessage());    
                    }
                    else {
                        $job->fail($handle,new DateTime(),$e->getMessage());    
                    }
                }

            }

        # finish the worker, will record finished state in activity log
            $worker->finish(new DateTime());

        } catch(LaterJobException $e) {
            # transition to error state, will record error state in activity log
            $worker->error($handle,new DateTime(),$e->getMessage());
            throw $e;            
        }

    return 0;

    }
    
    
    
    
    protected function configure()
    {
        $this->setDescription('Process jobs from queue');
        $this->setHelp(<<<EOF
Will add mock jobs to the queue.

Examples:

>> laterjob:mockprocess 30
EOF
);
        
        $this->addArgument('jfailure',InputArgument::REQUIRED,'The percent ceil to fail');
        
        parent::configure();
    }
}
/* End of File */