<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\DingTalk\Api;


use iPaya\DingTalk\Client;
use iPaya\DingTalk\HttpClient\ResponseMediator;

abstract class Api
{
    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $path
     * @param array $parameters
     * @param array $headers
     * @return array|string
     */
    public function get(string $path, array $parameters = [], array $headers = [])
    {
        $response = $this->client->getHttpClient()->get($path, [
            'query' => $parameters,
            'headers' => $headers,
        ]);

        return ResponseMediator::getContents($response);
    }

    /**
     * @param string $path
     * @param array $data
     * @param array $headers
     * @return array|string
     */
    public function post(string $path, array $data = [], array $headers = [])
    {
        $response = $this->client->getHttpClient()->post($path, [
            'form_params' => $data,
            'headers' => $headers,
        ]);

        return ResponseMediator::getContents($response);
    }

    /**
     * @param string $path
     * @param mixed $json
     * @param array $headers
     * @return array|string
     */
    public function postJson(string $path, $json, array $headers = [])
    {
        $response = $this->client->getHttpClient()->post($path, [
            'json' => $json,
            'headers' => $headers,
        ]);

        return ResponseMediator::getContents($response);
    }
}
