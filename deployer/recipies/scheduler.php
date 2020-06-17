<?php

namespace Deployer;

/*** SCHEDULER PUBLISH***/
desc('Publish schedule events');
task('bytic:scheduler:publish', function () {
    cd('{{release_path}}');

    $bytic = get('bin/bytic');
    $byticCmd = "$bytic schedule:register";

    run($byticCmd);

    cd('{{deploy_path}}');
});
