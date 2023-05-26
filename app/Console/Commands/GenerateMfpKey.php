<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateMfpKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'key:mfp-key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save the MFP-key on .env file.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $key = md5(uniqid()) . md5(uniqid());
        if (! $this->setKeyInEnvironmentFile($key)) {
            $this->info('MFP-key generate error.');
            return;
        }
        $this->laravel['config']['pusher.app.key'] = $key;
        $this->info('MFP-key generate success.');
    }

    protected function setKeyInEnvironmentFile(string $key): bool
    {
        $filepath = $this->laravel->environmentFilePath();
        $input = file_get_contents($filepath);
        $replaced = preg_replace($this->keyReplacementPattern(), 'PUSHER_APP_KEY=' . $key, $input);
        if ($replaced === $input || $replaced === null) {
            $this->error('Unable to set MFP-key key. No PUSHER_APP_KEY variable was found in the .env file.');
            return false;
        }
        file_put_contents($filepath, $replaced);
        return true;
    }

    protected function keyReplacementPattern(): string
    {
        $escaped = preg_quote('=' . $this->laravel['config']['pusher.app.key'], '/');
        return "/^PUSHER_APP_KEY{$escaped}/m";
    }
}