<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/** @codeCoverageIgnore */
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
        $this->info('<====================================>');
        $this->info('<===== Setup step one started... ====>');
        $this->info('<====================================>');
        $this->info('');

        $this->info('=> Make .env files...');
        system('cp .env.example .env');
        system('cp resources/frontend-v2/.env.example resources/frontend-v2/.env');
        system('chown www-data:www-data .env');
        system('chown www-data:www-data resources/frontend-v2/.env');
        $this->info('');

        $this->info('=> Configuring backend keys...');
        system('php artisan key:generate');
        system('php artisan key:mfp-key');
        $this->info('');

        $this->info('=> Applying permissions...');
        system('chown www-data:www-data -R storage/logs/');
        system('chown www-data:www-data -R storage/framework');
        system('chown 1000:1000 .env');
        system('chown 1000:1000 resources/frontend-v2/.env');
        $this->info('');

        $this->info('=> Running migrations...');
        system('php artisan migrate --force --database=mysql');
        system('php artisan migrate --force --database=mysql_testing');
        $this->info('');

        $this->info('=> Creating user...');
        system('php artisan create:user');
        $this->info('');

        $this->info('=> Running seeds...');
        system('php artisan db:seed');
        $this->info('');

        $this->info('=> Configuring frontend keys...');
        $this->addTokenOnFrontendEnv();
        $this->info('');

        $this->info('<====================================>');
        $this->info('<===== Setup step one concluded! ====>');
        $this->info('<====================================>');
        $this->info('');
        $this->info('Run "make setup-frontend" in out of container');
        $this->info('');
        $this->info('User = demo@demo.dev');
        $this->info('Password = 12345678');
        $this->info('');
    }

    private function addTokenOnFrontendEnv(): void
    {
        $inputBackend = file_get_contents('.env');
        $key = explode('PUSHER_APP_SECRET', explode('PUSHER_APP_KEY=', $inputBackend)[1])[0];
        $filepath = 'resources/frontend-v2/.env';
        $input = file_get_contents($filepath);
        $replaced = str_replace('VITE_MFP_TOKEN=', "VITE_MFP_TOKEN=$key", $input);
        if ($replaced === $input) {
            $this->error('Unable to set MFP-key key. No VITE_MFP_TOKEN variable was found in the .env file.');
            return;
        }
        file_put_contents($filepath, $replaced);
    }
}
