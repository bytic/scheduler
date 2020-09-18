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
    use \Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    protected function setUp(): void
    {
        parent::setUp();

        \Nip\Container\Container::setInstance(new \Nip\Container\Container());
        @unlink(CACHE_PATH . '/scheduler.php');
    }
}
