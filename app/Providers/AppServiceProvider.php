<?php

namespace App\Providers;

use App\Models\CouncilCategory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (App::isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @see https://github.com/barryvdh/laravel-ide-helper?tab=readme-ov-file#installation
     */
    public function boot(): void
    {
        # Load the table to sharing the data
        if (Schema::hasTable('council_categories')) {
            View::share('councilCategories', CouncilCategory::all());
        }
    }
}
