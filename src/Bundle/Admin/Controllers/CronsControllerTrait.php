<?php

namespace Bytic\Scheduler\Bundle\Admin\Controllers;

use Bytic\Scheduler\Bundle\Library\View\ViewUtility;
use Bytic\Scheduler\Events\Event;

/**
 * Trait CronsControllerTrait
 *
 * Provides admin actions for listing, viewing, pausing, and resuming
 * scheduled cron events.  Intended to be used by a host-application
 * controller that also implements the Nip controller contract.
 *
 * @package Bytic\Scheduler\Bundle\Admin\Controllers
 */
trait CronsControllerTrait
{
    use AbstractControllerTrait;

    /**
     * List all registered cron events.
     *
     * @return void
     */
    public function index(): void
    {
        $scheduler = scheduler();
        $events    = $scheduler->getEvents();

        $eventsWithStatus = [];
        foreach ($events as $event) {
            $driver   = $scheduler->getDriver($event->getDriver());
            $isInstalled = $driver->isInstalled($event->getIdentifier());
            $isPaused = $isInstalled && $driver->isPaused($event->getIdentifier());
            $eventsWithStatus[] = [
                'event'       => $event,
                'isInstalled' => $isInstalled,
                'isPaused'    => $isPaused,
                'status'      => $this->resolveEventStatus($isInstalled, $isPaused),
            ];
        }

        $this->payload()->with(['events' => $eventsWithStatus]);
    }

    /**
     * Show the details of a single cron event.
     *
     * @return void
     */
    public function view(): void
    {
        $event = $this->getEventFromRequest();
        if ($event === null) {
            return;
        }

        $scheduler = scheduler();
        $driver    = $scheduler->getDriver($event->getDriver());
        $isInstalled = $driver->isInstalled($event->getIdentifier());
        $isPaused = $isInstalled && $driver->isPaused($event->getIdentifier());

        $this->payload()->with([
            'event'       => $event,
            'isInstalled' => $isInstalled,
            'isPaused'    => $isPaused,
            'status'      => $this->resolveEventStatus($isInstalled, $isPaused),
        ]);
    }

    /**
     * Pause a cron event via its driver.
     *
     * @return void
     */
    public function pause(): void
    {
        $event = $this->getEventFromRequest();
        if ($event === null) {
            return;
        }

        $scheduler = scheduler();
        $driver    = $scheduler->getDriver($event->getDriver());
        $driver->pause($event->getIdentifier());

        $this->flashRedirect(
            'Cron "' . $event->getSummaryForDisplay() . '" has been paused.',
            $this->buildEventUrl($event, 'view'),
            'success'
        );
    }

    /**
     * Resume a previously paused cron event via its driver.
     *
     * @return void
     */
    public function resume(): void
    {
        $event = $this->getEventFromRequest();
        if ($event === null) {
            return;
        }

        $scheduler = scheduler();
        $driver    = $scheduler->getDriver($event->getDriver());
        $driver->resume($event->getIdentifier());

        $this->flashRedirect(
            'Cron "' . $event->getSummaryForDisplay() . '" has been resumed.',
            $this->buildEventUrl($event, 'view'),
            'success'
        );
    }

    /**
     * Retrieve the Event identified by the "identifier" query/route parameter.
     * On failure a 404 response is triggered and null is returned.
     *
     * @return Event|null
     */
    protected function getEventFromRequest(): ?Event
    {
        $identifier = $this->getRequest()->get('identifier');
        $events     = scheduler()->getEvents();

        if (isset($events[$identifier])) {
            return $events[$identifier];
        }

        $this->error404();
        return null;
    }

    /**
     * Build a URL pointing to a given action for an event.
     * Host applications may override this to match their routing scheme.
     *
     * @param Event  $event
     * @param string $action
     * @return string
     */
    protected function buildEventUrl(Event $event, string $action): string
    {
        return '?action=' . $action . '&identifier=' . urlencode($event->getIdentifier());
    }

    /**
     * @param bool $isInstalled
     * @param bool $isPaused
     * @return string
     */
    protected function resolveEventStatus(bool $isInstalled, bool $isPaused): string
    {
        if ($isInstalled === false) {
            return 'not_installed';
        }

        return $isPaused ? 'paused' : 'active';
    }
}
