<?php

namespace Visitmedia\FindologicClient;

require(__DIR__ . '/../vendor/autoload.php');

use PHPUnit_Framework_TestCase;

class SearchRequestTest extends PHPUnit_Framework_TestCase
{
    private function getMinimalSearchRequestArray()
    {
        return [
            'shopkey' => 'some shop key',
            'shopurl' => 'www.visitmedia.de',
            'userip' => '123.123.123.123',
            'referer' => 'http://www.google.de',
            'revision' => '4.00',
            'attrib' => []
        ];
    }

    /**
     * @return SearchRequestBuilder
     */
    private function getMinimalSearchRequestBuilder()
    {
        $arr = $this->getMinimalSearchRequestArray();
        $searchRequestBuilder = new SearchRequestBuilder(
            $arr['shopkey'],
            $arr['shopurl'],
            $arr['userip'],
            $arr['referer'],
            $arr['revision']
        );
        return $searchRequestBuilder;
    }

    public function test_minimalConfiguration_correctArray()
    {
        $builder = $this->getMinimalSearchRequestBuilder();
        $query = $builder->build()->getQuery();
        parse_str($query, $parsedQuery);
        $diff = array_diff_key($parsedQuery, $this->getMinimalSearchRequestArray());
        $this->assertEmpty($diff);
    }

    public function test_setFixedAttribute_correctArrayContent()
    {
        $builder = $this->getMinimalSearchRequestBuilder();
        $builder->setFixedAttribute('Color', ['Red', 'Blue']);
        $query = $builder->build()->getQuery();
        parse_str($query, $parsedQuery);
        $expected = [
            'Color' => ['Red', 'Blue']
        ];
        $diff = array_diff_key($parsedQuery['attrib'], $expected);
        $this->assertEmpty($diff);
        $this->assertEmpty(array_diff_assoc($parsedQuery['attrib']['Color'], $expected['Color']));
    }

    public function test_setQuery()
    {
        $query = 'some query text';
        $builder = $this->getMinimalSearchRequestBuilder();
        $builder->setQuery($query);
        parse_str($builder->build()->getQuery(), $parsedQuery);
        $this->assertEquals($query, $parsedQuery['query']);
    }

    public function test_setOrder()
    {
        $order = SearchRequestBuilder::ORDER_PRICE_ASC;
        $builder = $this->getMinimalSearchRequestBuilder();
        $builder->setOrder($order);
        $query = $builder->build()->getQuery();
        parse_str($query, $parsedQuery);
        $this->assertEquals($order, $parsedQuery['order']);
    }

    public function test_addProperty()
    {
        $builder = $this->getMinimalSearchRequestBuilder();
        $builder->addProperty('stars');
        $builder->addProperty('stars');
        parse_str($builder->build()->getQuery(), $parsedQuery);
        $this->assertEquals(['stars'], $parsedQuery['properties']);
    }

    public function test_addProperties()
    {
        $builder = $this->getMinimalSearchRequestBuilder();
        $builder->addProperty('stars');
        $properties = ['stars', 'types', 'something'];
        $builder->addProperties($properties);
        parse_str($builder->build()->getQuery(), $parsedQuery);
        $this->assertEquals($properties, $parsedQuery['properties']);
    }

    public function test_restrictCustomerGroups()
    {
        $builder = $this->getMinimalSearchRequestBuilder();
        $builder->restrictCustomerGroups([12, 13]);
        parse_str($builder->build()->getQuery(), $parsedQuery);
        $this->assertEquals([12, 13], $parsedQuery['group']);
    }

    public function test_setPagination()
    {
        $builder = $this->getMinimalSearchRequestBuilder();
        $builder->setPagination(10, 200);
        parse_str($builder->build()->getQuery(), $parsedQuery);
        $this->assertEquals(10, $parsedQuery['first']);
        $this->assertEquals(200, $parsedQuery['count']);
    }

    public function test_setPagination_negativeFirst_throwsException()
    {
        $builder = $this->getMinimalSearchRequestBuilder();
        $this->setExpectedException('InvalidArgumentException');
        $builder->setPagination(-10, 200);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_setPagination_firstNotInt_throwsException()
    {
        $builder = $this->getMinimalSearchRequestBuilder();
        $this->setExpectedException('InvalidArgumentException');
        $builder->setPagination('10', 200);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_setPagination_negativeCount_throwsException()
    {
        $builder = $this->getMinimalSearchRequestBuilder();
        $this->setExpectedException('InvalidArgumentException');
        $builder->setPagination(10, -10);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_setPagination_countIs0_throwsException()
    {
        $builder = $this->getMinimalSearchRequestBuilder();
        $this->setExpectedException('InvalidArgumentException');
        $builder->setPagination(10, 0);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_setPagination_countIsNotInt_throwsException()
    {
        $builder = $this->getMinimalSearchRequestBuilder();
        $this->setExpectedException('InvalidArgumentException');
        $builder->setPagination(10, '10');
    }

    /**
     * Findologic has a maximum value for count. Greater values will be set to maximum.
     * @expectedException \InvalidArgumentException
     */
    public function test_setPagination_countGreaterMaximum_throwsException()
    {
        $builder = $this->getMinimalSearchRequestBuilder();
        $this->setExpectedException('InvalidArgumentException');
        $builder->setPagination(10, SearchRequestBuilder::MAX_COUNT + 1);
    }

    public function test_setPagination_countEqualsMaximum_success()
    {
        $builder = $this->getMinimalSearchRequestBuilder();
        $builder->setPagination(10, SearchRequestBuilder::MAX_COUNT);
        parse_str($builder->build()->getQuery(), $parsedQuery);
        $this->assertEquals(10, $parsedQuery['first']);
        $this->assertEquals(SearchRequestBuilder::MAX_COUNT, $parsedQuery['count']);
    }

}
