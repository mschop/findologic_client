<?php

namespace Visitmedia\FindologicClient;

require_once(__DIR__ . '/../vendor/autoload.php');

class SetupTest extends \PHPUnit_Framework_TestCase
{
    public function test_setup()
    {
        $setup = new Setup();
        $this->assertTrue(true);
    }
}
