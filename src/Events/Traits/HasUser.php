<?php

namespace Bytic\Scheduler\Events\Traits;

use Bytic\Scheduler\Exception\RuntimeException;
use Bytic\Scheduler\Helper;

/**
 * Trait HasUser
 * @package Bytic\Scheduler\Events\Traits
 */
trait HasUser
{
    /**
     * The user the command should run as.
     *
     * @var string
     */
    protected $user = null;

    /**
     * Set which user the command should run as.
     *
     * @param string $user
     *
     * @return $this
     */
    public function user($user)
    {
        if (Helper::isWindows()) {
            throw new RuntimeException('Changing user on Windows is not implemented.');
        }
        $this->user = $user;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUser()
    {
        return $this->user;
    }
}
