<?php


namespace Visitmedia\FindologicClient;


class DefaultFilter implements Filter
{
    private $name;
    private $type;
    private $display;
    private $select;
    private $items;

    public function __construct($name, $type, $display, $select, array $items)
    {
        $this->name = $name;
        $this->type = $type;
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

    public function getType()
    {
        return $this->getType();
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
