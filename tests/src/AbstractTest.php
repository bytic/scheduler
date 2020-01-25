<?php

namespace Bytic\Scheduler\Tests;

use Mockery as m;
use Nip\Container\Container;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTest
 * @package Bytic\Scheduler\Tests
 */
abstract class AbstractTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        \Nip\Container\Container::setInstance(new \Nip\Container\Container());
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->addToAssertionCount(
            \Mockery::getContainer()->mockery_getExpectationCount()
        );
        m::close();
    }
}
