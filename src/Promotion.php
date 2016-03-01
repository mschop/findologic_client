<?php


namespace Visitmedia\FindologicClient;


class Promotion
{
    private $link;
    private $promotion;

    public function __construct($link, $promotion)
    {
        $this->link = $link;
        $this->promotion = $promotion;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->promotion;
    }

}
