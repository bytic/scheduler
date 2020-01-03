<?php

$scheduler = isset($scheduler) ? $scheduler : scheduler();

$scheduler->run('php foe')
    ->using('crontab');
