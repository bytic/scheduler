<?php

namespace Bytic\Scheduler\Events\Traits;

/**
 * Class HasWorkingDirectory
 * @package Bytic\Scheduler\Events\Traits
 */
trait HasWorkingDirectory
{
    /**
     * Current working directory.
     *
     * @var string
     */
    protected $cwd = null;

    /**
     * Return the current working directory.
     *
     * @return string
     */
    public function getWorkingDirectory()
    {
        if ($this->cwd === null) {
            $this->initWorkingDirectory();
        }
        return $this->cwd;
    }

    /**
     * Change the current working directory.
     *
     * @param string $directory
     *
     * @return self
     */
    public function in($directory)
    {
        $this->cwd = $directory;
        return $this;
    }

    protected function initWorkingDirectory()
    {
        $this->cwd = false;
    }
}
