<?php
/*
 * Development Config File
 *
 */

# ----------------------------------------------------
# Set Silex to Debug mode
# 
# ---------------------------------------------------

# ----------------------------------------------------
# Set Error Reporting
# 
# ---------------------------------------------------

ini_set('display_errors',1);
ini_set('display_startup_errors',1);


$app["debug"] = true;


# ----------------------------------------------------
# Set Monolog
# ---------------------------------------------------

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => $app['resources_path'].'log/error.log',
    'monolog.level'   => Psr\Log\LogLevel::DEBUG
));

# ----------------------------------------------------
# Error Log
# ---------------------------------------------------


$app->error(function (\Exception $e, $code) {
    return new Symfony\Component\HttpFoundation\Response('We are sorry, but something went terribly wrong.');
});

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
        'host'      => getenv('IP'),
        'dbname'    => 'c9',
        'user'      => getenv('C9_USER'),
        'password'  => '',
    )
));


# ----------------------------------------------------
# Load ValidatorServiceProvider
# 
# ---------------------------------------------------

$app->register(new Silex\Provider\ValidatorServiceProvider());

# ----------------------------------------------------
# Register Twig
#
# ---------------------------------------------------

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'     => $app['views_path'],
    'twig.options'  => array(
        'cache'     => $app['cache_path'],
    ),
    'strict_variables'  => true,
    'autoescape'        => false,
    
));

$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {

    return $twig;
}));

# ----------------------------------------------------
# Session Provider
#
# ---------------------------------------------------

$app->register(new Silex\Provider\SessionServiceProvider(),array(
    'session.storage.options' => array(
      'name' => 'urlshort'
     ,'cookie_lifetime' => 1800 //sec or 30 minutes
    )    
    
));

# ----------------------------------------------------
# Url Generator Service Provider
# 
# ---------------------------------------------------

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());



# ----------------------------------------------------
# Service Controller Provider
#
# ---------------------------------------------------


$app->register(new Silex\Provider\ServiceControllerServiceProvider());


# ----------------------------------------------------
# Security and user Provider
#
# ---------------------------------------------------
//$app->register(new Silex\Provider\RememberMeServiceProvider());


$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'login' => array(
             'pattern'   => '^/user/login$'
            ,'anonymous' => true
            
        )
        ,'queue' => array(
            'pattern' => '^/queue'
            ,'anonymous' => true
            ,'stateless' => true,
        )
        ,'secured_area' => array(
            'pattern' => '^.*$',
            'form' => array(
                 'login_path' => '/user/login'
                ,'check_path' => '/user/login_check'
            ),
            
            'logout' => array(
                'logout_path' => '/user/logout',
            ),
            'users' => $app->share(function($app) { return $app['user.manager']; }),
        ) 
    )    
));

$app->register($app['user.provider'] = new SimpleUser\UserServiceProvider() ,array(
    'user.options' => array(
    // Specify custom view templates here.
    'templates' => array(
        'layout'                    => 'layout.html.twig',
        'register'                  => '@user/register.twig',
        'register-confirmation-sent' => '@user/register-confirmation-sent.twig',
        'login'                     => 'login.html.twig',
        'login-confirmation-needed' => '@user/login-confirmation-needed.twig',
        'forgot-password'           => '@user/forgot-password.twig',
        'reset-password'            => '@user/reset-password.twig',
        'view'                      => 'userview.html.twig',
        'edit'                      => '@user/edit.twig',
        'list'                      => '@user/list.twig',
    ),

    // Configure the user mailer for sending password reset and email confirmation messages.
    'mailer' => array(
        'enabled' => false, // When false, email notifications are not sent (they're silently discarded).
    ),

    'emailConfirmation' => array(
        'required' => false, // Whether to require email confirmation before enabling new accounts.
        'template' => '@user/email/confirm-email.twig',
    ),

    'passwordReset' => array(
        'template' => '@user/email/reset-password.twig',
        'tokenTTL' => 86400, // How many seconds the reset token is valid for. Default: 1 day.
    ),

    // Set this to use a custom User class.
    'userClass' => 'SimpleUser\User',

    // Whether to require that users have a username (default: false).
    // By default, users sign in with their email address instead.
    'isUsernameRequired' => false,

    // A list of custom fields to support in the edit controller.
    'editCustomFields' => array(),

    // Override table names, if necessary.
    'userTableName' => 'users',
    'userCustomFieldsTableName' => 'user_custom_fields',

    //Override Column names, if necessary
    'userColumns' => array(
        'id'                        => 'id',
        'email'                     => 'email',
        'password'                  => 'password',
        'salt'                      => 'salt',
        'roles'                     => 'roles',
        'name'                      => 'name',
        'time_created'              => 'time_created',
        'username'                  => 'username',
        'isEnabled'                 => 'isEnabled',
        'confirmationToken'         => 'confirmationToken',
        'timePasswordResetRequested' => 'timePasswordResetRequested',
        //Custom Fields
        'user_id'                   => 'user_id',
        'attribute'                 => 'attribute',
        'value'                     => 'value',
    )
    
    )
));

# ----------------------------------------------------
# Swiftmailer service provider
# 
# ---------------------------------------------------


$app->register(new Silex\Provider\SwiftmailerServiceProvider(),array(
    'host' => 'host',
    'port' => '25',
    'username' => 'username',
    'password' => 'password',
    'encryption' => null,
    'auth_mode' => null    
    
));

/*
# ----------------------------------------------------
# Setup Google Safer Browsing Service Provider
# 
# ---------------------------------------------------

$app->register(new UrlShort\GSB\GSB4ugcServiceProvider(), array(
                    'gsb.api.key' => 'ABQIAAAAAq6Cf-1cY46YcDjKhpfAORToonwG5nrJE1m-AitX9sVyRDYycQ'                                            
                    
                ));
*/

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


$app->register(new LaterJobApi\Provider\QueueServiceProvider('urlshort.queue'), array(
              'urlshort.queue.options' => array(
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
# Pdp Url Parser
# 
# ---------------------------------------------------

$app->register(new UrlShort\Pdp\PdpServiceProvider(),array());

# ----------------------------------------------------
# Setup UrlShortner Provider
# 
# ---------------------------------------------------

$app->register(new UrlShort\UrlShortServiceProvider(), array(
                            'urlshort.tablename' => 'url_short_storage'));   


