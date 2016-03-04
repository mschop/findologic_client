<?php


namespace Visitmedia\FindologicClient;


class Query
{
    private $first;
    private $count;
    private $queryString;
    private $searchedWordCount;
    private $foundWordCount;

    public function __construct($first, $count, $queryString, $searchedWordCount, $foundWordCount)
    {
        $this->first = $first;
        $this->count = $count;
        $this->queryString = $queryString;
        $this->searchedWordCount = $searchedWordCount;
        $this->foundWordCount = $foundWordCount;
    }

    /**
     * @return integer
     */
    public function getFirst()
    {
        return intval($this->first);
    }

    /**
     * @return integer
     */
    public function getCount()
    {
        return intval($this->count);
    }

    /**
     * @return string
     */
    public function getQueryString()
    {
        return $this->queryString;
    }

    /**
     * @return integer
     */
    public function getSearchedWordCount()
    {
        return intval($this->searchedWordCount);
    }

    /**
     * @return integer
     */
    public function getFoundWordCount()
    {
        return intval($this->foundWordCount);
    }


}
