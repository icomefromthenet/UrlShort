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

$app->mount('/shorten/',  new UrlShort\Controller\ShortUrlProvider());
//$app->mount('/shorten/',  new UrlShort\Controller\ShortUrlProvider());

return $app;