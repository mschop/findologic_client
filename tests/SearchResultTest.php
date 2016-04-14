<?php
/**
 * Created by PhpStorm.
 * User: m.schophaus
 * Date: 24.02.2016
 * Time: 09:59
 */

namespace Visitmedia\FindologicClient;


class SearchResultTest extends \PHPUnit_Framework_TestCase
{

    public function getSearchResultAsSimpleXml()
    {
        return new \SimpleXMLElement(file_get_contents(__DIR__ . '/assets/search_result.xml'));
    }

    public function getSearchResult()
    {
        return new SearchResult(file_get_contents(__DIR__ . '/assets/search_result.xml'));
    }

    public function test_getFrontendServer()
    {
        $this->assertSame('frontend.findologic.com', $this->getSearchResult()->getFrontendServer());
    }

    public function test_getBackendServer()
    {
        $this->assertSame('backend.findologic.com', $this->getSearchResult()->getBackendServer());
    }

    public function test_getQuery()
    {
        $query = $this->getSearchResult()->getQuery();
        $this->assertEquals(0, $query->getFirst());
        $this->assertEquals(10, $query->getCount());
        $this->assertEquals('Test', $query->getQueryString());
        $this->assertEquals(1, $query->getSearchedWordCount());
        $this->assertEquals(1, $query->getFoundWordCount());
    }

    public function test_getLandingPage_hasLandingPage_returnsLandingPage()
    {
        $landingPage = $this->getSearchResult()->getLandingPage();
        $this->assertNotNull($landingPage);
        $this->assertEquals('http://www.example.com/imprint', $landingPage->getLink());
    }

    public function test_getLandingPage_missingLandingPage_returnsNull()
    {
        $rawSearchResult = $this->getSearchResultAsSimpleXml();
        unset($rawSearchResult->landingPage);
        $searchResult = new SearchResult($rawSearchResult->asXML());
        $this->assertNull($searchResult->getLandingPage());
    }

    public function test_getPromotion_hasPromotion_returnsPromotion()
    {
        $promotion = $this->getSearchResult()->getPromotion();
        $this->assertNotNull($promotion);
        $this->assertEquals('http://www.example.com/special-offer', $promotion->getLink());
        $this->assertEquals('http://www.example.com/special-offer.jpg', $promotion->getImage());
    }

    public function test_getPromotion_missingPromotion_returnsNull()
    {
        $rawSearchResult = $this->getSearchResultAsSimpleXml();
        unset($rawSearchResult->promotion);
        $searchResult = new SearchResult($rawSearchResult->asXML());
        $this->assertNull($searchResult->getPromotion());
    }

    public function test_getResultAmount()
    {
        $this->assertEquals(2, $this->getSearchResult()->getResultAmount());
    }

    public function test_getProducts()
    {
        $searchResult = $this->getSearchResult();
        $products = $searchResult->getProducts();
        $this->assertCount(2, $products);
        $this->assertEquals('666', $products[0]->getId());
        $this->assertEquals('123', $products[1]->getId());
        $this->assertEquals('1', $products[0]->getDirect());
        $this->assertEquals('2', $products[1]->getDirect());

        $this->assertCount(1, $products[0]->getProperties());
        $this->assertCount(1, $products[1]->getProperties());
    }

    public function test_getFilters()
    {
        $searchResult = $this->getSearchResult();
        $filters = $searchResult->getFilters();
        $this->assertCount(3, $filters);
        $this->assertEquals('cat', $filters[0]->getName());
        $this->assertEquals('Kategorie', $filters[0]->getDisplay());
        $this->assertEquals('multiple', $filters[0]->getSelect());
        $items = $filters[0]->getItems();
        $this->assertCount(1, $items);
        $this->assertCount(1, $filters[0]->getItems()[0]->getItems());
        $this->assertEquals('Unteruntergruppe', $filters[0]->getItems()[0]->getItems()[0]->getName());

        $this->assertEquals('10', $filters[2]->getAttributes()['selectedRange']['min']);
    }

}
