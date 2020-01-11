<?php

namespace Bytic\Scheduler\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTest
 * @package Bytic\Scheduler\Tests
 */
abstract class AbstractTest extends TestCase
{
    public function tearDown()
    {
        parent::tearDown();
        $this->addToAssertionCount(
            \Mockery::getContainer()->mockery_getExpectationCount()
        );
        m::close();
    }
}
