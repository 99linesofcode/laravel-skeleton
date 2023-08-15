<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tonysm\TurboLaravel\Http\PendingTurboStreamResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        PendingTurboStreamResponse::macro('flash', function ($message) {
            return turbo_stream()->append('notifications', view('layouts.notification', [
                'message' => $message,
            ]));
        });
    }
}
