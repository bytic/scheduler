<?php

namespace Bytic\Scheduler\Tests;

use Bytic\Scheduler\Helper;

/**
 * Class HelperTest
 * @package Bytic\Scheduler\Tests
 */
class HelperTest extends AbstractTest
{
    public function test_isWindows()
    {
        static::assertFalse(Helper::isWindows(false));
        static::assertFalse(Helper::isWindows());
        static::assertTrue(Helper::isWindows(true));
        static::assertTrue(Helper::isWindows());
    }

    public function test_normalizePath()
    {
        static::assertSame(
            'test',
            Helper::normalizePath('test')
        );

        static::assertSame(
            'dir' . DIRECTORY_SEPARATOR . 'test',
            Helper::normalizePath(['dir', 'test'])
        );

        static::assertSame(
            'dir' . DIRECTORY_SEPARATOR . 'test',
            Helper::normalizePath('dir', 'test')
        );
    }
}
