<?php
/* @var $app \Slim\Slim */

/**
 * This is the homepage route, matching GET requests to /
 */
$app->get('/', function() use($app)
{
    $app->render('index.php');
});
