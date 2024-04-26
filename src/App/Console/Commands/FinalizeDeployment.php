<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FinalizeDeployment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:finalize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize for production';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('migrate --force');
        Artisan::call('optimize');
        Artisan::call('importmap:optimize');
        Artisan::call('scout:sync-index-settings');
        Artisan::call('tailwindcss:build --prod');
    }
}
