<?php

namespace fop\Http;

use fop\Traits\AppIdTrait;
use GuzzleHttp\Client;

class HttpClient implements HttpClientInterface
{
    private $client;
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    public function post(string $uri, array $json = [], array $query = []): array
    {
        return $this->client->post($uri, compact('json', 'query'))->toArray();
    }
}
