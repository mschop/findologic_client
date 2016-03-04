<?php


namespace Visitmedia\FindologicClient;


class Product
{
    private $id;
    private $direct;
    private $properties;

    /**
     * Product constructor.
     * @param $id
     * @param $direct
     * @param array $properties
     */
    public function __construct($id, $direct, array $properties)
    {
        $this->id = $id;
        $this->direct = $direct;
        $this->properties = $properties;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDirect()
    {
        return $this->direct;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

}
