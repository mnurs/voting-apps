<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'https://altoraz@bitbucket.org/altoraz/voting-apps.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('194.163.43.3')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '/home/evotingmunasikastara.site/');

// Hooks

after('deploy:failed', 'deploy:unlock');
