<?php

namespace Deployer;

/*** SCHEDULER PUBLISH***/
desc('npm in all submodules');
task('bytic:scheduler:publish', function () {
    cd('{{release_path}}');

    $byticCmd = get('bytic_get_cmd')('scheduler:publish', []);

    run($byticCmd);

    cd('{{deploy_path}}');
});