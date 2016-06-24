<?php


namespace Visitmedia\FindologicClient;


class DefaultFilterItem implements FilterItem
{
    private $name;
    private $display;
    private $weight;
    private $image;
    private $frequency;
    private $items;

    /**
     * FilterItem constructor.
     * @param string $name
     * @param float $weight
     * @param int $frequency
     * @param array-of-FilterItem $items
     */
    public function __construct($name, $display, $weight, $frequency, $image, array $items)
    {
        if(!is_int($frequency)) {
            throw new \InvalidArgumentException('frequency has to be int');
        }

        $this->name = $name;
        $this->display = $display;
        $this->weight = $weight;
        $this->frequency = $frequency;
        $this->image = $image;
        $this->items = $items;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return int
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

}
