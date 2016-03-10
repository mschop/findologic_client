<?php


namespace Visitmedia\FindologicClient;

use \SimpleXML;

class SearchResult implements ISearchResult
{
    private $raw;

    public function __construct($xml)
    {
        $this->raw = new \SimpleXMLElement($xml);
    }

    /**
     * @return string
     */
    public function getFrontendServer()
    {
        return (string)$this->raw->servers->frontend;
    }

    /**
     * @return string
     */
    public function getBackendServer()
    {
        return (string)$this->raw->servers->backend;
    }

    /**
     * @return Query
     */
    public function getQuery()
    {
        return new Query(
            $this->raw->query->limit['first'],
            $this->raw->query->limit['count'],
            $this->raw->query->queryString,
            $this->raw->query->searchedWordCount,
            $this->raw->query->foundWordCount
        );
    }

    /**
     * @return LandingPage|null
     */
    public function getLandingPage()
    {
        if($this->raw->landingPage) {
            return new LandingPage($this->raw->landingPage['link']);
        }
        return null;
    }

    /**
     * @return Promotion|null
     */
    public function getPromotion()
    {
        if($this->raw->promotion) {
            return new Promotion($this->raw->promotion['link'], $this->raw->promotion['image']);
        }
        return null;
    }

    /**
     * @return integer
     */
    public function getResultAmount()
    {
        return intval($this->raw->results->count);
    }

    /**
     * @return array-of-Product
     */
    public function getProducts()
    {
        $products = [];
        foreach($this->raw->products->product as $rawProduct) {
            $properties = [];
            foreach($rawProduct->properties->property as $rawProperty) {
                $properties[$rawProduct['name']] = (string)$rawProperty;
            }
            $products[] = new Product($rawProduct['id'], $rawProduct['direct'], $properties);
        }
        return $products;
    }

    /**
     * @return array-of-Filter
     */
    public function getFilters()
    {
        $filters = [];
        foreach($this->raw->filters->filter as $rawFilter) {
            $filters[] = new DefaultFilter((string)$rawFilter->name, (string)$rawFilter->display, (string)$rawFilter->select, $this->getItems($rawFilter));
        }
        return $filters;
    }

    private function getItems($node)
    {
        $items = [];
        if($node->items) {
            foreach($node->items->item as $rawItem) {
                $name = (string)$rawItem->name;
                $display = isset($rawItem->display) ? (string)$rawItem->display : 'default';
                $weight = floatval($rawItem->weight);
                $frequency = intval($rawItem->frequency);
                $image = isset($rawItem->image) ? (string)$rawItem->image : '';
                $items[] = new DefaultFilterItem($name, $display, $weight, $frequency, $image, $this->getItems($rawItem));
            }
        }
        return $items;
    }



}
