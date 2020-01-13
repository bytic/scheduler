<?php

namespace Deployer;

/*** SCHEDULER PUBLISH***/
desc('Publish schedule events');
task('bytic:scheduler:publish', function () {
    cd('{{release_path}}');

    $byticCmd = get('bytic_get_cmd')('schedule:register', []);

    run($byticCmd);

    cd('{{deploy_path}}');
});