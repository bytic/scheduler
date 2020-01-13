<?php

namespace Bytic\Scheduler\Tests\Crontab\Traits;

use Bytic\Scheduler\Crontab\Crontab;
use Bytic\Scheduler\Helper;
use Bytic\Scheduler\Tests\AbstractTest;

/**
 * Class HasIdentifierTraitTest
 * @package Bytic\Scheduler\Tests\Crontab\Traits
 */
class HasIdentifierTraitTest extends AbstractTest
{
    public function test_getIdentifier_default()
    {
        $crontab = new Crontab();
        static::assertSame(Helper::getBasePath(), $crontab->getIdentifier());
    }
}
