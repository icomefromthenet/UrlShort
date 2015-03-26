<?php
namespace UrlShort\Command;

use DateTime;
use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Helper\DialogHelper,
    Symfony\Component\Console\Input\InputArgument;

/**
*  Adds a new user to the database
*
*  @author Lewis Dyer <getintouch@icomefromthenet.com>
*  @since 1.0.0
*/
class AppUserAddCommand extends Command
{
    
    /**
    * Adds a new user to the database
    *
    * @param InputInterface $input An InputInterface instance
    * @param OutputInterface $output An OutputInterface instance
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        
        $app     = $this->getHelper('silexApplication')->getApplication();
 
        $user = $app['user.manager']->createUser($email, $password, 'John Doe', array('ROLE_ADMIN'));
        $app['user.manager']->insert($user);
        
        return 0;
    }
      
    
    
    protected function configure()
    {
        $this->setDescription('Adds a user to the database');
        $this->setHelp(<<<EOF
Adds a user to the database, use to add test users 

Examples:

>> app:useradd person@gmail.com mypassword

EOF
);
        $this->addArgument('email',InputArgument::REQUIRED, 'An email account ');
        $this->addArgument('password',InputArgument::REQUIRED, 'A password to use ');
        
        parent::configure();
    }
}
/* End of File */