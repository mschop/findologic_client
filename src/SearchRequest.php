<?php


namespace Visitmedia\FindologicClient;


class SearchRequest
{
    private $query;

    private function __construct($query)
    {
        $this->query = $query;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public static function build(SearchRequestBuilder $searchRequestBuilder)
    {
        return new SearchRequest($searchRequestBuilder->getQueryString());
    }
}
