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
# Setup UrlShortner Provider
# 
# ---------------------------------------------------

$app->register(new UrlShort\UrlShortServiceProvider(), array());


# ----------------------------------------------------
# Laterjob Processing Queue
# 
# ---------------------------------------------------

$app->register(new UrlShort\UrlShortServiceProvider(), array());

