<?php

namespace Zinc;

use GuzzleHttp\Client;

class Service
{
    protected $_client;
    private $auth;
    protected $debug = false;

    public function __construct(Client $client, array $auth)
    {
        $this->_client = $client;
        $this->auth = $auth;
    }

    /**
     * 构建request body
     * @param $body
     * @return array
     */
    public function buildRequestOption($body = null): array
    {
        $res = [
            'auth' => $this->auth,
            'debug' => $this->debug
        ];
        if (!empty($body)) {
            $res['body'] = is_array($body) ? json_encode($body) : $body;
        }
        return $res;
    }
}
