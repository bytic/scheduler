<?php

namespace Bytic\Scheduler\Tests\Events\Traits;

use Bytic\Scheduler\Events\Event;
use Bytic\Scheduler\Tests\AbstractTest;

/**
 * Class ManagesFrequenciesTest
 * @package Bytic\Scheduler\Tests\Events\Traits
 */
class ManagesFrequenciesTest extends AbstractTest
{
    public function test_minutes_methods()
    {
        $e = new Event('php foo');
        static::assertEquals('* * * * *', $e->everyMinute()->getExpression());

        $e = new Event('php foo');
        static::assertEquals('*/5 * * * *', $e->everyFiveMinutes()->getExpression());

        $e = new Event('php foo');
        static::assertEquals('*/10 * * * *', $e->everyTenMinutes()->getExpression());

        $e = new Event('php foo');
        static::assertEquals('*/15 * * * *', $e->everyFifteenMinutes()->getExpression());

        $e = new Event('php foo');
        static::assertEquals('0,30 * * * *', $e->everyThirtyMinutes()->getExpression());
    }


    public function test_hours_methods()
    {
        $e = new Event('php foo');
        static::assertEquals('0 * * * *', $e->hourly()->getExpression());

        $e = new Event('php foo');
        static::assertEquals('12 * * * *', $e->hourlyAt('12')->getExpression());

        $e = new Event('php foo');
        static::assertEquals('12,43 * * * *', $e->hourlyAt(['12','43'])->getExpression());
    }

    public function test_days_methods()
    {
        $e = new Event('php foo');
        static::assertEquals('0 0 * * *', $e->daily()->getExpression());

        $e = new Event('php foo');
        static::assertEquals('59 23 * * *', $e->at('23:59')->getExpression());

        $e = new Event('php foo');
        static::assertEquals('45 15 * * *', $e->dailyAt('15:45')->getExpression());

        $e = new Event('php foo');
        static::assertEquals('0 4,8 * * *', $e->twiceDaily(4, 8)->getExpression());
    }

    public function test_month_methods()
    {
        $e = new Event('php foo');
        static::assertEquals('0 0 1 * *', $e->monthly()->getExpression());

        $e = new Event('php foo');
        static::assertEquals('0 0 1 */3 *', $e->quarterly()->getExpression());

        $e = new Event('php bar');
        static::assertEquals('0 0 1 1 *', $e->yearly()->getExpression());
    }

    public function test_week_days_methods()
    {
        $e = new Event('php foo');
        static::assertEquals('* * * * 1-5', $e->weekdays()->getExpression());

        $e = new Event('php foo');
        static::assertEquals('* * * * 0,6', $e->weekends()->getExpression());

        $e = new Event('php foo');
        static::assertEquals('* * * * 1,3,5', $e->dayOfWeek(1,3,5)->getExpression());

        $e = new Event('php foo');
        static::assertEquals('* * * * 1,3,5', $e->days(1,3,5)->getExpression());

        $e = new Event('php foo');
        static::assertEquals('* * * * 1', $e->mondays()->getExpression());

        $e = new Event('php foo');
        static::assertEquals('* * * * 2', $e->tuesdays()->getExpression());

        $e = new Event('php foo');
        static::assertEquals('* * * * 3', $e->wednesdays()->getExpression());

        $e = new Event('php foo');
        static::assertEquals('* * * * 4', $e->thursdays()->getExpression());

        $e = new Event('php foo');
        static::assertEquals('* * * * 5', $e->fridays()->getExpression());

        $e = new Event('php foo');
        static::assertEquals('* * * * 6', $e->saturdays()->getExpression());

        $e = new Event('php foo');
        static::assertEquals('* * * * 0', $e->sundays()->getExpression());
    }
}
