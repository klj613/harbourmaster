<?php
$appSettings = array(
    'routeCacheTtl' => 3600,
);

require '../library/Ship/Autoloader.php';
require '../vendor/autoload.php';

ini_set('default_charset', 'UTF-8');
ini_set('display_errors', '1');
date_default_timezone_set('UTC');
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_cache_limiter(false);
session_start();

defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../app'));
defined('APPLICATION_ENV') || define('APPLICATION_ENV', getenv('APPLICATION_ENV'));

set_include_path(
    implode(
        PATH_SEPARATOR,
        array(
            realpath(APPLICATION_PATH . '/../library'),
            realpath(APPLICATION_PATH . '/../vendor'),
            get_include_path()
        )
    )
);

spl_autoload_extensions('.php');
spl_autoload_register();

\Slim\Slim::registerAutoloader();
\Ship\Autoloader::getInstance();

$app = new \Slim\Slim(array(
        'debug' => true,
        'log.level' => \Slim\Log::DEBUG,
        'log.enabled' => true,
        'templates.path' => APPLICATION_PATH . '/views/'
));

// Routes are automatically loaded into
\Ship\Loader\Routes::loadOrCache(
    realpath(APPLICATION_PATH . '/routes/'),
    $app,
    APPLICATION_PATH.'/../writable/cache',
    $appSettings['routeCacheTtl']
);

$app->run();
