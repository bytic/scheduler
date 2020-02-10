<?php

$scheduler = isset($scheduler) ? $scheduler : scheduler();

// Run a simple command
$scheduler->run('php foe')
    ->using('crontab');
