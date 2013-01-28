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
    UrlShort\Command\SetupCronCommand,
    UrlShort\Command\UrlSuffixRefreshCommand,
    UrlShort\Command\UrlParserTestCommand;

use  LaterJob\Command\CleanupCommand as LaterJobCleanupCommand;
use  LaterJob\Command\MonitorCommand as LaterJobMonitorCommand;
use  LaterJob\Command\PurgeCommand   as LaterJobPurgeCommand;
use  LaterJob\Command\QueueHelper    as LaterJobQueueHelper;    
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

$application->add(new SetupCronCommand('cron:install'));
$application->add(new PurgeCommand('app:purge'));
$application->add(new GSBPurgeCommand('gsb:purge'));
$application->add(new GSBUpdateCommand('gsb:update'));
$application->add(new GSBLookupCommand('gsb:lookup'));
$application->add(new LaterJobCleanupCommand('laterjob:cleanup'));
$application->add(new LaterJobMonitorCommand('laterjob:monitor'));
$application->add(new LaterJobPurgeCommand('laterjob:activity-purge'));
$application->add(new UrlSuffixRefreshCommand('url:refresh'));
$application->add(new UrlParserTestCommand('url:parse'));

$application->getHelperSet()->set(new SilexHelper($app));
$application->getHelperSet()->set(new LaterJobQueueHelper($app['urlshort.gsbqueue.queue']));

# run the console
$application->run();

/* End of File */