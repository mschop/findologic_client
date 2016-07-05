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
        $this->attributes = $type === 'range-slider' ? $this->prepareRangeSliderAttributes($attributes) : $attributes;
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

    /**
     * @param array $attributes
     * @return array
     */
    private function prepareRangeSliderAttributes(array $attributes)
    {
        $attributes['selectedRange']['min'] = $this->getRoundedMin($attributes['stepSize'], $attributes['selectedRange']['min']);
        $attributes['selectedRange']['max'] = $this->getRoundedMin($attributes['stepSize'], $attributes['selectedRange']['max']);
        $attributes['totalRange']['min'] = $this->getRoundedMin($attributes['stepSize'], $attributes['totalRange']['min']);
        $attributes['totalRange']['max'] = $this->getRoundedMax($attributes['stepSize'], $attributes['totalRange']['max']);
        return $attributes;
    }

    private function getRoundedMin($stepSize, $min)
    {
        $factor = $this->getAfterCommaFactor($stepSize);
        return floor($min * $factor) / $factor;
    }

    private function getRoundedMax($stepSize, $max)
    {
        $factor = $this->getAfterCommaFactor($stepSize);
        return ceil($max * $factor) / $factor;
    }

    private function getAfterCommaFactor($stepSize)
    {
        if(!strstr($stepSize, '.')) {
            return 1;
        }
        $splitted = explode('.', $stepSize);
        return pow(10, strlen($splitted[1]));
    }

}
