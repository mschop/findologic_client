<?php

namespace Visitmedia\FindologicClient;


interface ISearchResult
{

    /**
     * @return string
     */
    public function getFrontendServer();

    /**
     * @return string
     */
    public function getBackendServer();
}
