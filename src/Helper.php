<?php

namespace Bytic\Scheduler;

/**
 * Class Helper
 * @package Bytic\Scheduler
 */
class Helper
{
    /**
     * @var null|string
     */
    protected static $basePath = null;

    /**
     * @return null|string
     */
    static public function getBasePath()
    {
        if (static::$basePath === null) {
            static::$basePath = static::detectAppPath();
        }
        return static::$basePath;
    }

    /**
     * @param string|null $basePath
     */
    public static function setBasePath(string $basePath)
    {
        self::$basePath = $basePath;
    }

    /**
     * @return null|string
     */
    static protected function detectAppPath()
    {
        $basePath = __DIR__;

        $maxStep = 5;
        $step = 0;
        while ($step <= $maxStep) {
            $basePath = dirname($basePath) . DIRECTORY_SEPARATOR;
            if (file_exists($basePath . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php')) {
                return $basePath;
            }
            $step++;
        }
        return null;
    }
}