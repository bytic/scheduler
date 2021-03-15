<?php

use Nip\Cache\Stores\Repository;
use Nip\Container\Container;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

define('TEST_BASE_PATH', realpath(__DIR__));
define('PROJECT_BASE_PATH', dirname(TEST_BASE_PATH));
define('TEST_FIXTURE_PATH', TEST_BASE_PATH . DIRECTORY_SEPARATOR . 'fixtures');

error_reporting(E_ALL);

require PROJECT_BASE_PATH . '/vendor/autoload.php';

\Bytic\Scheduler\Helper::isWindows(false);
define('CACHE_PATH', TEST_BASE_PATH . DIRECTORY_SEPARATOR . 'cache');

$container = new Container();

$adapter = new FilesystemAdapter('', 600, CACHE_PATH);
$store = new Repository($adapter);
$store->clear();
$container->set('cache.store', $store);


Container::setInstance($container);

if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . '.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}
