<?php
/* @var $app \Slim\Slim */

$app->get('/', function() use($app)
{
    $app->render('index.php');
});
