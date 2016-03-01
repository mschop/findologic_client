<?php

namespace Visitmedia\FindologicClient;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;

class FindologicClient
{

    private $client;
    private $domain;
    private $shopKey;

    const ACTION_SEARCH = 'index';
    const ACTION_ISALIVE = 'alivetest';

    public function __construct(ClientInterface $client, $domain, $shopKey)
    {
        $this->client = $client;
        $this->domain = $domain;
        $this->shopKey = $shopKey;
    }

    /**
     * @throws RequestException
     * @return bool
     */
    public function isAlive()
    {
        $response = $this->client->get($this->createRequestUrl(static::ACTION_ISALIVE, [shopkey => $this->shopKey]));
        return $response->getBody() === 'alive';
    }

    /**
     * @throws RequestException
     * @param SearchRequest $searchRequest
     * @return SearchResult
     */
    public function sendSearchRequest(SearchRequest $searchRequest)
    {
        $requestUrl = $this->createRequestUrl(static::ACTION_SEARCH) . '?' . $searchRequest->getQuery();
        $response = $this->client->get($requestUrl);
        return new SearchResult($response->getBody());
    }

    private function createRequestUrl($action)
    {
        return 'https://service.findologic.com/ps/' . $this->domain . '/' . $action . '.php';
    }

}
