<?php
/**
 * Created by PhpStorm.
 * User: m.schophaus
 * Date: 10.03.2016
 * Time: 22:31
 */

namespace Visitmedia\FindologicClient;


interface FilterItem
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return float
     */
    public function getWeight();

    /**
     * @return int
     */
    public function getFrequency();

    /**
     * @return array
     */
    public function getItems();
}
