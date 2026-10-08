<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('admin', fn (User $user): bool => $user->isAdmin());

        View::composer('*', function ($view): void {
            try {
                $settings = Setting::allAsArray();
            } catch (\Throwable) {
                $settings = [];
            }

            $view->with('siteSettings', $settings);
            $view->with('siteName', $settings['website_name'] ?? config('app.name', 'BlogCraft'));
        });
    }
}
