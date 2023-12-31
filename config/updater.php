<?php

// config for Salahhusa9/Updater
return [

    'git_path' => null,

    'repository_source' => \App\Service\GitlabRepository::class,
    'github_token' => env('GITHUB_TOKEN'),
    'github_username' => env('GITHUB_USERNAME'),
    'github_repository' => env('GITHUB_REPOSITORY'),

    'gitlab_token' => env('GITLAB_TOKEN'),
    'gitlab_username' => env('GITLAB_USERNAME'),
    'gitlab_repository' => env('GITLAB_REPOSITORY'),

    'github_timeout' => 100,

    'maintenance_mode' => true,
    'maintenance_mode_secret' => env('MAINTENANCE_MODE_SECRET', false),

    'before_update_pipelines' => [
        // you can add your own pipelines here
    ],

    // run php artisan migrate after update?
    'migrate' => true,

    // run seeders after update?
    'seeders' => [
        \Database\Seeders\DatabaseSeeder::class,
    ],

    // run php artisan cache:clear after update?
    'cache:clear' => true,

    // run php artisan view:clear after update?
    'view:clear' => true,

    // run php artisan config:clear after update?
    'config:clear' => true,

    // run php artisan route:clear after update?
    'route:clear' => true,

    // run php artisan optimize after update?
    'optimize' => true,

    'after_update_pipelines' => [
        // you can add your own pipelines here
    ],

];
