<?php


namespace Visitmedia\FindologicClient;


class LandingPage
{
    private $link;

    public function __construct($link)
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

}
