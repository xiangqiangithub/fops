<?php

namespace fop\Http;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;

class ClientFactory
{
    protected $httpClient;
    public static function create(string $baseUrl,Config $config): ClientInterface
    {
        $stack = HandlerStack::create();
        $stack->push(TaiBaoMiddleware::post());
        $stack->push(TaiBaoMiddleware::sign($config));
        $stack->push(TaiBaoMiddleware::encrypt($config));
        $stack->push(TaiBaoMiddleware::retry());
        $stack->push(TaiBaoMiddleware::response($config));
        return new Client(['base_uri' => $baseUrl,'handler' => $stack]);
    }
}
