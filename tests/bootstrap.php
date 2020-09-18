<?php

define('TEST_BASE_PATH', realpath(__DIR__));
define('PROJECT_BASE_PATH', dirname(TEST_BASE_PATH));
define('TEST_FIXTURE_PATH', TEST_BASE_PATH . DIRECTORY_SEPARATOR . 'fixtures');

error_reporting(E_ALL);

require PROJECT_BASE_PATH . '/vendor/autoload.php';

\Bytic\Scheduler\Helper::isWindows(false);
define('CACHE_PATH', TEST_BASE_PATH . DIRECTORY_SEPARATOR . 'cache');

if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . '.env')) {
    $dotenv = new Dotenv\Dotenv(__DIR__);
    $dotenv->load();
}
