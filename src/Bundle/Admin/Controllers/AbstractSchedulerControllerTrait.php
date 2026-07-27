<?php

namespace Bytic\Scheduler\Bundle\Admin\Controllers;

use Bytic\Scheduler\Bundle\Library\View\ViewUtility;

/**
 * Trait AbstractControllerTrait
 *
 * Base controller trait for the scheduler admin bundle.
 * Registers the bundle view paths on the view object provided by the
 * host-application controller.
 *
 * @package Bytic\Scheduler\Bundle\Admin\Controllers
 */
trait AbstractSchedulerControllerTrait
{
    public function bootAbstractSchedulerControllerTrait()
    {
        $this->registerViewPaths($this->getView());
    }

    /**
     * Register admin view paths from the scheduler bundle's resources directory.
     *
     * @param object $view
     * @return void
     */
    public function registerViewPaths($view): void
    {
        if (method_exists(get_parent_class($this), 'registerViewPaths')) {
            parent::registerViewPaths($view);
        }

        ViewUtility::registerViewPaths($view, 'admin');
    }
}
