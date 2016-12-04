<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/vendor/autoload.php';

// Instantiate the app
$app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Hello, World!");
    return $response;
});
// Run app
$app->run();
