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
    public static function getBasePath()
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
    protected static function detectAppPath()
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

    /**
     * @param mixed ...$parts
     * @return string
     */
    public static function normalizePath(...$parts)
    {
        $path = '';

        if (is_array($parts[0]) && count($parts[0]) > 1) {
            $parts = $parts[0];
        }
        if (count($parts) > 1) {
            $path = implode(DIRECTORY_SEPARATOR, $parts);
        }
        if (is_string($parts[0])) {
            $path = $parts[0];
        }

        return $path;
    }

    /**
     * @param null|boolean $value
     * @return bool
     */
    public static function isWindows($value = null): bool
    {
        static $isWindows = null;

        if (is_bool($value)) {
            $isWindows = $value;
        }
        if ($isWindows === null) {
            $osCode = \mb_substr(
                PHP_OS,
                0,
                3
            );
            $isWindows = 'WIN' === $osCode;
        }
        return $isWindows;
    }
}
