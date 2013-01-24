<?php
namespace UrlShort\Command;

use DateTime;
use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Helper\DialogHelper,
    Symfony\Component\Console\Input\InputArgument;

use UrlShort\Shortner;

/**
* Purge Urls created before the given date.
*
* @author Lewis Dyer <getintouch@icomefromthenet.com>
* @since 0.0.1
*/
class SetupCronCommand extends Command
{
    
    /**
      *  Fetch the laterjob queue library
      *
      *  @return LaterJob\Queue;
      */
    protected function getQueue()
    {
        $app = $this->getHelper('silexApplication')->getApplication();
        
        return $app['urlshort.gsbqueue.queue'];
    }
    
    /**
      *  Fetch the UrlShortner
      *
      *  @return UrlShortner\Shortner
      */
    protected function getShortner()
    {
        $app = $this->getHelper('silexApplication')->getApplication();
        
        return $app['urlshort'];
    }
    
    
    /**
    * Truncate the Queue and Transition table
    *
    * @param InputInterface $input An InputInterface instance
    * @param OutputInterface $output An OutputInterface instance
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        # load the queue
        $queue    = $this->getQueue();
        $shortner = $this->getShortner();
        
        $worker = $queue->worker();
        
        try {
            # start the worker
            $worker->start(new DateTime());
            
            $allocator = $worker->receive(new DateTime());
            $handle = $worker->getId();
            
            foreach($allocator as $job) {
            
                try {

                    $job->start($handle,new DateTime());
                    
                    # fetch the stored url 
                    $entity = $shortner->lookup($job->getStorage()->urlId);    
                    
                    $shortner->review($entity);
                    
                    
                    $job->finish($handle,new DateTime());
                }
                catch(LaterJobException $e) {
                    
                    if($job->getRetryCount() > 0) {
                        $job->error($handle,new DateTime(),$e->getMessage());
                    }
                    else {
                        $job->fail($handle,new DateTime(),$e->getMessage());
                    }
                }
            
            }
            
            # finish the worker
            $worker->finish(new DateTime());
            
        } catch(LaterJobException $e) {
            $worker->error($handle,new DateTime(),$e->getMessage());
            throw $e;
        }
       
       
        return 0;
    }
    
    
    
    
    protected function configure()
    {
        $this->setDescription('The URL Review Worker');
        $this->setHelp(<<<EOF
Will run a url review worker.

Examples:

>> app:url-review 
EOF
);
        
        parent::configure();
    }
}
/* End of File */