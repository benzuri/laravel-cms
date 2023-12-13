<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\CategoryPost;
use App\Models\Setting;


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
        \View::composer('*', function ($view) {
            $menuCategories = CategoryPost::orderBy('name')->withCount('posts')->get();

            $view->with([
                'menuCategories' => $menuCategories->where('posts_count', '>', 0)->all()
            ]);
        });

        \View::composer('*', function ($view) {
            $settings = Setting::get();
            $view->with([
                'settings' => $settings
            ]);
        });
    }
}
