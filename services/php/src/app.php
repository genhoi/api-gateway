<?php

require __DIR__ . '/vendor/autoload.php';

$client = new GuzzleHttp\Client();

$promises = [
    $client->getAsync('http://openresty_hello'),
    $client->getAsync('http://openresty_world'),
];
/** @var \GuzzleHttp\Psr7\Response[] $results */
$results = GuzzleHttp\Promise\unwrap($promises);

$responseContent = $results[0]->getBody() . ', ' . $results[1]->getBody();

http_response_code(200);
echo $responseContent;