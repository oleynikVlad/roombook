<?php

namespace App\Providers;

use App\Modules\Auth\Models\PersonalAccessToken;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

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
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        // Обмеження на відправку кодів (1 лист на хвилину з однієї IP)
        RateLimiter::for('send-code', function (Request $request) {
            return Limit::perMinute(1)->by($request->ip());
        });

        // Обмеження на перевірку коду (5 спроб на 5 хвилин для одного email)
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinutes(5, 5)->by($request->input('email'));
        });

        // Обмеження на бронювання кімнат (10 разів на хвилину з однієї IP)
        RateLimiter::for('room-booking.book', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });
    }
}
