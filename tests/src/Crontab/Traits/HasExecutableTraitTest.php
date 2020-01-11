<?php

namespace Bytic\Scheduler\Tests\Crontab\Traits;

use Bytic\Scheduler\Crontab\Crontab;
use Bytic\Scheduler\Tests\AbstractTest;

/**
 * Class HasExecutableTraitTest
 * @package Bytic\Scheduler\Tests\Crontab\Traits
 */
class HasExecutableTraitTest extends AbstractTest
{
    public function test_getExecutable_default()
    {
        $crontab = new Crontab();
        static::assertSame('/usr/bin/crontab', $crontab->getExecutable());
    }

    public function test_getCommand_with_null_user()
    {
        $crontab = new Crontab();
        static::assertSame('/usr/bin/crontab', $crontab->getCommand());
    }

    public function test_getCommand_with_provided_user()
    {
        $crontab = new Crontab();
        static::assertSame('/usr/bin/crontab -u john', $crontab->getCommand('john'));
    }

    public function test_getCommand_with_defined_user()
    {
        $crontab = new Crontab();
        $crontab->setUser('john');
        static::assertSame('/usr/bin/crontab -u john', $crontab->getCommand());
    }

    public function test_getCommand_provided_user_overwrite_defined()
    {
        $crontab = new Crontab();
        $crontab->setUser('john');
        static::assertSame('/usr/bin/crontab -u marco', $crontab->getCommand('marco'));
    }
}
