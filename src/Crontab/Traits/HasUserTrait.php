<?php

namespace Bytic\Scheduler\Crontab\Traits;

/**
 * Trait HasUserTrait
 * @package Bytic\Scheduler\Crontab\Traits
 */
trait HasUserTrait
{
    protected $user = null;

    /**
     * @return null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param null $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @param null $user
     * @return null
     */
    public function user($user = null)
    {
        if (!empty($user)) {
            return $user;
        }

        return $this->getUser();
    }
}
