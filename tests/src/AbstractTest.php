<?php

namespace Bytic\Scheduler\Tests;

use Bytic\Phpqa\PHPUnit\TestCase;
use Nip\Config\Config;
use Nip\Container\Utility\Container;

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

    /**
     * @param $file
     * @return void
     */
    protected function loadConfig($file = null)
    {
        $baseDir = TEST_FIXTURE_PATH . '/config';
        $file = $file ?? 'scheduler.php';
        $path = $baseDir . '/' . $file;

        $data = require $path;

        $config = new Config(['scheduler' => $data]);
        Container::container()->set('config', $config);
    }
}
