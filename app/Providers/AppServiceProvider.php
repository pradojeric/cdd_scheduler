<?php

namespace App\Providers;

use App\Models\Configurations\Settings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        //
        $config = null;
        if (Schema::hasTable('settings')) {
            $config = Settings::first();
        }

        View::share('config', $config);
    }
}
