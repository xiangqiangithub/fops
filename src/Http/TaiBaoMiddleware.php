<?php

namespace fop\Http;


use fop\Http\Response\JsonAdapter;
use fop\Http\Response\XmlAdapter;
use fop\Internal\Util\FopSignature;
use fop\Out\FopOutUtil;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionClass;

class TaiBaoMiddleware
{
    const RETRY_MAX_RETRIES = 1;
    const  RESPONSE_ADAPTER = [
        'json'=>JsonAdapter::class,
        'xml'=>XmlAdapter::class,
    ];
    public static function post(): callable
    {
        return Middleware::mapRequest(function (RequestInterface $request) {
             return $request->getMethod() == 'POST'?$request:false;
        });
    }
    private static function getContent(RequestInterface $request) {
        $contentJson = $request->getBody()->getContents();
        $content = json_decode($contentJson, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            return false;
        }
        $request->getBody()->rewind();
        return $content;
    }
    public static function sign(Config $config): callable
    {
        return Middleware::mapRequest(function (RequestInterface $request) use ($config){
            $headers = [
                'app_id' => $config->getAppId(),
                'api_code'=>$config->getAppCode(),
                'format' => $config->getFormat(),
                'charset' => $config->getCharset(),
                'sign_type' => $config->getSignType(),
                'timestamp' => $config->getTimestamp(),
                'nonce'=> $config->getNonce(),
                'version' => $config->getVersion(),
            ];
            $content = self::getContent($request);
            if(!$content){
                return false;
            }
            $signFields = array_merge($headers, $content);
            $signContent = FopSignature::getSignContent($signFields);
            $headers['sign'] = FopSignature::getSign($config->getRsaPrivateKey(), $signContent);
            foreach ($headers as $key => $value) {
                $request = $request->withAddedHeader($key, $value);
            }
            return $request;
        });
    }
    public static function encrypt(Config $config): callable
    {
        $rsaPublicKey = $config->getRsaPublicKey();
        return Middleware::mapRequest(function (RequestInterface $request) use ($rsaPublicKey) {
            $encrypted = FopOutUtil::respEnc(json_encode(self::getContent($request)),$rsaPublicKey);
            return $request->withBody(Utils::streamFor(json_encode($encrypted)));
        });
    }
    public static function response(Config $config): callable
    {
        $format = strtolower($config->getFormat());
        $rsaPrivateKey = $config->getRsaPrivateKey();
        if(array_key_exists($format, self::RESPONSE_ADAPTER)) {
            return Middleware::mapResponse(
                function (ResponseInterface $response) use ($format, $rsaPrivateKey) {
                    $resp =  (new ReflectionClass(self::RESPONSE_ADAPTER[$format]))->newInstanceArgs([
                        $response->getStatusCode(),
                        $response->getHeaders(),
                        $response->getBody(),
                        $response->getProtocolVersion(),
                        $response->getReasonPhrase()
                    ]);
                    $resp->setRsaPrivateKey($rsaPrivateKey);
                    return $resp;
                });
        }
        return Middleware::mapResponse(function (ResponseInterface $response) {
            return new Response(
                $response->getStatusCode(),
                $response->getHeaders(),
                $response->getBody(),
                $response->getProtocolVersion(),
                $response->getReasonPhrase()
            );
        });
    }
    public static function retry(): callable
    {
        return Middleware::retry(function (
            $retries,
            Request $request,
            Response $response = null,
            RequestException $exception = null
        ) {
            if ($retries >= self::RETRY_MAX_RETRIES) {
                return false;
            }

            if (!($response && $response->getStatusCode() >= 500) || ($exception instanceof ConnectException)) {
                return false;
            }
            return true;
        });
    }
}

