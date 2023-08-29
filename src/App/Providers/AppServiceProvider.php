<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tonysm\TurboLaravel\Http\PendingTurboStreamResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PendingTurboStreamResponse::macro('flash', function ($message) {
            return turbo_stream()->append('notifications', view('layouts.notification', [
                'message' => $message,
            ]));
        });
    }
}
