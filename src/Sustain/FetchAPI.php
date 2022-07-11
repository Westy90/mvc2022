<?php

/*
namespace App\Sustain;

use App\Sustain\Sustain;

use Symfony\Contracts\HttpClient\HttpClientInterface; //For API

//https://symfony.com/doc/current/http_client.html#query-string-parameters


class FetchAPI
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchGitHubInformation(): array
    {
        $response = $this->client->request(
            'POST',
            'https://api.scb.se/OV0104/v1/doris/sv/ssd/START/MI/MI1303/BostKollnaraN',
            [{
                "query": [
                  {
                    "code": "Region",
                    "selection": {
                      "filter": "vs:RegionRiket99",
                      "values": [
                        "00"
                      ]
                    }
                  },
                  {
                    "code": "AvstandKoll",
                    "selection": {
                      "filter": "item",
                      "values": [
                        "500"
                      ]
                    }
                  },
                  {
                    "code": "Bostadsbestand",
                    "selection": {
                      "filter": "item",
                      "values": [
                        "100"
                      ]
                    }
                  },
                  {
                    "code": "ContentsCode",
                    "selection": {
                      "filter": "item",
                      "values": [
                        "0000024V"
                      ]
                    }
                  }
                ],
                "response": {
                  "format": "px"
                }
              }]
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $content;
    }
}

// it makes an HTTP GET request to https://httpbin.org/get?token=...&name=...
$response = $client->request('GET', 'https://httpbin.org/get', [
    // these values are automatically encoded before including them in the URL
    'query' => [
        'token' => '...',
        'name' => '...',
    ],
]);
*/