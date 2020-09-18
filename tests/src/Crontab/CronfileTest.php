<?php

namespace Bytic\Scheduler\Tests\Crontab;

use Bytic\Scheduler\Crontab\Cronfile;
use Bytic\Scheduler\Exception\InvalidIdentifierException;
use Bytic\Scheduler\Tests\AbstractTest;

/**
 * Class CronfileTest
 * @package Bytic\Scheduler\Tests\Crontab
 */
class CronfileTest extends AbstractTest
{
    public function test_isPresent()
    {
        $cronfile = new Cronfile(
            file_get_contents(TEST_FIXTURE_PATH . '/crontab/default.crontab'),
            '# Begin BYTIC cron generated tasks for [Team] 1',
            '# End BYTIC cron generated tasks for [Team] 2'
        );

        self::assertFalse($cronfile->isPresent());

        $cronfile = new Cronfile(
            file_get_contents(TEST_FIXTURE_PATH . '/crontab/default.crontab'),
            '# Begin BYTIC cron generated tasks for [Team]',
            '# End BYTIC cron generated tasks for [Team]'
        );

        self::assertTrue($cronfile->isPresent());
    }

    public function test_constructor_throws_exception_on_missing_header()
    {
        self::expectException(InvalidIdentifierException::class);

        $cronfile = new Cronfile(
            file_get_contents(TEST_FIXTURE_PATH . '/crontab/default.crontab'),
            '# Begin BYTIC cron generated tasks for [Team] 1',
            '# End BYTIC cron generated tasks for [Team]'
        );
    }

    public function test_constructor_throws_exception_on_missing_footer()
    {
        self::expectException(InvalidIdentifierException::class);

        new Cronfile(
            file_get_contents(TEST_FIXTURE_PATH . '/crontab/default.crontab'),
            '# Begin BYTIC cron generated tasks for [Team]',
            '# End BYTIC cron generated tasks for [Team] 1'
        );
    }

    public function test_updateContent_with_present_content()
    {
        $cronfile = new Cronfile(
            file_get_contents(TEST_FIXTURE_PATH . '/crontab/default.crontab'),
            '# Begin BYTIC cron generated tasks for [Team]',
            '# End BYTIC cron generated tasks for [Team]'
        );

        $cronfile->updateContent('php -v');
        $content = $cronfile->getContent();

        self::assertStringContainsString('php -v', $content);
        self::assertStringContainsString('stats-jobs-process.php', $content);
        self::assertSame(2, substr_count($content, '[Team]'));

        $cronfile->updateContent('php -h');
        $content = $cronfile->getContent();

        self::assertStringContainsString('php -h', $content);
        self::assertStringContainsString('stats-jobs-process.php', $content);
        self::assertSame(2, substr_count($content, '[Team]'));
    }

    public function test_updateContent_with_missing_content()
    {
        $cronfile = new Cronfile(
            file_get_contents(TEST_FIXTURE_PATH . '/crontab/default.crontab'),
            '# Begin BYTIC cron generated tasks for [Register]',
            '# End BYTIC cron generated tasks for [Register]'
        );

        $cronfile->updateContent('php -v');
        $content = $cronfile->getContent();

        self::assertStringContainsString('php -v', $content);
        self::assertStringContainsString('stats-jobs-process.php', $content);
        self::assertSame(2, substr_count($content, '[Register]'));

        $cronfile->updateContent('php -h');
        $content = $cronfile->getContent();

        self::assertStringContainsString('php -h', $content);
        self::assertStringContainsString('stats-jobs-process.php', $content);
        self::assertSame(2, substr_count($content, '[Register]'));
    }
}
