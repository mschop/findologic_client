<?php


namespace Visitmedia\FindologicClient;


class DefaultFilter implements Filter
{
    private $name;
    private $display;
    private $select;
    private $items;

    public function __construct($name, $display, $select, array $items)
    {
        $this->name = $name;
        $this->display = $display;
        $this->select = $select;
        $this->items = $items;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * @return mixed
     */
    public function getSelect()
    {
        return $this->select;
    }

    /**
     * @return array-of-FilterItem
     */
    public function getItems()
    {
        return $this->items;
    }

}
