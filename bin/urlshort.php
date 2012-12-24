#!/usr/bin/env php
<?php
use Symfony\Component\Console\Application,
    Symfony\Component\Console\Helper\HelperSet,
    Symfony\Component\EventDispatcher\EventDispatcher;

use UrlShort\Command\SilexHelper,
    UrlShort\Command\PurgeCommand,
    UrlShort\Command\GSBLookupCommand,
    UrlShort\Command\GSBPurgeCommand,
    UrlShort\Command\GSBUpdateCommand,
    UrlShort\Command\SetupCronCommand;

/*
|--------------------------------------------------------------------------
| Require Apploader
|--------------------------------------------------------------------------
|
| Load the base app file 
|
*/
require __DIR__. DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR . 'app.php';


/*
|--------------------------------------------------------------------------
| Setup Symfony2 Console Application
|--------------------------------------------------------------------------
|
| Using Symfony2 console and provides a helper (SilexHelper)
| allowing the commands to access the Silex App API
|
*/
$application = new Application();

$application->add(new PurgeCommand('app:purge'));
$application->add(new SetupCronCommand('app:cronbind'));
$application->add(new GSBPurgeCommand('gsb:purge'));
$application->add(new GSBUpdateCommand('gsb:update'));
$application->add(new GSBLookupCommand('gsb:lookup'));

$application->getHelperSet()->set(new SilexHelper($app));

# run the console
$application->run();

/* End of File */