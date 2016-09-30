<?php

namespace Visitmedia\FindologicClient;


interface Filter
{
    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return mixed
     */
    public function getDisplay();

    /**
     * @return mixed
     */
    public function getSelect();

    /**
     * @return string
     */
    public function getClass();

    /**
     * @return array-of-FilterItem
     */
    public function getItems();

    /**
     * @return array
     */
    public function getAttributes();
}
