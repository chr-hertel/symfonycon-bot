<?php

namespace Deployer;

require 'recipe/symfony.php';

// Config
set('repository', 'git@github.com:chr-hertel/symfonycon-bot.git');
set('composer_options', '--no-dev --verbose --prefer-dist --optimize-autoloader --no-progress --no-interaction --no-scripts');
set('console_options', '--no-interaction --env=prod');
set('shared_files', [
    '.env.local',
    'data.db',
]);

// Hosts
host('stof.fail')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '/var/www/symfonycon-bot');

// Tasks
task('build', function () {
    cd('{{release_path}}');
    run('{{bin/console}} dotenv:dump {{console_options}}');
});

after('deploy:cache:clear', 'build');
after('deploy:cache:clear', 'database:migrate');
after('deploy:failed', 'deploy:unlock');
