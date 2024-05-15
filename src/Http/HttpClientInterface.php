<?php

namespace fop\Http;

use Psr\Http\Message\StreamInterface;

interface HttpClientInterface
{
    public function post(string $uri, array $json = [], array $query = []):array;
}
