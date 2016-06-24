<?php

/**
 * API Documentation: https://secure.findologic.com/dokuwiki/doku.php?id=fl:integration:request
 */

namespace Visitmedia\FindologicClient;


use InvalidArgumentException;

/**
 * Class SearchRequest
 *
 * Warning !!! Make sure using utf-8 only !!!.
 *
 * @package Visitmedia\FindologicClient
 */
class SearchRequestBuilder
{
    const ORDER_FINDOLOGIC = '';
    const ORDER_PRICE_ASC = 'price ASC';
    const ORDER_PRICE_DESC = 'price DESC';
    const ORDER_LABEL_ASC = 'label ASC';
    const ORDER_LABEL_DESC = 'label DESC';
    const ORDER_SALES_FREQUENCY_ASC = 'salesfrequency ASC';
    const ORDER_SALES_FREQUENCY_DESC = 'salesfrequency DESC';
    const ORDER_DATE_ADDED_ASC = 'dateadded ASC';
    const ORDER_DATE_ADDED_DESC = 'dateadded DESC';
    const MAX_COUNT = 32767;

    private $shopkey;
    private $shopurl;
    private $userip;
    private $referer;
    private $revision;
    private $attrib;
    private $properties = [];

    public function __construct($shopKey, $shopUrl, $userIp, $referer, $revision)
    {
        $this->shopkey = $shopKey;
        $this->shopurl = $shopUrl;
        $this->userip = $userIp;
        $this->referer = $referer;
        $this->revision = $revision;
        $this->attrib = [];
    }

    public function getQueryString()
    {
        return http_build_query(get_object_vars($this));
    }

    /**
     * @param $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * Findologic distinguishes after "diskrete Attribute" and "stetige Attribute".
     * Fixed Attributes are equivalent to "diskrete Attribute"
     * @param $name string
     * @param $value string
     */
    public function setFixedAttribute($name, $value)
    {
        if(!isset($this->attrib[$name])) {
            $this->attrib[$name] = [];
        }
        $this->attrib[$name][] = $value;
    }

    /**
     * Findologic distinguishes after "diskrete Attribute" and "stetige Attribute".
     * Fixed Attributes are equivalent to "stetige Attribute"
     * @param $name string
     * @param $value string
     */
    public function setFluentAttribute($name, $min, $max)
    {
        $this->attrib[$name] = [
            'min' => $min,
            'max' => $max
        ];
    }

    public function setOrder($order)
    {
        $allowedOrders = static::getAllOrderTypes();
        if(!in_array($order, $allowedOrders)) {
            throw new InvalidArgumentException('Invalid order. See constants ORDER_');
        }
        $this->order = $order;
    }

    public static function getAllOrderTypes()
    {
        return [
            static::ORDER_FINDOLOGIC,
            static::ORDER_PRICE_ASC,
            static::ORDER_PRICE_DESC,
            static::ORDER_LABEL_ASC,
            static::ORDER_LABEL_DESC ,
            static::ORDER_SALES_FREQUENCY_ASC,
            static::ORDER_SALES_FREQUENCY_DESC,
            static::ORDER_DATE_ADDED_ASC,
            static::ORDER_DATE_ADDED_DESC,
        ];
    }

    public function addProperty($name) {
        if(!in_array($name, $this->properties)) {
            $this->properties[] = $name;
        }
    }

    public function addProperties(array $names)
    {
        foreach($names as $name) {
            $this->addProperty($name);
        }
    }

    public function restrictCustomerGroups(array $allCustomerGroups)
    {
        $this->group = $allCustomerGroups;
    }

    /**
     * set pagination options
     * @param $first integer first displayed article on page (zero based)
     * @param $count integer amount of articles on the page
     */
    public function setPagination($first, $count)
    {
        if(!is_int($first)) {
            throw new InvalidArgumentException('first must be an integer');
        }

        if(!is_int($count)) {
            throw new InvalidArgumentException('count must be an integer');
        }

        if($first < 0) {
            throw new InvalidArgumentException('first cannot be less than 0');
        }

        if($count < 1) {
            throw new InvalidArgumentException('count cannot be less then 1');
        }

        if($count > static::MAX_COUNT) {
            throw new InvalidArgumentException('count cannot be creater than ' . static::MAX_COUNT);
        }

        $this->first = $first;
        $this->count = $count;
    }

    public function build()
    {
        return SearchRequest::build($this);
    }

}
