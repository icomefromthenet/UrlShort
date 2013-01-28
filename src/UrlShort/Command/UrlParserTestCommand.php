<?php
namespace UrlShort\Command;

use DateTime;
use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Helper\DialogHelper,
    Symfony\Component\Console\Input\InputArgument;

/**
*  Parse a url and output result
*
*  @author Lewis Dyer <getintouch@icomefromthenet.com>
*  @since 1.0.0
*/
class UrlParserTestCommand extends Command
{
    
    /**
    * Truncate the Queue and Transition table
    *
    * @param InputInterface $input An InputInterface instance
    * @param OutputInterface $output An OutputInterface instance
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');
        
        $app     = $this->getHelper('silexApplication')->getApplication();
        $parser = $app['pdb.parser'];
        
        $domain = $parser->parse($url);
        
        $output->writeln(var_export($domain,true));
        
        return 0;
    }
      
    
    
    protected function configure()
    {
        $this->setDescription('Parse a url and output results');
        $this->setHelp(<<<EOF
Output the result of url parsing by pdp parsing library
Don't forget to <info>quote the url</info> .

Examples:

>> url:parse "http://www.google.com.au?b=c&f=u"

EOF
);
        $this->addArgument('url',InputArgument::REQUIRED, 'A url to parse');
        parent::configure();
    }
}
/* End of File */