<?php

namespace Bytic\Scheduler\Tests\Scheduler\Traits;

use Bytic\Scheduler\Scheduler;
use Bytic\Scheduler\Tests\AbstractTest;

/**
 * Class HasIdentifierTraitTest
 * @package Bytic\Scheduler\Tests\Scheduler\Traits
 */
class HasIdentifierTraitTest extends AbstractTest
{
    public function test_getIdentifier()
    {
        /** @var Scheduler|\Mockery\MockInterface| $scheduler */
        $scheduler = \Mockery::mock(Scheduler::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $scheduler->shouldReceive('getConfigBase')->with('scheduler.name', \Mockery::any())->andReturn('my-name');

        self::assertSame('my-name', $scheduler->getIdentifier());
    }
}
