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
*  CLI method to test Google Safe Browsing Client
*
*  @author Lewis Dyer <getintouch@icomefromthenet.com>
*  @since 1.0.0
*/
class GSBLookupCommand extends Command
{
    
    /**
    *  Lookup a url using the Google Safe Browsing Client
    *
    * @param InputInterface $input An InputInterface instance
    * @param OutputInterface $output An OutputInterface instance
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app     = $this->getHelper('silexApplication')->getApplication();
        $client  = $app[GSB4ugcServiceProvider::CLIENT];
        $url     = $input->getArgument('url');
        
        $matches = $client->doLookup($url);
        
        var_dump($matches);
        
        $output->writeln("$url: " . count($matches));
                
        return 0;
    }
      
    
    
    protected function configure()
    {
        $this->setDescription('Lookup a url using the Google Safe Browsing Client');
        $this->setHelp(<<<EOF
Lookup a url using the Google Safe Browsing Client, requires a url to lookup as argument

Examples:

>> gsb:lookup http://www.google.com

EOF
);
        
        $this->addArgument('url',InputArgument::REQUIRED,'the url to lookup');
        
        
        parent::configure();
    }
}
/* End of File */