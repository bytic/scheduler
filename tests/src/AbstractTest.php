<?php

namespace Bytic\Scheduler\Tests;

use Bytic\Phpqa\PHPUnit\TestCase;

/**
 * Class AbstractTest
 * @package Bytic\Scheduler\Tests
 */
abstract class AbstractTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        @unlink(CACHE_PATH . '/scheduler.php');
    }
}
