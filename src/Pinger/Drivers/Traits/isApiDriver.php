<?php

namespace Bytic\Scheduler\Pinger\Drivers\Traits;

/**
 * Trait isApiDriver
 * @package Bytic\Scheduler\Pinger\Drivers\Traits
 */
trait isApiDriver
{
    use HasHttpClient;
    use HasEndpoints;
    use HasUriMethods;
}
