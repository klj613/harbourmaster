<?php
/* @var $app \Slim\Slim */

$app->error(function () use ($app) {
	$app->status(500);
	$app->render('errors/500.php');
});
$app->notFound(function () use ($app) {
    $app->status(404);
    $app->render('errors/404.php');
});