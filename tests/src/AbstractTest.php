<?php

namespace Bytic\Scheduler\Tests;

use PHPUnit\Framework\TestCase;
use \Mockery as m;

/**
 * Class AbstractTest
 * @package Bytic\Scheduler\Tests
 */
abstract class AbstractTest extends TestCase
{
    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }
}
