<?php

namespace Bytic\Scheduler\Utility;

use Nip\Utility\Traits\SingletonTrait;

/**
 * Class PackageConfig.
 */
class PackagePaths
{

    public static function configPath(): string
    {
        return static::basePath('config/scheduler.php');
    }

    public static function basePath($path = null): string
    {
        return __DIR__ . '/../../' . ($path ?? '');
    }

    public static function migrationsPath(): string
    {
        return static::basePath('database/migrations');
    }

    /**
     * @param $path
     * @return string
     */
    public static function resourcesPath($path = null): string
    {
        return static::basePath('resources' . ($path ? '/' . $path : ''));
    }

    public static function resourcesViewsPath($path = null): string
    {
        return static::basePath('resources/views' . ($path ? '/' . $path : ''));
    }
}
