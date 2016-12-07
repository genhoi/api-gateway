<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/vendor/autoload.php';

$client = new GuzzleHttp\Client();

// Instantiate the app
$app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);
$app->get('/', function (Request $request, Response $response) use ($client) {

    $promises = [
        $client->getAsync('http://openresty_hello'),
        $client->getAsync('http://openresty_world'),
    ];
    /** @var \GuzzleHttp\Psr7\Response[] $results */
    $results = GuzzleHttp\Promise\unwrap($promises);

    $response->getBody()->write($results[0]->getBody() . ', ' . $results[1]->getBody());
    return $response;
});
// Run app
$app->run();
