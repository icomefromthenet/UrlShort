<?php
/*
 * Development Config File
 *
 */

# ----------------------------------------------------
# Set Silex to Debug mode
# 
# ---------------------------------------------------

$app["debug"] = true;


# ----------------------------------------------------
# Set Monolog
# ---------------------------------------------------

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => $app['cache_path'].'logs/urlshort.log',
));

# ----------------------------------------------------
# Log queries into a file
# ---------------------------------------------------
   
$app['dispatcher']->addSubscriber(new DBALGateway\Feature\StreamQueryLogger($app['monolog']));
   

# ----------------------------------------------------
# Setup Database and PDOSessionHandler
# 
# ---------------------------------------------------

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'    => 'url_short',
        'user'      => 'root',
        'password'  => 'vagrant',
    )
));


# ----------------------------------------------------
# Load ValidatorServiceProvider
# 
# ---------------------------------------------------

$app->register(new Silex\Provider\ValidatorServiceProvider());


# ----------------------------------------------------
# Setup Google Safer Browsing Service Provider
# 
# ---------------------------------------------------

$app->register(new UrlShort\GSB\GSB4ugcServiceProvider(), array(
                    'gsb.api.key' => 'ABQIAAAAAq6Cf-1cY46YcDjKhpfAORToonwG5nrJE1m-AitX9sVyRDYycQ'                                            
                    
                ));

# ----------------------------------------------------
# Quick Tag
# 
# ---------------------------------------------------

$app->register(new QuickTag\Silex\Provider\TagServiceProvider('urlshort.quicktag'), array(
                    'urlshort.quicktag.options' => array(
                        'tableName' => 'url_short_tags')
));


# ----------------------------------------------------
# Setup LaterJob Queue For GSB Checking
# 
# ---------------------------------------------------

$app['laterjob.api.formatters.job'] = $app->share(function() {
    return new \LaterJobApi\Formatter\JobFormatter();
});
                
        
            
$app['laterjob.api.formatters.activity'] = $app->share(function() {
    return new \LaterJobApi\Formatter\ActivityFormatter();
});
        
            
$app['laterjob.api.formatters.monitor'] = $app->share(function(){
    return new \LaterJobApi\Formatter\MonitorFormatter();
});


$app->register(new LaterJobApi\Provider\QueueServiceProvider('urlshort.gsbqueue'), array(
              'urlshort.gsbqueue.options' => array(
                        'worker' => array(
                                
                                # check 300 url's max per worker run.
                                'jobs_process'      => 300,
                                 
                                 # worker take 1 hour average
                                'mean_runtime'      => (60*60), 
                                
                                # run script halfhour
                                'cron_script'       => '* 30 * * *',
                                
                                # 2 lockout once url is selected by a worker.
                                'job_lock_timeout'  => (60*60*2),
                                
                                # worker name gsb (for logs)
                                'worker_name'       => 'gsb'
                        ),
                        'queue' => array(
                                
                                # take no more than hour for url to be checked.
                                'mean_service_time' => (60*60*1),
                                
                                # retry url once if first request to gsb fails.
                                'max_retry'         => 1,
                                
                                # lock the retry to a minute later.
                                'retry_timer'       => (60*1)
                        ),
                        'db' => array(
                                'transition_table' => 'gsb_transition',
                                'queue_table'      => 'gsb_queue',
                                'monitor_table'    => 'gsb_monitor'
                        )
                    )
                )
            );

            
# ----------------------------------------------------
# Setup UrlShortner Provider
# 
# ---------------------------------------------------

$app->register(new UrlShort\UrlShortServiceProvider(), array(
                            'urlshort.tablename' => 'url_short_storage'));   

