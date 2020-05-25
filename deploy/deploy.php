<?php

namespace Deployer;

require 'recipe/symfony4.php';

inventory('hosts.yml');

// Project name
set('application', function () {
    return getenv('Demo Questionnaire');
});

// Project repository
set('repository', 'https://github.com/artemoliynyk/demo-questionnaire.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys 
add('shared_files', ['']);
add('shared_dirs', []);

set('bin/composer', 'composer');
set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --dev --optimize-autoloader --no-suggest');

// Writable dirs by web server 
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts
host('host_live')->stage('prod');

// Tasks
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:yarn',
    'deploy:vendors',
    'deploy:writable',
    'deploy:cache:clear',
    'deploy:cache:warmup',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);

task('deploy:yarn', function () {
    writeln(run('cd {{release_path}}; yarn install'));
    writeln(run('cd {{release_path}}; yarn encore prod'));
});

task('deploy:doctrine:fixtures', function () {
    writeln(
        run('{{bin/php}} {{bin/console}} doctrine:fixtures:load -n')
    );
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
before('deploy:symlink', 'database:migrate');

//after('database:migrate', 'deploy:doctrine:fixtures');
