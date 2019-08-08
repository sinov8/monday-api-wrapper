<?php

namespace sinov8\MondayApiWrapper\services;

use GuzzleHttp\Client;

class MondayService
{

    protected $baseUri;
    protected $apiKey;
    public $client;

    public function __construct($baseUri, $apiKey)
    {
        $this->baseUri = $baseUri;
        $this->apiKey = $apiKey;
        $this->client = $this->setupApiClient();
    }

    private function setupApiClient()
    {
        return new Client([
            'base_uri' => $this->baseUri,
            'defaults' => [
                'timeout'      => 10.0,
                'content-type' => 'application/json',
                'Accept'       => 'application/json',
            ]
        ]);
    }

}