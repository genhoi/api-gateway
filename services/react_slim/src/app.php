<?php

require __DIR__ . '/vendor/autoload.php';

use \mbarquin\reactSlim;

// We keep a new Slim app instance.
$app = new \Slim\App();
$client = new \GuzzleHttp\Client();


// We add a closure to attend defined request routes
$app->any('/', function (\Slim\Http\Request $request, \Slim\Http\Response $response) use ($client) {

    $promises = [
        $client->getAsync('http://openresty_hello'),
        $client->getAsync('http://openresty_world'),
    ];
    /** @var \GuzzleHttp\Psr7\Response[] $results */
    $results = GuzzleHttp\Promise\unwrap($promises);

    $response->getBody()->write(
        $results[0]->getBody() . ', ' . $results[1]->getBody()
    );
    return $response;
});

$server = new \mbarquin\reactSlim\Server();

$server->withHost('0.0.0.0')->withPort(80)->run($app);