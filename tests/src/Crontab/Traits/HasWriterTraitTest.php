<?php

namespace Bytic\Scheduler\Tests\Crontab\Traits;

use Bytic\Scheduler\Crontab\Crontab;
use Bytic\Scheduler\Tests\AbstractTest;
use Mockery;
use Symfony\Component\Process\Process;

/**
 * Class HasWriterTraitTest
 * @package Bytic\Scheduler\Tests\Crontab\Traits
 */
class HasWriterTraitTest extends AbstractTest
{
    public function test_write()
    {
        /** @var Crontab|\Mockery\MockInterface $crontab */
        $crontab = Mockery::mock(Crontab::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $crontab->shouldReceive('readRaw')->withArgs(['john'])->andReturn('');

        $crontab->shouldReceive('runCommand')
            ->once()
            ->andReturn(new Process(['dev/null']))
            ->with(\Mockery::on(function ($argument) {
                if (!file_exists($argument)) {
                    return false;
                }
                $content = file_get_contents($argument);
                self::assertStringContainsString('# Begin BYTIC cron generated tasks for', $content);
                self::assertStringContainsString('[[[TEST]]]', $content);
                self::assertStringContainsString('# End BYTIC cron generated tasks for', $content);
                return true;
            }));
        $crontab->write('[[[TEST]]]', 'john');
    }
}
