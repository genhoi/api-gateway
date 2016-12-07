<?php

require __DIR__ . '/vendor/autoload.php';

$loop = React\EventLoop\Factory::create();
$socket = new React\Socket\Server($loop);
$http = new React\Http\Server($socket);
$handler = new \WyriHaximus\React\GuzzlePsr7\HttpClientAdapter($loop);

$client = new \GuzzleHttp\Client();

$app = function ($request, $response) use ($client) {

    $promises = [
        $client->getAsync('http://openresty_hello'),
        $client->getAsync('http://openresty_world'),
    ];
    /** @var \GuzzleHttp\Psr7\Response[] $results */
    $results = GuzzleHttp\Promise\unwrap($promises);

    $responseContent = $results[0]->getBody() . ', ' . $results[1]->getBody();

    $response->writeHead(200, ['Content-Type' => 'text/plain']);
    $response->end($responseContent);
};


$http->on('request', $app);
$socket->listen(80, '0.0.0.0');
$loop->run();