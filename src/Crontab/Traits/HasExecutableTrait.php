<?php

namespace Bytic\Scheduler\Crontab\Traits;

/**
 * Trait HasExecutableTrait
 * @package Bytic\Scheduler\Crontab\Traits
 */
trait HasExecutableTrait
{
    /**
     * @var string
     */
    protected $executable = null;

    /**
     * @return string
     */
    public function getExecutable()
    {
        if ($this->executable === null) {
            $this->initExecutable();
        }

        return $this->executable;
    }

    /**
     * @param string $executable
     */
    public function setExecutable($executable)
    {
        $this->executable = $executable;
    }


    protected function initExecutable()
    {
        $this->executable = '/usr/bin/crontab';
    }

}