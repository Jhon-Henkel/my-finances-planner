<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartDevelopProject extends Command
{
    protected $signature = 'start:develop-project';
    protected $description = 'Configure project to start development.';

    public function handle(): void
    {
        $question = 'Do you want to start the develop configuration? make sure you have the .env file configured ';
        $question .= 'and run this command in docker container. (y/n)';
        $options = ['y', 'n'];
        $default = 'n';
        $this->askWithCompletion($question, $options, $default) === 'y'
            ? $this->startProjectConfiguration()
            : $this->info('Project develop configuration aborted!');
    }

    protected function startProjectConfiguration(): void
    {
        $this->info('<===============================>');
        $this->info('<=== Starting configurations ===>');
        $this->info('Installing and updating dependencies...');
        $this->installDependencies();
        $this->info('=> Configuring keys...');
        $this->injectKeys();
        $this->info('=> Applying permissions...');
        $this->applyPermissions();
        $this->info('=> Running migrations...');
        system('php artisan migrate');
        $this->info('=> Creating user...');
        system('php artisan create:user');
        $this->info('=> Running seeds...');
        system('php artisan db:seed');
        $this->info('<=== Project configured! ===>');
        $this->info('<===========================>');
        $this->info('Access the project at http://localhost after running "npm run dev" in your Docker container');
        $this->info('User = demo@demo.dev');
        $this->info('Password = 1234');
    }

    protected function installDependencies(): void
    {
        system('composer install');
        system('composer update');
        system('npm install');
        system('npm update');
    }

    protected function injectKeys(): void
    {
        system('php artisan key:generate');
        system('php artisan key:mfp-key');
    }

    protected function applyPermissions(): void
    {
        system('chown www-data:www-data -R storage/logs/');
        system('chown www-data:www-data -R storage/framework');
    }
}