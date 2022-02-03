<?php

namespace Bytic\Scheduler\Utility;

use Bytic\Scheduler\SchedulerServiceProvider;
use Exception;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class PackageConfig.
 */
class PackageConfig extends \ByTIC\PackageBase\Utility\PackageConfig
{
    use SingletonTrait;

    protected $name = SchedulerServiceProvider::NAME;

    /**
     * @throws Exception
     */
    public static function phpBin($default = null): ?string
    {
        return static::instance()->get('php_bin', $default);
    }

}
