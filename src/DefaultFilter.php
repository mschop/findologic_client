<?php


namespace Visitmedia\FindologicClient;


class DefaultFilter implements Filter
{
    private $name;
    private $type;
    private $display;
    private $select;
    private $items;
    private $attributes;

    public function __construct($name, $type, $display, $select, array $items, array $attributes = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->display = $display;
        $this->select = $select;
        $this->items = $items;
        $this->attributes = $attributes;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getDisplay()
    {
        return $this->display;
    }

    public function getSelect()
    {
        return $this->select;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

}
