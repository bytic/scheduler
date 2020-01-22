<?php

define('TEST_BASE_PATH', realpath(__DIR__));
define('PROJECT_BASE_PATH', dirname(TEST_BASE_PATH));
define('TEST_FIXTURE_PATH', TEST_BASE_PATH . DIRECTORY_SEPARATOR . 'fixtures');

require PROJECT_BASE_PATH . '/vendor/autoload.php';

\Bytic\Scheduler\Helper::isWindows(false);
define('CACHE_PATH', TEST_FIXTURE_PATH . DIRECTORY_SEPARATOR . 'cache');

\Nip\Container\Container::setInstance(new \Nip\Container\Container());
