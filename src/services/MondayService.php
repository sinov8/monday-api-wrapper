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

    public function makeRequest($query, $variables)
    {

        $request = json_encode([
            'query'     => $query,
            'variables' => $variables,
        ]);

        $response = $this->client->request('POST', $this->baseUri, [
            'headers' => [
                'Authorization' => 'bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json'
            ],
            'body'    => $request
        ]);

        return json_decode($response->getBody()->getContents(), true);

    }

}