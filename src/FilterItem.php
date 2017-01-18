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
     * returns the subitems of this item (only relevant for nested filters e.g. the category filter)
     *
     * @return array
     */
    public function getItems();

    /**
     * returns the hex color code, specified in the Findologic backend
     *
     * @return string|null
     */
    public function getColor();

    /**
     * returnes the image path defined in the Findologic backend
     *
     * @return string|null
     */
    public function getImage();
}
