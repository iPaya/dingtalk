<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\DingTalk;

use iPaya\DingTalk\Api\Api;
use iPaya\DingTalk\Api\Robot;


/**
 * Class Client
 * @package iPaya\DingTalk
 * @method Robot robot()
 */
class Client
{
    /**
     * @var \GuzzleHttp\Client
     */
    public $httpClient;

    private $baseUrl = 'https://oapi.dingtalk.com/';

    /**
     * @param string $name
     * @return Api
     */
    public function api(string $name)
    {
        switch ($name) {
            case 'robot':
                $api = new Robot($this);
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }
        return $api;
    }

    /**
     * @inheritDoc
     */
    public function __call($name, $arguments)
    {
        return $this->api($name);
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient()
    {
        if (!$this->httpClient) {
            $this->httpClient = new \GuzzleHttp\Client([
                'base_uri' => $this->baseUrl,
            ]);
        }
        return $this->httpClient;
    }

}
