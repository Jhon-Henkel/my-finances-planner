<?php

namespace App\Console\Commands;

use App\Enums\Database\DatabaseConnectionEnum;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Throwable;

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

            $this->info('=> Preparing master database...');
            system('php artisan migrate --database=' . DatabaseConnectionEnum::Master->value . ' --force');
            $this->info('');

            $this->info('=> Preparing test database...');
            system('php artisan migrate --database=' . DatabaseConnectionEnum::Test->value . ' --force');
            system('php artisan migrate --database=' . DatabaseConnectionEnum::Test->value . ' --force --path=database/migrations/tenant --seed');
            $this->info('');

            $this->info('=> Creating user...');
            system('php artisan create:user');
            $this->info('');

            $this->info('=> Preparing tenant database...');
            $result = DB::connection(DatabaseConnectionEnum::Master->value)->select('SELECT * FROM tenants ORDER BY id DESC LIMIT 1');

            config(['database.connections.' . DatabaseConnectionEnum::Tenant->value . '.database' => Crypt::decryptString($result[0]->database)]);
            config(['database.connections.' . DatabaseConnectionEnum::Tenant->value . '.username' => Crypt::decryptString($result[0]->username)]);
            config(['database.connections.' . DatabaseConnectionEnum::Tenant->value . '.password' => Crypt::decryptString($result[0]->password)]);
            $this->call('migrate', ['--database' => DatabaseConnectionEnum::Tenant->value, '--path' => 'database/migrations/tenant', '--seed' => true]);
            $this->info('');

            $this->info('=> Configuring frontend keys...');
            $this->addTokenOnFrontendEnv();
            $this->info('');

            $this->info('=> Configuring queue consumer keys...');
            $this->addTokenOnConsumerEnv();
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

    private function addTokenOnConsumerEnv(): void
    {
        $inputBackend = file_get_contents('.env');
        $key = explode('PUSHER_APP_SECRET', explode('PUSHER_APP_KEY=', $inputBackend)[1])[0];
        $filepath = 'queue-consumer/.env';
        $input = file_get_contents($filepath);
        $replaced = str_replace('APP_TOKEN=', "APP_TOKEN=$key", $input);
        if ($replaced === $input) {
            $this->error('Unable to set MFP-key key. No APP_TOKEN variable was found in the queue consumer .env file.');
            return;
        }
        file_put_contents($filepath, $replaced);
    }
}
