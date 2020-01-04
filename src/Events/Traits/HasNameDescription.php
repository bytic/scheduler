<?php

namespace Bytic\Scheduler\Events\Traits;

/**
 * Trait HasNameDescription
 * @package Bytic\Scheduler\Events\Traits
 */
trait HasNameDescription
{
    /**
     * The human readable description of the event.
     *
     * @var string
     */
    public $description;

    /**
     * Set the human-friendly description of the event.
     *
     * @param string $description
     * @return $this
     */
    public function name($description)
    {
        return $this->description($description);
    }

    /**
     * Set the human-friendly description of the event.
     *
     * @param string $description
     * @return $this
     */
    public function description($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get the summary of the event for display.
     *
     * @return string
     */
    public function getSummaryForDisplay()
    {
        if (is_string($this->description)) {
            return $this->description;
        }
        return $this->getCommand();
    }
}