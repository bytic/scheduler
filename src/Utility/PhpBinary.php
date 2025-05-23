<?php

namespace Bytic\Scheduler\Utility;

use ByTIC\Console\Application;

/**
 *
 */
class PhpBinary
{
    public const PHP_7_4 = '/usr/bin/php7.4';
    public const PHP_8_0 = '/usr/bin/php8.0';
    public const PHP_8_1 = '/usr/bin/php8.1';
    public const PHP_8_2 = '/usr/bin/php8.2';
    public const PHP_8_3 = '/usr/bin/php8.3';
    public const PHP_8_4 = '/usr/bin/php8.4';

    /**
     * @param $bin
     * @return string
     */
    public static function get($bin = null): string
    {
        if ($bin === null) {
            $bin = Application::phpBinary();
        }
//        if (@is_executable($bin)) {
        return $bin;
//        }
//        throw new \Exception('PHP binary not found: ' . $bin);
    }
}