<?php

$scheduler = $scheduler ?? scheduler();

// Run a simple command
$scheduler->run('php foe')
    ->using('crontab');
