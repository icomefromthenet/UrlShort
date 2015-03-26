<?php
# ----------------------------------------------------
# Include Composer  Autoloader
# 
# ---------------------------------------------------

require_once(__DIR__ . "/vendor/autoload.php");

# ----------------------------------------------------
# Setup Silex Application
# 
# ---------------------------------------------------

$app = new Silex\Application();

#------------------------------------------------------------------
# Add Parse for json requests body
#
#------------------------------------------------------------------

$app->before(function (Symfony\Component\HttpFoundation\Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

#------------------------------------------------------------------
# Load the Configuration
#
#------------------------------------------------------------------

require (__DIR__ . "/resources/config/application.php");


#------------------------------------------------------------------
# Setup Routes / Controllers
#
#------------------------------------------------------------------

# Mount LaterJob API for GSB 
$app->mount('/queue', new \LaterJobApi\Controllers\QueueProvider('urlshort.queue.queue'));
$app->mount('/queue', new \LaterJobApi\Controllers\ActivityProvider('urlshort.queue.queue'));
$app->mount('/queue', new \LaterJobApi\Controllers\MonitorProvider('urlshort.queue.queue'));
$app->mount('/queue', new \LaterJobApi\Controllers\ScheduleProvider('urlshort.queue.queue'));

# Mount QuickTag on /tags
$app->mount('/quicktag', new QuickTag\Silex\Controllers\TagProvider('urlshort.quicktag'));

# mount shorten API
$app->mount('/shorten/',  new UrlShort\Controller\ShortUrlProvider());

$app->mount('/admin',new UrlShort\Controller\AdminActionsProvider());

# Mount the user controller routes:
$app->mount('/user', $app['user.provider']);


$app->mount('/',new UrlShort\Controller\GlobalActionsProvider());


return $app;


