<?php

require_once __DIR__.'/vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}
$client = new GuzzleHttp\Client();
$app = new Laravel\Lumen\Application(realpath(__DIR__));

$app->get('/', function() use ($client) {
    $promises = [
        $client->getAsync('http://openresty_hello'),
        $client->getAsync('http://openresty_world'),
    ];
    /** @var \GuzzleHttp\Psr7\Response[] $results */
    $results = GuzzleHttp\Promise\unwrap($promises);

    return $results[0]->getBody() . ', ' . $results[1]->getBody();
});

$app->run();
