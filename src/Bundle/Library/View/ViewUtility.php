<?php

namespace Bytic\Scheduler\Bundle\Library\View;

use Bytic\Scheduler\Utility\PackagePaths;

/**
 * Class ViewUtility
 * @package Bytic\Scheduler\Bundle\Library\View
 */
class ViewUtility
{
    public const NAME = 'ByticScheduler';

    /**
     * Register view paths for the given module (e.g. "admin") on a view object.
     *
     * @param object $view
     * @param string|null $module
     * @return void
     */
    public static function registerViewPaths($view, $module = null): void
    {
        $path = PackagePaths::resourcesViewsPath($module);
        if ($path !== false) {
            $view->addPath($path);
            $view->addPath($path, self::NAME);
        }
    }
}
