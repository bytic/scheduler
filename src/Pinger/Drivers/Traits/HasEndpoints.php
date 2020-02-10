<?php /** @noinspection PhpDocMissingThrowsInspection */

namespace Bytic\Scheduler\Pinger\Drivers\Traits;

use Bytic\Scheduler\Scheduler;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Trait HasEndpoints
 * @package Bytic\Scheduler\Pinger\Drivers\Traits
 */
trait HasEndpoints
{

    /**
     * Send signed HTTP requests to the API server.
     *
     * @param string $method HTTP method (GET, POST, PUT or DELETE)
     * @param string $path Request path
     * @param null $payload
     * @return string|array
     * @throws \Exception
     */
    public function request($method, $path, $payload = null)
    {
        $request = $this->buildRequest($method, $path, $payload, []);
        $response = $this->executeRequest($request);
        return $this->decodeResponse($response);
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    protected function executeRequest(RequestInterface $request)
    {
        try {
            $response = $this->getClient()->sendRequest($request);
        } catch (\Exception $e) {
            // throw an exception if the http request failed
            throw new \Exception($e->getMessage(), $e->getCode());
        }
        return $response;
    }

    /**
     * @param ResponseInterface $response
     * @return string
     */
    protected function decodeResponse(ResponseInterface $response)
    {
        return (string) $response->getBody();
    }

    /**
     * Build RequestInterface from given params.
     *
     * @param $method
     * @param $path
     * @param $payload
     * @param $headers
     * @return RequestInterface
     */
    public function buildRequest($method, $path, $payload, $headers)
    {
        $requestValues = $this->buildRequestValues($method, $path, $payload, $headers);
        return call_user_func_array([$this, 'buildRequestInstance'], $requestValues);
    }

    /**
     * Builds request values from given params.
     *
     * @param string $method
     * @param string $path
     * @param array  $payload
     * @param array  $headers
     *
     * @return array $requestValues
     */
    protected function buildRequestValues($method, $path, $payload, $headers)
    {
        $method = trim(strtoupper($method));
        $body = $this->getStreamFactory()->createStream('');

        if ($method === 'GET') {
            $params = $payload;
        } else {
            $params = [];
            $body = $payload;
        }

        $url = $this->generateFullUri($path, $params);
        $headers = $this->getHttpHeaders($headers);

        if ('PUT' === $method || 'POST' === $method) {
            $body = $this->getStreamFactory()->createStream(http_build_query($body, '', '&'));
            $headers['Content-Type'] = 'application/x-www-form-urlencoded; charset=utf-8';
        }

        return [
            'method' => $method,
            'url' => $url,
            'body' => $body,
            'headers' => $headers,
        ];
    }

    /**
     * Returns an array for the request headers.
     *
     * @param array $headers - any custom headers for the request
     *
     * @return array $headers - headers for the request
     */
    protected function getHttpHeaders($headers = [])
    {
        $constantHeaders = [
            'User-Agent' => 'bytic-scheduler/' . Scheduler::VERSION,
        ];
        if (method_exists($this, 'getHttpHeadersDefault')) {
            $constantHeaders = array_merge($constantHeaders, $this->getHttpHeadersDefault());
        }

        foreach ($constantHeaders as $key => $value) {
            $headers[$key] = $value;
        }

        return $headers;
    }

    /**
     * Build RequestInterface from given params.
     *
     * @param $method
     * @param $uri
     * @param $headers
     * @param $body
     * @return RequestInterface
     */
    protected function buildRequestInstance($method, $uri, $body,$headers)
    {
        $request = $this->getRequestFactory()->createRequest($method, $uri);

        if ($body) {
            $request = $request->withBody($body);
        }

        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        return $request;
    }
}
