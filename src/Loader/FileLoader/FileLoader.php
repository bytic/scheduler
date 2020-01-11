<?php

namespace Bytic\Scheduler\Loader\FileLoader;

use Bytic\Scheduler\Scheduler;

/**
 * Class FileLoader
 * @package Bytic\Scheduler\Loader\FileLoader
 */
class FileLoader
{
    /**
     * @param Scheduler $scheduler
     * @return bool
     * @noinspection PhpDocMissingThrowsInspection
     */
    public static function loadEvents(Scheduler $scheduler)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $file = (new FileDetector($scheduler))->getPath();

        /** @noinspection PhpIncludeInspection */
        require_once $file;

        return true;
    }
}
