<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Throwable;

class StartDevelopProject extends Command
{
    protected $signature = 'setup:develop';
    protected $description = 'Setup project to development mode.';

    public function handle(): void
    {
        $question = 'Do you want to start the develop configuration? make sure you have run this command in docker container. (y/n)';
        $answer = $this->askWithCompletion($question, ['y', 'n'], 'n');
        if ($answer === 'y') {
            $this->startProjectConfiguration();
            return;
        }
        $this->info('Project develop configuration aborted!');
    }

    private function startProjectConfiguration(): void
    {
        try {
            $this->warn('<====================================>');
            $this->warn('<===== Setup step one started... ====>');
            $this->warn('<====================================>');
            $this->info('');

            $this->info('=> Configuring backend keys...');
            system('php artisan key:mfp-key');
            $this->info('');

            $this->info('=> Applying permissions...');
            system('chown www-data:www-data -R storage/logs/');
            system('chown www-data:www-data -R storage/framework');
            system('chown 1000:1000 .env');
            system('chown 1000:1000 resources/frontend-v2/.env');
            $this->info('');

            $this->info('=> Cleaning caches...');
            $this->call('cache:clear');
            $this->call('config:clear');

            $this->info('=> Preparing database...');
            system('php artisan migrate --force --seed');
            $this->info('');

            $this->info('=> Creating user...');
            system('php artisan create:user');
            $this->info('');

            $this->info('=> Configuring frontend keys...');
            $this->addTokenOnFrontendEnv();
            $this->info('');

            $this->info('=> Cleaning caches...');
            $this->call('cache:clear');
            $this->call('config:clear');

            $this->warn('<====================================>');
            $this->warn('<===== Setup step one concluded! ====>');
            $this->warn('<====================================>');
            $this->info('');
            $this->alert('Run "make setup-frontend" in out of container to run setup step two');
            $this->info('');
            $this->info('User = demo@demo.dev');
            $this->info('Password = 12345678');
            $this->info('');
        } catch (Throwable $e) {
            $this->error($e->getMessage());
        }
    }

    private function addTokenOnFrontendEnv(): void
    {
        $inputBackend = file_get_contents('.env');
        $key = explode('PUSHER_APP_SECRET', explode('PUSHER_APP_KEY=', $inputBackend)[1])[0];
        $filepath = 'resources/frontend-v2/.env';
        $input = file_get_contents($filepath);
        $replaced = str_replace('VITE_MFP_TOKEN=', "VITE_MFP_TOKEN=$key", $input);
        if ($replaced === $input) {
            $this->error('Unable to set MFP-key key. No VITE_MFP_TOKEN variable was found in the frontend .env file.');
            return;
        }
        file_put_contents($filepath, $replaced);
    }
}
